<?php

namespace App\Http\Livewire;

use App\Facades\Cart;
use Livewire\Component;

class TopCart extends Component
{
    public $cartCount = 0;
    protected $listeners = ['addToCart' => 'addProductToCart', 'cartChanged' => 'updateCount'];

    public function mount(): void
    {
        $this->updateCount();
    }

    public function updateCount()
    {
        $this->cartCount = Cart::totalQuantity();
    }

    public function addProductToCart($product)
    {
        Cart::add($product, 1);
        $this->updateCount();
        
        // Emit JavaScript event to open cart menu
        $this->dispatchBrowserEvent('open-cart-menu');
    }

    public function render()
    {
        return view('livewire.top-cart');
    }
}
