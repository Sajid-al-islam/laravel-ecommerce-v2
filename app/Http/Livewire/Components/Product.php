<?php

namespace App\Http\Livewire\Components;

use App\Http\Controllers\CartController;
use Livewire\Component;

class Product extends Component
{
    protected $product=[];

    public function mount($product)
    {
        $this->product = $product;
    }

    public function render()
    {
        return view('livewire.product', [
            'product' => $this->product
        ]);
    }
}
