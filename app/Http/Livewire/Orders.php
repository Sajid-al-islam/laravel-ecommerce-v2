<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Orders extends Component
{
    public $user; 
    protected $orders=[];
    public function render()
    {
        $this->user = Auth::user();
        if($this->user) {
            $this->orders = Order::where('user_id', $this->user->id)->paginate(20);
        }
        return view('livewire.orders', [
            'orders' => $this->orders
        ])->extends('layouts.app', [
            'meta' => [
                "title" => "My Orders" . " - " . $_SERVER['SERVER_NAME'],
            ],
        ]);
    }
}
