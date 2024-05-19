<?php

namespace App\Http\Livewire\Components;

use App\Http\Controllers\CartController;
use Livewire\Component;

class CartCount extends Component
{
    private $cart_handler;
    public $carts;
    public $cart_count;
    public $message;

    protected $listeners = [
        'cartAdded' => 'add_product_to_cart',
        'cartRemoved' => 'render',
        'cartUpdated' => 'render'
    ];
    
    public function __construct() {
        $this->cart_handler = new CartController();
    }
    public function render()
    {
        $this->cart_count = $this->cart_handler->cart_count();
        return view('livewire.components.cart-count');
    }

    public function add_product_to_cart($id, $qty=1)
    {
        $this->cart_handler->add_to_cart($id, $qty);
        $this->cart_count = $this->cart_handler->cart_count();
        $this->message = "cart_added";
    }
}
