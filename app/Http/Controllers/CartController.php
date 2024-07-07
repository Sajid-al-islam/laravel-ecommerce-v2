<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Product\ProductVariantValueProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public $cart = [];

    public function __construct()
    {
        // if(auth()->check()) {
        //     $this->cart = Cart::Where('user_id', auth()->user()->id)->get();
        // }else {
        // }
        if (Session::has("carts")) {
            $this->cart = Session::get("carts");
        }
        // dd(session()->all());
    }

    public function cart()
    {
        $cart_handler = new CartController();
        $carts = $cart_handler->get();
        $cart_total = $cart_handler->cart_total();
        $cart_amount = $cart_handler->cart_count();
        return view('frontend.cart', [
            'carts' => $carts,
            'cart_total' => $cart_total,
            'cart_amount' => $cart_amount,
        ]);
    }

    public function add_to_cart($id, $qty, $variant=null, $coupon_amount=0)
    {

        foreach ($this->cart as $key => $value) {
            if ($value['product']->id == $id && $variant != $value['variant']) {
                $value['qty'] = $qty;
                $value['variant'] = $variant;
                return $this->cart;
            }
        }

        $product = Product::where('id', $id)
            ->where('status', 1)
            ->select("id", "product_name", "sales_price")
            ->with(['discounts','related_image' => function ($q) {
                $q->select('id', 'product_id', 'image');
            }])
            ->first();


        if (isset($product->discounts) && $product->discounts) {
            $price = (float)$product->sales_price - (float)$product->discounts['discount_amount'];
        } else {
            $price = (float)$product->sales_price;
        }

        if(!empty($variant)) {
            $product_variant = ProductVariantValueProduct::where('product_id', $id)->where('product_variant_value_id', $variant)->first();
            $price = $product_variant->variant_price;
        }

        if (!is_numeric($price)) {
            $price = 0;
        }


        $temp_arr = [
            "product" => $product,
            "qty" => $qty,
            "price" => $price,
            "variant" => $variant,
        ];

        array_push($this->cart, collect($temp_arr));
        $this->cart_save();
    }

    public function cart_save()
    {
        Session::put('carts', $this->cart);
    }

    public function cart_count()
    {
        $count = count($this->cart);
        return $count;
    }

    public function cart_total()
    {
        $total = 0;
        foreach ($this->cart as $value) {
            // if($value['product']->id == $id)

            if (is_numeric($value['price'])) {
                $total += $value['price'] * $value['qty'];
            } else {
                0 * $value['qty'];
            }
        }
        return $total;
    }

    public function qty_increase($id)
    {
        foreach ($this->cart as $key => $value) {
            if ($value['product']->id == $id) {
                $value['qty'] += 1;
            }
        }
        $this->cart_save();
        return $this->cart;
    }
    public function qty_decrease($id)
    {
        foreach ($this->cart as $key => $value) {
            if ($value['product']->id == $id) {
                if ($value['qty'] > 0) {
                    $value['qty'] -= 1;
                }
            }
        }
        $this->cart_save();
        return $this->cart;
    }
    public function remove($id)
    {
        foreach ($this->cart as $key => $value) {
            if ($value['product']->id == $id) {
                array_splice($this->cart, $key, 1);
                $this->cart_save();
            }
        }

        return $this->cart;
    }

    public function emptyCart()
    {
        $status = false;
        $empty_cart = session()->forget('carts');
        if($empty_cart) {
            $status = true;
        }
        return $status;
    }

    public function qty_change($qty, $id)
    {
        foreach ($this->cart as $key => $value) {
            if ($value['product']->id == $id) {
                $qty = (int)$qty;
                if ($value['qty'] > 0) {
                    $value['qty'] = $qty;
                }
            }
        }
        $this->cart_save();
        return $this->cart;
    }

    public function get($id = null)
    {
        if ($id) {
        } else {
            return $this->cart;
        }
    }
}
