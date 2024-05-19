<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Carbon\Carbon;
use Livewire\Component;

class OfferProduct extends Component
{
    protected $products=[];
    public function render()
    {
        $this->products = Product::whereExists(function ($query) {
            $query->from('discount_products')
                ->whereColumn('discount_products.product_id', 'products.id')
                ->where("discount_last_date",">", Carbon::now());
        })
        ->withSum('stocks','qty')
        ->withSum('sales','qty')
        ->paginate(20);
        return view('livewire.offer-product', [
            'products' => $this->products,
        ])->extends('layouts.app', [
            'meta' => [
                "title" => "Offer products, Best deal" . " - " . $_SERVER['SERVER_NAME'],
            ],
        ]);
    }
}
