<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

class WebpayController extends Controller
{
    public function redirect(string $code)
    {
        $transaction = Transaction::firstWhere('code', $code);
        if (!$transaction) {
            return redirect()->route('checkout.cancel');
        }

        // client_secret almacena la URL de redirección devuelta por Webpay
        return view('livewire.transbank-redirect', [
            'url' => $transaction->client_secret,
            'token' => $transaction->code,
        ]);
    }
}
