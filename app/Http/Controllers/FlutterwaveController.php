<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventTicket;
use App\Models\Order;
use App\Models\TicketPayment;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast\Double;

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
                'redirect_url' => route('ticket_callback'),
                'success_url' => route('ticket_callback'),
                'failure_url' => route('ticket_callback'),
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
    protected function vat_vas($amount)
    {
        return ($amount * 0.075) + ($amount * 0.05);
    }
    public function checkout()
    {
        $this->cart_items = Auth::user()->selected_cart_items;
        $this->summary(); // Call the summary method to update totals
        try {
            $tx_ref =  generate_tx_ref();
            foreach ($this->cart_items as $item) {
                $order = new Order();
                $order->user_id = Auth::id();
                $order->item_id = $item->id;
                $order->tx_ref = $tx_ref;
                $order->external_tx_ref = $item->tx_ref;
                $order->currency = 'NGN';
                $order->status = 'pending';
                $order->quantity = $item->quantity;
                $price = $item->variant_id ? $item->product->variants->find($item->variant_id)->sale_price : $item->product->sale_price;

                $order->unit_price = $price;
                $order->total_price = $price * $item->quantity;
                $order->save();
            }
            $controller = flutterwave_payment();
            $data = [
                'payment_method' => 'card,banktransfer',
                'amount' => (int) $this->total['price'] + $this->vat_vas($this->total['price']) - $this->total['discount'] + $this->total['shipping'],
                'email' => Auth::user()->email ?? 'abituhi7s@mozmail.com',
                'tx_ref' => $tx_ref,
                'first_name' => Auth::user()->first_name ?? 'ALi',
                'last_name' => Auth::user()->last_name ?? 'Musa',
                'currency' => 'NGN',
                'redirect_url' => route('checkout_callback'),
                'success_url' => route('checkout_callback'),
                'failure_url' => route('checkout_callback'),
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
            $transaction = new Transaction();
            $transaction->wallet_id = Auth::user()->wallet->id;
            $transaction->amount = $this->total['price'] + $this->vat_vas($this->total['price']) - $this->total['discount'] + $this->total['shipping'];
            $transaction->type = 'credit';
            $transaction->status = 'pending';
            $transaction->tx_ref = $tx_ref;
            $transaction->currency = 'NGN';
            $transaction->description = 'Cart checkout';
            $transaction->sender_id = 1;
            $transaction->save();
            $controller->process($data);
        } catch (\Exception $e) {
            Log::error('Payment initialization failed: ' . $e->getMessage());
            abort(500, "An error occurred during the payment process. Please try again.");
        }
    }
    public function checkout_callback(Request $request)
    {
        $validated = $request->validate([
            'tx_ref' => 'required|string',
        ]);

        try {
            // Retrieve the transaction
            $transaction = Transaction::where('tx_ref', $validated['tx_ref'])->first();
            if (!$transaction) {
                Log::error('Transaction not found: ' . json_encode($validated));
                abort(404, "Transaction not found. Please contact support! tx_ref: " . $validated['tx_ref']);
            }
            // Verify payment
            $response = varify_payment($validated['tx_ref']);
            if ($response->status !== 'success') {
                Log::error('Payment verification failed: ' . json_encode($response));
                abort(500, "Payment verification failed. Please contact support.");
            }

            // fund user wallet
            $wallet = Wallet::find(Auth::user()->wallet->id);
            if (!$wallet) {
                Log::error('User wallet not found: ' . json_encode($response));
                abort(404, "User Wallet not found. Please contact support! tx_ref: " . $validated['tx_ref']);
            }
            $wallet->balance += $transaction->amount;
            $wallet->save();

            DB::beginTransaction();
            if ($transaction->status === 'pending') {
                // Update transaction status
                $transaction->status = 'completed';
                $transaction->save();

                // Retrieve and sumonize the orders
                $orders = Order::where('tx_ref', $validated['tx_ref'])->get();
                $total_order_price = 0;
                foreach ($orders as $order) {
                    $total_order_price += $order->total_price;
                }
                if ($total_order_price <= $transaction->amount) {
                    $transaction->status = 'completed';
                    $transaction->save();
                    foreach ($orders as $order) {
                        $order->status = 'completed';
                        $order->save();
                        // Update stock or sold counts
                        $origal_product = null;
                        if ($order->item->product->variant) {
                            $origal_product = $order->item->product->variants->find($order->item->variant_id);
                            $origal_product->quantity -= $order->quantity;
                            $origal_product->save();
                        } else {
                            $origal_product = $order->item;
                            $origal_product->quantity -= $order->quantity;
                            $origal_product->save();
                        }
                        // Update the original product stock
                        $origal_product = $order->item->product;
                        $origal_product->sold += $order->quantity;
                        $origal_product->save();
                        // Transfer credit to the client
                        $this->transfer_credit($wallet->id, $origal_product->client->wallet->id, $order->total_price, 'Cart checkout');
                        // update cart item status
                        $cart_item = Auth::user()->cart_items->find($order->item_id);
                        if ($cart_item) {
                            $cart_item->is_selected = false;
                            $cart_item->status = 'comfirmed';
                            $cart_item->save();
                        }
                    }
                    DB::commit();
                    return redirect()->route('app', ['tx_ref' => $validated['tx_ref']])
                        ->with('success', 'Your orders has been placed successfully!');
                } else {
                    //dd everything
                    // dd($response, $transaction, $orders, $total_order_price, $transaction->amount);
                    $transaction->status = 'failed';
                    $transaction->save();
                    Log::error('Transaction amount mismatch [cart checkout]: ' . json_encode($response) . ' tx_ref: ' . $validated['tx_ref']);

                    return redirect()->route('app', ['tx_ref' => $validated['tx_ref']])
                        ->withErrors('An error occurred. tx_ref: ' . $validated['tx_ref'] . '. Transaction amount mismatch. Please contact support.');
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Callback processing failed: ' . $e->getMessage());
            abort(500, "An error occurred during the callback process. Please try again.");
        }
    }
    public function ticket_callback(Request $request)
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
            // Create a new transaction record

            $target_wallet->save();
            $transaction = new Transaction();
            $transaction->wallet_id = $target_wallet->id;
            $transaction->amount = $amount;
            $transaction->type = 'credit';
            $transaction->status = 'completed';
            $internal_ref = generate_transaction_hash($transaction->toArray());
            $transaction->tx_ref = $internal_ref;
            $transaction->currency = 'NGN';
            $transaction->description = $description ?? 'Transfer from ' . $wallet->label . ' to ' . $target_wallet->label;
            $transaction->sender_id = Auth::user()->wallet->id; // Assuming the sender is the authenticated user
            $transaction->save();



            // Commit the transaction
            DB::commit();
            return $internal_ref;
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
}
