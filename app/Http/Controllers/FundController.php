<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\TransactionHistory;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FundController extends Controller
{
    public function fund_wallet(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'wallet_id' => 'required|string',
        ]);

        $user = auth()->user();
        $wallet = Wallet::find(read($request->wallet_id));
        if (!$user || !$wallet) {
            return redirect()->back()->with('error', 'Invalid wallet or user');
        }
        try {
            $controller = flutterwave_payment();
            $tx_ref = generate_tx_ref();
            $exchange_rate = system_exchange_rate('NGN', 'NGN', $request->amount);
            // dd($exchange_rate, $request);
            $data = [

                'payment_method' => 'card,banktransfer',
                'amount' => (int) $request->amount,
                'email' => Auth::user()->email ?? 'abituho7s@mozmail.com',
                'tx_ref' => $tx_ref,
                'first_name' => Auth::user()->first_name ?? 'ALi',
                'last_name' => Auth::user()->last_name ?? 'Musa',
                'currency' => 'NGN',
                'redirect_url' => route('fund_wallet_callback'),
                'success_url' => route('fund_wallet_callback'),
                'failure_url' => route('fund_wallet_callback'),
                'customer' => [
                    'email' => Auth::user()->email ?? 'abituho7s@mozmail.com',
                    "phone_number" => Auth::user()->phone_number ?? '08165141519',
                    "name" => Auth::user()->name ?? 'ALmax'
                ],
                "customizations" => [
                    "title" => 'Wallet Funding',
                    "description" => "Fund your wallet",
                ]
            ];
            DB::beginTransaction();
            $history = $wallet->history()->create([
                'amount' => $request->amount,
                'tx_ref' => $tx_ref,
                'status' => 'pending',
                'type' => 'credit',
                'description' => "Funding wallet",
            ]);
            DB::commit();
            $controller->process($data);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Payment initialization failed: ' . $e->getMessage());
            abort(500, "An error occurred during the payment process. Please try again.");
        }
    }
    /**
     * Handles the callback after a user attempts to fund their wallet.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function fund_wallet_callback(Request $request)
    {
        // 1. Validate the incoming request
        $validated = $request->validate([
            'tx_ref' => 'required|string',
        ]);
        $tx_ref = $validated['tx_ref'];

        // 2. Find the transaction history record
        $history = TransactionHistory::where('tx_ref', $tx_ref)->first();

        if (!$history) {
            Log::error("Transaction not found for tx_ref: {$tx_ref}", $validated);
            return redirect()->route('app')->with('error', 'Transaction not found. Please contact support.');
        }

        // 3. Verify the payment using a dedicated service/function
        $verificationResponse = $this->verifyPayment($tx_ref);

        if (!$verificationResponse['success']) {
            Log::error("Payment verification failed for tx_ref: {$tx_ref}", $verificationResponse['data']);
            return redirect()->route('app')->with('error', $verificationResponse['message']);
        }

        // 4. Process successful payment
        return $this->processSuccessfulPayment($history, $verificationResponse['data']);
    }

    /**
     * Verifies the payment using an external service or internal logic.
     *
     * @param string $transactionReference
     * @return array
     */
    protected function verifyPayment(string $transactionReference): array
    {
        // Replace this with your actual payment verification logic
        $response = varify_payment($transactionReference);

        if ($response->status === 'success') {
            return [
                'success' => true,
                'message' => 'Payment verified successfully.',
                'data' => $response->data,
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Payment verification failed. Please contact support.',
                'data' => (array) $response, // Cast to array for consistency
            ];
        }
    }

    /**
     * Processes a successful payment and updates the user's wallet.
     *
     * @param \App\Models\TransactionHistory $history
     * @param object $paymentData
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function processSuccessfulPayment(TransactionHistory $history, object $paymentData)
    {
        $walletId = $history->wallet_id;
        // Eager load the wallet and its NGN asset to reduce database queries
        $wallet = Wallet::with(['assets' => function ($query) {
            $query->whereHas('origin', function ($q) {
                $q->where('sign', 'NGN');
            });
        }])->findOrFail($walletId);

        DB::beginTransaction();
        try {
            $exchangeRateData = system_exchange_rate('NGN', 'NGN', $paymentData->amount_settled);
            $fee = $exchangeRateData['fee'];
            $amountToCredit = $exchangeRateData['total'];

            // Get or create the NGN asset for the target wallet
            $targetWalletAssetNgn = $this->getOrCreateWalletAsset($wallet, 'NGN');
            $targetWalletAssetNgn->amount += $amountToCredit;
            $targetWalletAssetNgn->save();

            // Get or create the NGN asset for the reserved wallet (ID 1)
            $reservedWallet = Wallet::with(['assets' => function ($query) {
                $query->whereHas('origin', function ($q) {
                    $q->where('sign', 'NGN');
                });
            }])->find(1);
            $reservedWalletAssetNgn = $this->getOrCreateWalletAsset($reservedWallet, 'NGN');
            $reservedWalletAssetNgn->amount += $fee / 2;
            $reservedWalletAssetNgn->save();

            // Get or create the NGN asset for the admin's fee wallet (assuming admin user ID is 1)
            $admin = User::with('wallet')->find(1);
            // dd($admin->wallet, Auth::user()->wallet);
            if (!$admin || !$admin->wallet) {
                throw new \Exception('Admin wallet not found');
            }
            $feeWallet = Wallet::with(['assets' => function ($query) {
                $query->whereHas('origin', function ($q) {
                    $q->where('sign', 'NGN');
                });
            }])->find($admin->wallet->id);
            $feeWalletAssetNgn = $this->getOrCreateWalletAsset($feeWallet, 'NGN');
            $feeWalletAssetNgn->amount += $fee / 2;
            $feeWalletAssetNgn->save();

            // Update transaction history status
            $history->status = 'completed';
            $history->save();

            DB::commit();
            return redirect()->route('app')->with('success', 'Wallet funded successfully');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error updating wallet balance:', ['error' => $e->getMessage(), 'tx_ref' => $history->tx_ref]);
            return redirect()->route('app')->with('error', 'An error occurred while updating your wallet. Please contact support.');
        }
    }

    /**
     * Gets the wallet asset for a given currency or creates it if it doesn't exist.
     *
     * @param \App\Models\Wallet $wallet
     * @param string $currencySign
     * @return \App\Models\WalletAsset
     */
    protected function getOrCreateWalletAsset(Wallet $wallet, string $currencySign)
    {
        $walletAsset = $wallet->assets->firstWhere(function ($asset) use ($currencySign) {
            return $asset->origin->sign === $currencySign;
        });

        if (!$walletAsset) {
            $asset = Asset::where('sign', $currencySign)->firstOrFail();
            $walletAsset = $wallet->assets()->create([
                'asset_id' => $asset->id,
                'amount' => 0,
            ]);
        }

        return $walletAsset;
    }
}
