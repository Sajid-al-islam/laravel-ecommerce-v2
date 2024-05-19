<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderComplete extends Component
{
    public $order;
    public function mount($id)
    {
        $this->order = Order::where('id', $id)->with(['order_address', 'order_details'])->first();
    }
    public function render()
    {
        return view('livewire.order-complete')->extends('layouts.app');
    }
}
