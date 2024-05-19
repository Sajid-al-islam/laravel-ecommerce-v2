<?php

namespace App\Http\Livewire;

use App\Http\Controllers\CartController;
use App\Models\Product;
use Carbon\Carbon;
use Livewire\Component;

class HomePageProduct extends Component
{
    public $products;
    public $take;
    public $skip;
    public $total;
    public $total_page;
    public $view_product;
    public $current_page = 0;
    public $is_showModal = false;

    protected $listeners = [
        'viewProduct' => 'quickView',
        'CloseViewProduct' => 'closeQuickView',
        "loadMore" => 'nextPage'
    ];

    public function mount()
    {
        $this->products = [];
        $this->take = 20;
        $this->skip = 0;
        $this->current_page = 1;
        $this->total = Product::where('status', 1)->count();
        $this->total_page = ceil($this->total / $this->take);
        $this->get_products();
    }

    public function render()
    {
        return view('livewire.home-page-product');
    }

    public function quickView($product)
    {
        $this->is_showModal = true;
        $this->view_product = Product::find($product);
    }

    public function closeQuickView() {
        $this->is_showModal = false;
    }

    public function get_products()
    {
        $this->skip = ($this->current_page-1) * $this->take;
        $this->products = array_merge($this->products, Product::take($this->take)
        ->with('discounts', function($q) {
            $q->orderBy('created_at','DESC')->where('discount_last_date', '>', Carbon::now())
            ->select('id', 'product_id' ,'discount_percent', 'discount_amount', 'discount_last_date');
        })
        ->select([
            'products.id',
            'product_name',
            'is_top_product',
            'product_url',
            'brand_id',
            'selected_categories',
            'short_description',
            'cost',
            'sales_price',
            'call_for_price',
            'is_upcomming',
            'is_tba',
            'is_pre_order',
            'is_in_stock',
            'low_stock',
            'stock',
        ])
        ->with(['product_brand'])
        ->withSum('stocks','qty')
        ->withSum('sales','qty')
        ->skip($this->skip)
        ->orderBy('is_top_product','DESC')
        ->get()
        ->toArray());
        // dd($this->products);
    }

    public function details($id)
    {
        return redirect()->to("/product-details/$id");
    }

    public function nextPage()
    {
        // dd("working");
        if($this->current_page <= $this->total_page) {
            $this->current_page++;
            $this->get_products();
        }
    }

}
