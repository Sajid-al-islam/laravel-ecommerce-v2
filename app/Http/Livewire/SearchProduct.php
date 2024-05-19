<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;

class SearchProduct extends Component
{
    protected $products=[];
    public function mount($search)
    {
       
        $query = Product::where('status', 1)->withSum('stocks','qty')->withSum('sales','qty');
        if(strlen($search) > 0) {
            $query->where(function ($q) use ($search) {
                $q->Where('product_name', 'LIKE', '%' . $search . '%')
                ->orWhere('sales_price', 'LIKE', '%' . $search . '%');
            });
            $this->products = $query->paginate(20);
        }else {
            $this->products = null;
        }
    }
    public function render()
    {
        return view('livewire.search-product', [
            'products' => $this->products,
        ])->extends('layouts.app');
    }
}
