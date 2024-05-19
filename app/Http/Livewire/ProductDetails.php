<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Str;

class ProductDetails extends Component
{
    public $product_id;
    public $product;
    protected $listeners = [
        'product_cart_update' => 'product_cart_update'
    ];

    public function mount($id)
    {
        $this->product = Product::where('id',$id)
        ->withSum('stocks','qty')
        ->withSum('sales','qty')
        ->with('product_brand')
        ->first();
    }
    public function render()
    {
        if(isset($this->product->description)) {
            $meta_decription = strip_tags($this->product->description);
            $meta_decription = Str::limit($meta_decription, 300, '...');
        }
        return view('livewire.product-details', [
            'product' => $this->product,
        ])
        ->extends('layouts.app', [
            'meta' => [
                "title" => isset($this->product->product_name) ? $this->product->product_name . " - " . $_SERVER['SERVER_NAME'] :  "",
                "image" => isset($this->product->related_images[0]['image']) ? 'https://admin.ctgcomputer.com' . '/' . $this->product->related_images[0]['image'] : "",
                "og_image" => isset($this->product->related_images[0]['image']) ? 'https://admin.ctgcomputer.com' . '/' . $this->product->related_images[0]['image'] : "",
                "twitter_image" => isset($this->product->related_images[0]['image']) ? 'https://admin.ctgcomputer.com' . '/' . $this->product->related_images[0]['image'] : "",
                "description" => $meta_decription ?? "",
                "price" => isset($this->product->sales_price) ? $this->product->sales_price : "" ,
                "keywords" => isset($this->product->search_keywords) ? $this->product->search_keywords : ""
            ],
        ]);
    }
}
