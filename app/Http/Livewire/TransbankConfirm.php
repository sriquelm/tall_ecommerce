<?php

namespace App\Http\Livewire;

use App\Models\Transaction;
use Livewire\Component;

class TransbankConfirm extends Component
{
    public $token;

    public function mount($token)
    {
        $this->token = $token;
    }

    public function render()
    {
        $transaction = Transaction::firstWhere('code', $this->token);

        if ($transaction && $transaction->status) {
            if ($transaction->status === 'AUTHORIZED' || $transaction->status === 'APPROVED' || $transaction->status === 'SUCCESS') {
                return redirect()->route('order.success', ['order' => $transaction->order?->order_number]);
            }
            return redirect()->route('checkout.cancel');
        }

        return view('livewire.transbank-confirm');
    }
}
