<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function website()
    {
        $category_products = Category::select('id', 'name')->where('status', 1)->with(['products' => function($q) {
            $q->where('status', 1);
        }])->get();
        return view('frontend.home', compact('category_products'));
    }

    public function aboutus()
    {
        return view('frontend.aboutus');
    }

    public function privacy_policy()
    {
        return view('frontend.privacy_policy');
    }

    public function terms()
    {
        return view('frontend.terms');
    }

    public function refund_policy()
    {
        return view('frontend.refund_policy');
    }

    public function product_details($id, $product_name)
    {
        $product = Product::where('id', $id)
            ->withSum('stocks', 'qty')
            ->withSum('sales', 'qty')
            ->with('product_brand')
            ->first();
        return view('frontend.product-details', compact('product'));
    }

    public function organic_oil(Request $request) {
        $products = Product::where('is_hair', 1)->get();
        return view('frontend.organic_oil', compact('products'));
    }

    public function invoice_download($invoice)
    {
        $order_details = Order::where('invoice_id', $invoice)->with(['order_address', 'order_payments', 'order_details' => function ($q) {
            $q->with('product');
        }])->first();

        return view('backend.invoice', compact('order_details', $order_details));
    }

    public function category_products($id, $category_name)
    {

        $category = Category::where('id', $id)->first();
        $min_product_price = Product::select('selected_categories', 'sales_price')->whereJsonContains('selected_categories', $id)->orderBy('sales_price', 'ASC')->first();
        $max_product_price = Product::select('selected_categories', 'sales_price')->whereJsonContains('selected_categories', $id)->orderBy('sales_price', 'DESC')->first();

        if ($min_product_price) {
            $min_product_price = $min_product_price->sales_price;
        } else {
            $min_product_price = 0;
        }

        if ($max_product_price) {
            $max_product_price = $max_product_price->sales_price;
        } else {
            $max_product_price = 0;
        }

        return view('frontend.category_products', compact('category', 'min_product_price', 'max_product_price'));
    }

    public function add_to_cart(Request $request)
    {
        $cart = new CartController();
        $cart->add_to_cart($request->id, $request->qty, $request->size);
        return response()->json([
            'cart' => $cart->get(),
            "message" => "Cart added",
            'cart_count' => $cart->cart_count(),
            "cart_total" => $cart->cart_total(),
            "cart_total_formated" => number_format($cart->cart_total()),
        ], 200);
    }

    public function remove_cart(Request $request)
    {
        $cart = new CartController();
        $cart->remove($request->id);
        return response()->json([
            'cart' => $cart->get(),
            "message" => "cart removed",
            'cart_count' => $cart->cart_count(),
            "cart_total" => $cart->cart_total(),
            "cart_total_formated" => number_format($cart->cart_total()),
        ], 200);
    }

    public function clear_cart()
    {
        session()->forget('carts');
    }

    public function single_product_details($id)
    {
        $product = Product::find($id);
        return view('livewire.quick-view-product', compact('product'))->render();
    }

    public function cart_all()
    {
        ddd(session()->get('carts'));
    }

}
