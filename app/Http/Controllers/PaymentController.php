<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\TransbankService;
use App\Models\Transaction as PaymentTransaction;

class PaymentController extends Controller
{
    protected $transbankService;

    public function __construct(TransbankService $transbankService)
    {
        $this->transbankService = $transbankService;
    }

    public function success(Request $request)
    {
        $token = $request->get('token_ws');
        if (!$token) {
            return redirect()->route('checkout.cancel');
        }

        $webpay = $this->transbankService->makeTransaction();
        try {
            $response = $webpay->commit($token);
        } catch (\Throwable $e) {
            return redirect()->route('checkout.cancel');
        }

        // Update transaction & order
        $transaction = PaymentTransaction::where('code', $token)->first();
        if ($transaction) {
            $transaction->status = $response->getStatus();
            $transaction->result = $response;
            $transaction->order()?->update(['payment_status' => 'paid']);
            $transaction->save();
        }

        return redirect()->route('order.success', ['order' => $transaction?->order?->order_number]);
    }

    public function canceled(Request $request)
    {
        $token = $request->get('token_ws');
        if (!$token) {
            return view('shop.checkout-cancel');
        }

        $webpay = $this->transbankService->makeTransaction();
        try {
            $response = $webpay->commit($token);
        } catch (\Throwable $e) {
            return view('shop.checkout-cancel');
        }

        // Update transaction & order
        $transaction = PaymentTransaction::where('code', $token)->first();
        if ($transaction) {
            $transaction->status = $response->getStatus();
            $transaction->result = $response;
            $transaction->order()?->update(['payment_status' => 'canceled']);
            $transaction->save();
        }

        return view('shop.checkout-cancel');
    }
}
