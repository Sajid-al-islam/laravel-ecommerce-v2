<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\OrderDetails;
use Livewire\Component;

class OrderComplete extends Component
{
    public $order;
    public $total_amount = 0;
    public $skus=[];
    public function mount($id)
    {
        $this->order = Order::where('id', $id)->with(['order_address', 'order_details'])->first();
        if(isset($this->order) && !empty($this->order)){
            $this->total_amount = $this->order->total_price;
        }

        $this->skus = OrderDetails::where('order_id', $id)->get()->pluck('product_id');
    }
    public function render()
    {
        return view('livewire.order-complete')->extends('layouts.app');
    }
}
