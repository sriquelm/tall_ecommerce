<?php

namespace App\Http\Livewire;

use App\Models\Product;
use LivewireUI\Modal\ModalComponent;
use Illuminate\Database\Eloquent\Collection;

class TopSearch extends ModalComponent
{
    public $search = "";
    public $results = null;
    public $showResults = false;

    protected $rules = [
        'search' => 'nullable|string|max:255',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        
        if ($propertyName === 'search') {
            $this->searchProducts();
        }
    }

    public function searchProducts()
    {
        if (empty(trim($this->search)) || strlen(trim($this->search)) < 2) {
            $this->results = collect([]);
            $this->showResults = false;
            return;
        }

        $this->results = Product::where('active', true)
            ->where(function ($query) {
                $query->where('title', 'LIKE', '%' . $this->search . '%')
                      ->orWhere('description', 'LIKE', '%' . $this->search . '%');            })
            ->with(['media', 'category','variant'])
            ->take(8)
            ->get();

        $this->showResults = true;
    }

    public function selectProduct($productId)
    {
        $product = Product::find($productId);
        if ($product) {
            $this->closeModal();
            return redirect()->route('product.view', ['product' => $product->slug]);
        }
    }

    public function viewAllResults()
    {
        if (!empty(trim($this->search))) {
            $this->closeModal();
            return redirect()->route('products.index', ['search' => $this->search]);
        }
    }

    public function render()
    {
        return view('livewire.top-search');
    }
}
