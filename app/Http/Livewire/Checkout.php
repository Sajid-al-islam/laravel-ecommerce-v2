<?php

namespace App\Http\Livewire;

use App\Http\Controllers\CartController;
use Livewire\Component;

class Checkout extends Component
{
    private $cart_handler;
    public $carts;
    public $cart_total;
    public $shipping_method=0;
    public $order_total;

    public function __construct() {
        $this->cart_handler = new CartController();
    }
    public function updateShipping($value)
    {
        $this->shipping_method = $value;
        $this->order_total = $this->shipping_method + $this->cart_total;
    }

    public function render()
    {
        $this->carts = $this->cart_handler->get();
        $this->cart_total = $this->cart_handler->cart_total();
        $this->order_total = $this->shipping_method + $this->cart_handler->cart_total();
        return view('livewire.checkout')->extends('layouts.app');
    }
}
