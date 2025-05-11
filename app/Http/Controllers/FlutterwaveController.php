<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventTicket;
use App\Models\TicketPayment;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FlutterwaveController extends Controller
{

    /**
     * Initialize Rave payment process for wallet top up
     * @return void
     */
    public function new_ticket(Request $request)
    {
        // Validate incoming request
        // dd($request);
        $validated = $request->validate([
            'event_id' => 'required|string',
            'tx_ref' => 'required|string',
        ]);

        try {
            $controller = flutterwave_payment();
            $event = Event::find(read($request->event_id));
            if (!$event) {

                // dd($request);
                abort(404, "Ticket not found. Please contact support!");
            }

            // Start database transaction
            DB::beginTransaction();
            // Create a new transaction record
            $ticket_payment = new TicketPayment();
            $ticket_payment->user_id = Auth::id();
            $ticket_payment->event_id = $event->id;
            $ticket_payment->status = 'pending';
            $ticket_payment->reference = $validated['tx_ref'];
            $ticket_payment->internal_ref = $validated['tx_ref'];
            $ticket_payment->amount = $event->price;
            $ticket_payment->currency = 'NGN';
            $ticket_payment->meta = [
                'event_id' => $event->id,
                'user_id' => Auth::id(),
                'ip' =>  request()->ip(),
            ];

            $data = [
                'payment_method' => 'card,banktransfer',
                'amount' => (int) $event->price + 100,
                'email' => Auth::user()->email ?? 'abituho7s@mozmail.com',
                'tx_ref' => $validated['tx_ref'],
                'first_name' => Auth::user()->first_name ?? 'ALi',
                'last_name' => Auth::user()->last_name ?? 'Musa',
                'currency' => 'NGN',
                'redirect_url' => route('callback'),
                'success_url' => route('callback'),
                'failure_url' => route('callback'),
                'customer' => [
                    'email' => Auth::user()->email,
                    "phone_number" => Auth::user()->phone_number ?? '08165141519',
                    "name" => Auth::user()->name ?? 'ALmax'
                ],
                "customizations" => [
                    "title" => 'Ticket Purchase',
                    "description" => "Buy your ticket with ALmax"
                ]
            ];
            $ticket_payment->save();
            DB::commit();
            // Process payment
            $controller->process($data);
        } catch (\Exception $e) {
            // Rollback transaction in case of error
            DB::rollBack();
            Log::error('Payment initialization failed: ' . $e->getMessage());
            abort(500, "An error occurred during the payment process. Please try again.");
        }
    }
    protected $total = [
        'items' => 0,
        'price' => 0,
        'discount' => 0,
        'shipping' => 0,
    ];
    protected $cart_items = [];

    protected function summary()
    {
        $this->total['items'] = 0;
        $this->total['price'] = 0;
        $this->total['discount'] = 0;
        $this->total['shipping'] = 0;

        foreach ($this->cart_items as $item) {
            if (!$item->is_selected) continue;
            $this->total['items'] += $item->quantity;
            $price = $item->variant_id ? $item->product->variants->find($item->variant_id)->sale_price : $item->product->sale_price;
            $this->total['price'] += $price * $item->quantity;
            $this->total['discount'] += ($item->product->discount / 100) * ($price * $item->quantity);
            // $this->total['shipping'] += $item->shipping_cost;
        }
    }
    public function checkout()
    {
        $this->cart_items = Auth::user()->selected_cart_items;
        $this->summary(); // Call the summary method to update totals
        try {
            $controller = flutterwave_payment();
            $data = [
                'payment_method' => 'card,banktransfer',
                'amount' => (int) $this->total['price'] + 100,
                'email' => Auth::user()->email ?? 'abituhi7s@mozmail.com',
                'tx_ref' => generate_tx_ref(),
                'first_name' => Auth::user()->first_name ?? 'ALi',
                'last_name' => Auth::user()->last_name ?? 'Musa',
                'currency' => 'NGN',
                'redirect_url' => route('callback'),
                'success_url' => route('callback'),
                'failure_url' => route('callback'),
                'customer' => [
                    'email' => Auth::user()->email,
                    "phone_number" => Auth::user()->phone_number ?? '08165141519',
                    "name" => Auth::user()->name ?? 'ALmax'
                ],
                "customizations" => [
                    "title" => 'Ticket Purchase',
                    "description" => "Buy your ticket with ALmax"
                ]
            ];
            // Process payment
            dd($data);
            $controller->process($data);
        } catch (\Exception $e) {
            Log::error('Payment initialization failed: ' . $e->getMessage());
            abort(500, "An error occurred during the payment process. Please try again.");
        }
    }
    public function callback(Request $request)
    {
        // 1) Pull the query parameters
        $status         = $request->query('status');
        $tx_ref         = $request->query('tx_ref');
        $transaction_id = $request->query('transaction_id');

        // 2) Basic sanity checks
        if (!$tx_ref || !$transaction_id || $status !== 'completed') {
            Log::warning("Invalid callback parameters", [
                'status' => $status,
                'tx_ref' => $tx_ref,
                'transaction_id' => $transaction_id,
            ]);
            return redirect()->route('ticket.failure')
                ->withErrors('Invalid payment data.');
        }

        // 3) Fetch your pending record
        $payment = TicketPayment::where('reference', $tx_ref)
            // ->where('status', 'pending')
            ->first();

        if (! $payment) {
            Log::error("No pending payment record for tx_ref: {$tx_ref}");
            abort(404, 'Payment record not found.');
        }

        try {
            // 4) Verify with Flutterwave via your helper
            $verification = varify_payment($tx_ref);

            // 5) Check the returned object
            if (
                empty($verification->status) ||
                $verification->status !== 'success' ||
                empty($verification->data->status) ||
                $verification->data->status !== 'successful'
            ) {
                // Verification failed
                Log::error('Flutterwave verification failed', [
                    'response' => $verification,
                ]);
                $payment->status = 'failed';
                $payment->save();

                return redirect()->route('ticket.failure')
                    ->withErrors('Payment could not be verified.');
            }

            // 6) All good! Update your record
            $payment->status = 'completed';
            // $payment->transaction_id = $verification->data->id;
            // Optionally store the entire response payload
            $payment->meta = array_merge(
                $payment->meta,
                ['flutterwave' => (array) $verification->data]
            );
            $payment->save();


            $event_ticket = new EventTicket();
            $event_ticket->user_id = Auth::id();
            $event_ticket->event_id = $payment->event_id;
            $event_ticket->status = 'paid';
            $event_ticket->used_at = null;
            $event_ticket->qr_key = $tx_ref;
            $event_ticket->save();

            $user_wallet = Auth::user()->wallet;
            $user_wallet->balance += $event_ticket->event->price;
            $user_wallet->save();

            $client_wallet = Auth::user()->client->wallet;
            $this->transfer_credit($user_wallet->id, $client_wallet->id, $event_ticket->event->price, 'Event ticket purchase');
            // 7) Redirect to a app with the event ticket id and tx_ref
            return redirect()->route('app', ['ticket_id' => $event_ticket->id, 'tx_ref' => $tx_ref])
                ->with('success', 'Your ticket has been issued!');
        } catch (\Exception $e) {
            Log::error("Callback processing exception: " . $e->getMessage(), [
                'tx_ref' => $tx_ref,
            ]);
            return redirect()->route('app', ['ticket_id' => $event_ticket->id, 'tx_ref' => $tx_ref])
                ->withErrors('An error occurred. Please try again.');
        }
    }
    private function transfer_credit($wallet_id, $target_wallet_id, $amount, $description = null)
    {
        // Start database transaction
        DB::beginTransaction();
        try {
            // Fetch the wallets
            $wallet = Wallet::find($wallet_id);
            $target_wallet = Wallet::find($target_wallet_id);

            if (!$wallet || !$target_wallet) {
                throw new \Exception('Wallet not found');
            }

            // Update the wallet balances
            $wallet->balance -= $amount;
            $target_wallet->balance += $amount;

            // Save the changes
            $wallet->save();
            $target_wallet->save();
            $transaction = new Transaction();
            $transaction->wallet_id = $target_wallet->id;
            $transaction->amount = $amount;
            $transaction->type = 'credit';
            $transaction->status = 'completed';
            $transaction->tx_ref = generate_transaction_hash($transaction->toArray());
            $transaction->currency = 'NGN';
            $transaction->description = $description ?? 'Transfer from ' . $wallet->label . ' to ' . $target_wallet->label;
            $transaction->sender_id = Auth::id(); // Assuming the sender is the authenticated user
            $transaction->save();



            // Commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();
            Log::error('Transfer credit failed: ' . $e->getMessage());
        }
    }


    public function fallback(Request $request)
    {
        $validated = $request->validate([
            'tx_ref' => 'required|string',
        ]);

        try {
            // Find the TicketPayment by reference
            $ticketPayment = TicketPayment::where('internal_ref', $validated['tx_ref'])->firstOrFail();

            // Update the status to 'completed'
            $ticketPayment->status = 'completed';
            $ticketPayment->save();

            // Redirect to the event route
            return redirect()->route('event'); // Assuming 'event' is your route name
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error updating TicketPayment status: ' . $e->getMessage());

            // Optionally, redirect back with an error message
            return redirect()->route('events')->with('error', 'Failed to update ticket payment status.');
        }
    }
    // /**
    //  * Initialize Rave payment process External Payment
    //  * @return void
    //  */
    // public function checkout(Request $request)
    // {
    //     if (isset($request->checkout) and $request->checkout == 'checkout') {
    //         $items = Cart::where('client_id', Auth::user()->client_id)
    //             ->where('user_id', Auth::user()->id)
    //             ->where('status', 'pending')
    //             ->where('check', true)
    //             ->get();

    //         if ($items->isEmpty()) {
    //             // $this->alert('warning', 'No items selected for purchase.');
    //             return redirect()->route('cart.index');
    //         }

    //         DB::beginTransaction();

    //         try {
    //             $tx_ref = Rave::generateReference();

    //             // Initialize Order
    //             $order = new Order();
    //             $order->items_id = $items->pluck('id')->toArray(); // Collect item IDs
    //             $order->order_name = 'cart_purchase';
    //             $order->type = 'bulk';
    //             $order->status = 'pending';
    //             $order->quantity = count($items);
    //             $order->user_id = Auth::user()->id;
    //             $order->client_id = Auth::user()->client_id;
    //             $order->tx_ref = $tx_ref;
    //             $order->invoice_reference_code = $tx_ref;
    //             $order->price = 0;

    //             $total_price = 0;
    //             $total_discount = 0;

    //             foreach ($items as $item) {
    //                 $total_discount += $item->discount ?? 0;
    //                 $total_price += $item->origin->sale_price * $item->quantity;
    //                 $item->status = 'processing_with' . $tx_ref;
    //                 $item->save();
    //             }

    //             $order->price = $total_price - $total_discount;
    //             $revenue = system_bill($order->price, 'internal');
    //             $order->net_revenue = $revenue->net_revenue;
    //             $order->system_charge = $revenue->system_charge;
    //             $order->vas = $revenue->vas;
    //             $order->vat = $revenue->vat;
    //             $order->final_amount = $revenue->final_amount;
    //             $order->save();

    //             // Create Invoice
    //             $invoice = new Invoice();
    //             $invoice->user_id = Auth::user()->id;
    //             $invoice->client_id = Auth::user()->client_id;
    //             $invoice->order_id = $order->id;
    //             $invoice->type = 'bulk';
    //             $invoice->status = 'pending';
    //             $invoice->invoice_reference_code = $tx_ref;
    //             $invoice->save();
    //             DB::commit();

    //             try {
    //                 $controller = flutterwave_payment();


    //                 // Start database transaction
    //                 DB::beginTransaction();
    //                 // $ALmax = User::find(1);
    //                 $ALmax = Client::find(1);

    //                 // Create a new transaction record
    //                 $transaction = new Transaction();
    //                 $transaction->user_id = Auth::id();
    //                 $transaction->client_id = Auth::user()->client_id;
    //                 $transaction->status = 'pending';
    //                 $transaction->transaction_reference_code = $tx_ref;
    //                 $transaction->sending_addresss = 'invoice_' . $tx_ref;
    //                 $transaction->recieving_addresss = $ALmax->wallet->wallet_address;
    //                 $transaction->recievers_id = $ALmax->wallet->client_id;
    //                 $transaction->account_name = $ALmax->wallet->id;
    //                 $transaction->type = 'purchase';
    //                 $transaction->ALmax_token_before = $ALmax->wallet->balance;
    //                 $transaction->ALmax_token_after = $ALmax->wallet->balance;
    //                 $transaction->ngn_before = $ALmax->wallet->naira_balance;
    //                 $transaction->ngn_after = $ALmax->wallet->naira_balance + $order->final_amount;
    //                 // $transaction = new Transaction();

    //                 // $transaction->user_id = Auth::id();
    //                 // $transaction->client_id = Auth::user()->client_id;
    //                 // $transaction->status = 'pending';

    //                 // $transaction->transaction_reference_code = $validated['tx_ref'];

    //                 // $transaction->sending_addresss = "Flutterwave_to_ALmax_" . $validated['type'];
    //                 // $transaction->recieving_addresss = $wallet->wallet_address;
    //                 // $transaction->recievers_id = $validated['type'] === 'top_up' ? $wallet->user_id : $wallet->client_id;
    //                 // $transaction->account_name = $validated['type'] === 'top_up' ? $wallet->user->name : $wallet->client->name;
    //                 // $transaction->type = $validated['type'];


    //                 // $exchage_rate = system_exchange_rate($validated['currency'], 'NGN', $validated['amount']);
    //                 // $transaction->balance_before = $wallet->balance;

    //                 // $transaction->balance_after = $wallet->balance + $exchage_rate['total'];
    //                 // $transaction->amount = $wallet->balance + $exchage_rate['amount'];
    //                 // $transaction->fee = $wallet->balance + $exchage_rate['fee'];
    //                 // if (!Transaction::exists()) {
    //                 //     // If no transactions exist, generate a unique initial value for hash_before
    //                 //     $transaction->hash_before = generate_wallet_address(1);
    //                 // } else {
    //                 //     // Fetch the latest transaction and use its hash for hash_before
    //                 //     $transaction->hash_before = Transaction::latest('id')->value('hash');
    //                 // }

    //                 $transaction->hash = generate_transaction_hash($transaction->toArray());
    //                 // Save transaction record
    //                 try {
    //                     $transaction->save();
    //                 } catch (\Throwable $th) {
    //                     abort(500, "An error occurred during the payment process. Please try again after a moment.");
    //                 }

    //                 // Save transaction record
    //                 try {
    //                     $transaction->save();
    //                 } catch (\Throwable $th) {
    //                     abort(500, "An error occurred during the payment process. Please try again after a moment.");
    //                 }


    //                 $data = [
    //                     'payment_method' => 'card,banktransfer',
    //                     'amount' => $order->final_amount,
    //                     'email' => Auth::user()->email,
    //                     'tx_ref' => $tx_ref,
    //                     'first_name' => Auth::user()->first_name,
    //                     'last_name' => Auth::user()->last_name,
    //                     'currency' => "NGN",
    //                     'redirect_url' => route('checkout_callback'),
    //                     'success_url' => route('checkout_callback'),
    //                     'failure_url' => route('checkout_callback'),
    //                     'customer' => [
    //                         'email' => Auth::user()->email,
    //                         "phone_number" => Auth::user()->phone_number,
    //                         "name" => Auth::user()->name,
    //                     ],
    //                     "customizations" => [
    //                         "title" => 'Account Purchase',
    //                         "description" => "Item Purchase",
    //                     ],
    //                 ];

    //                 // Commit the transaction
    //                 DB::commit();

    //                 // Process payment
    //                 $controller->process($data);
    //             } catch (\Exception $e) {
    //                 // Rollback transaction in case of error
    //                 DB::rollBack();
    //                 Log::error('Payment initialization failed: ' . $e->getMessage());
    //                 abort(500, "An error occurred during the payment process. Please try again.");
    //             }
    //         } catch (\Exception $e) {
    //             DB::rollBack();
    //             Log::error('An unexpected error occurred: ' . $e);
    //             abort(500, "An error occurred during the payment process. Please try again.");
    //         }
    //     }
    // }
    // /**
    //  * Obtain Rave callback information 
    //  * @return void
    //  */
    // public function checkout_callback(Request $request)
    // {
    //     $validated = $request->validate([
    //         'tx_ref' => 'required|string',
    //     ]);

    //     try {
    //         // Retrieve the transaction
    //         $transaction = Transaction::where('transaction_reference_code', $validated['tx_ref'])->first();
    //         if (!$transaction) {
    //             abort(404, "Transaction not found. Please contact support! tx_ref: " . $validated['tx_ref']);
    //         }
    //         $wallet = Wallet::where('wallet_address', $transaction->recieving_addresss)->first();
    //         if (!$wallet) {
    //             abort(404, "User Wallet not found. Please contact support! tx_ref: " . $validated['tx_ref']);
    //         }

    //         // Verify payment
    //         $response = varify_payment($validated['tx_ref']);
    //         if ($response->status !== 'success') {
    //             Log::error('Payment verification failed: ' . json_encode($response));
    //             abort(500, "Payment verification failed. Please contact support.");
    //         }

    //         DB::beginTransaction();

    //         if ($transaction->status === 'pending') {
    //             // Update transaction status
    //             $transaction->status = 'completed';
    //             $transaction->save();

    //             // Retrieve and update the order
    //             $order = Order::where('tx_ref', $validated['tx_ref'])->first();
    //             if ($order) {
    //                 $order->status = 'completed';
    //                 $order->save();

    //                 // Update wallet balance
    //                 $wallet->naira_balance += $response->data->amount;
    //                 $wallet->save();

    //                 // Process items in the order
    //                 $items = Cart::whereIn('id', $order->items_id)->get();
    //                 foreach ($items as $item) {
    //                     $this->processItem($item, $wallet, $order, $validated['tx_ref']);
    //                 }
    //             }
    //         }

    //         DB::commit();

    //         return redirect()->route('cart.index');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('Callback processing failed: ' . $e->getMessage());
    //         abort(500, "An error occurred during the callback process. Please try again.");
    //     }
    // }

    // /**
    //  * Process individual item in the order.
    //  */
    // private function processItem($item, $wallet, $order, $tx_ref)
    // {
    //     // dd($item);
    //     // Create a new trade entry
    //     $trade = new Trade();
    //     $trade->type = $item->type;
    //     $trade->item_id = $item->id;
    //     $trade->order_id = $order->id;
    //     $trade->status = 'completed';
    //     $trade->quantity = $item->quantity ?? 1;
    //     $trade->stock_price = $item->origin->stock_price;
    //     $trade->price_per_each = $item->origin->sale_price;
    //     $trade->total_price = $item->final_total;
    //     $trade->discount_per_each = $item->origin->discount;
    //     $trade->total_discount = $item->discount;
    //     $trade->invoice_reference_code = $tx_ref;
    //     $trade->save();

    //     // Update stock or sold counts
    //     $origal_item = null;
    //     if ($item->type === 'product') {
    //         $origal_item = Product::find($item->origin->id);
    //         $origal_item->available_stock -= $item->quantity;
    //     } elseif ($item->type === 'service') {
    //         $origal_item = Service::find($item->origin->id);
    //     }

    //     if ($origal_item) {
    //         $origal_item->sold += $item->quantity;
    //         $origal_item->save();
    //     }

    //     // Handle wallet transactions
    //     // $client_wallet = Wallet::find($item->origin->client->wallet->id);
    //     // if ($client_wallet) {
    //     //     $this->updateWalletBalances($wallet, $client_wallet, $item, $tx_ref);
    //     // }
    // }

    // /**
    //  * Update wallet balances for user and client.
    //  */
    // private function updateWalletBalances($wallet, $client_wallet, $item, $tx_ref)
    // {
    //     // Update user wallet
    //     $wallet->naira_balance -= $item->final_total;
    //     $wallet->save();

    //     // Update client wallet
    //     $client_wallet->naira_balance += $item->final_total;
    //     $client_wallet->save();

    //     // Log user transaction
    //     // internal_transaction($wallet, $client_wallet, $item, $tx_ref);
    // }
    // /**
    //  * Obtain Rave callback information 
    //  * @return void
    //  */
    // public function callback(Request $request)
    // {
    //     $validated = $request->validate([
    //         'tx_ref' => 'required|string',
    //     ]);

    //     try {
    //         // Retrieve the transaction from the database
    //         $transaction = Transaction::where('transaction_reference_code', $validated['tx_ref'])->first();

    //         if (!$transaction) {
    //             abort(404, "Transaction not found. Please contact support! tx_ref: " . $validated['tx_ref']);
    //         }
    //         $wallet = Wallet::where('wallet_address', $transaction->recieving_addresss)->first();
    //         if (!$wallet) {
    //             abort(404, "User Wallet not found. Please contact support! tx_ref: " . $validated['tx_ref']);
    //         }
    //         $response = varify_payment($validated['tx_ref']);
    //         if ($response->status === 'success') {
    //             DB::beginTransaction();
    //             if ($transaction->status == 'pending' && !($transaction->status == 'cancelled')) {
    //                 $transaction->status = 'completed';
    //                 $exchage_rate = system_exchange_rate($response->data->currency, 'NGN', $response->data->amount);
    //                 $wallet->balance += $exchage_rate['total'];
    //                 $transaction->save();
    //                 system_notification(Auth::user()->id, 'Transaction Successful', 'Transaction Successfull. Amount: ' . $exchage_rate['total'] . ' tx_ref: ' . $validated['tx_ref'], 'success');
    //                 $wallet->save();
    //             }


    //             DB::commit();
    //             // dd($transaction, $wallet, $responses);

    //             if ($transaction->type == 'business_top_up') {
    //                 return redirect()->route('business.index');
    //             } else {
    //                 return redirect()->route('dashboard');
    //             }
    //         } elseif ($response->status === 'cancelled') {

    //             if ($transaction->status == 'pending' && !($transaction->status == 'cancelled')) {
    //                 $transaction->status = 'cancelled';
    //                 $exchage_rate = system_exchange_rate($response->data->currency, 'NGN', $response->data->amount);
    //                 system_notification(Auth::user()->id, 'Transaction cancelled', 'Transaction cancelled. Amount: ' . $exchage_rate['total'] . ' tx_ref: ' . $validated['tx_ref'], 'success');

    //                 $transaction->save();
    //             }
    //         } else {
    //             Log::error('Payment verification failed: ' . $response);
    //             abort(500, "Payment verification failed. Please contact support.");
    //         }
    //     } catch (\Exception $e) {
    //         if ($request->status === 'cancelled') {

    //             if ($transaction->status == 'pending' && !($transaction->status == 'cancelled')) {
    //                 $transaction->status = 'cancelled';
    //                 $transaction->save();

    //                 if ($transaction->type == 'business_top_up') {
    //                     return redirect()->route('business.index');
    //                 } else {
    //                     return redirect()->route('dashboard');
    //                 }
    //             }
    //         }
    //         Log::error('Callback processing failed: ' . $e->getMessage());
    //         abort(500, "An error occurred during the callback process. Please try again.");
    //     }
    // }
}
