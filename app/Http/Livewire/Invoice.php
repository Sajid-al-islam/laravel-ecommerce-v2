<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class Invoice extends Component
{
    public $order=null;
    public function mount($id)
    {
        $this->order = Order::where('id', $id)->with(['order_address', 'order_details'])->first();
    }
    public function render()
    {
        return view('livewire.invoice')->extends('layouts.app', [
            'meta' => [
                "title" => "Download invoice" . " - " . $_SERVER['SERVER_NAME'],
            ],
        ]);
    }
}
