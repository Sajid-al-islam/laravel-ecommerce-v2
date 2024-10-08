<?php

namespace App\Http\Livewire;

use App\Models\ProductReview;
use Livewire\Component;

class Review extends Component
{
    public $product_id;
    public $product_reviews;
    
    protected $listeners = [
        'reviewAdded' => 'render',
    ];

    public function render()
    {
        $this->product_reviews = ProductReview::where('product_id', $this->product_id)
        ->with('user')->get();
        return view('livewire.review');
    }

    public function removeReview($id)
    {
        ProductReview::where('id', $id)->delete();
        $this->render();
    }
}
