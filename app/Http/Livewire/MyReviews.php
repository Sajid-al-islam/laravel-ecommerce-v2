<?php

namespace App\Http\Livewire;

use App\Models\ProductReview;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyReviews extends Component
{
    public $user = [];
    protected $reviews=[];
    public function mount()
    {
        if(!Auth::check()) {
            return redirect()->route('website_login');
        }
    }
    public function render()
    {
        $this->user = Auth::user();
        if($this->user) {
            $this->reviews = ProductReview::where('user_id', $this->user->id)->with('product')->paginate(10);
        }
        return view('livewire.my-reviews', [
            'reviews' => $this->reviews
        ])->extends('layouts.app', [
            'meta' => [
                "title" => "Profile page" . " - " . $_SERVER['SERVER_NAME'],
            ],
        ]);
    }
}
