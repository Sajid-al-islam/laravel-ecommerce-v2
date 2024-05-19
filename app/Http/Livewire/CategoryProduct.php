<?php

namespace App\Http\Livewire;


use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CategoryProduct extends Component
{
    protected $products_query = null;
    protected $products = null;
    protected $brand_products_query = null;
    protected $previous_category = null;
    public $category_id;
    public $min_price = 1;
    public $max_price = 0;
    public $brands = [];
    public $sub_categories;
    public $category_name;
    public $brand_query = false;
    public $brand_id;
    public $view_product;
    public $paginate = "";
    public $bread_cumb = [];

    public function mount($id, $category_name)
    {
        $this->category_id = $id;
        $this->category_name = $category_name;
        $this->previous_category = session()->get('category_id');
        $this->sub_categories = Category::where('parent_id', $id)->select('id', 'name')->get();

        // initial check not filter added
        if ($this->checkBrandAndPrice()) {
            $this->brand_id = session()->get('brand_id');
            $price_range = [
                'min_price' => session()->get('min_price'),
                'max_price' => session()->get('max_price')
            ];

            $this->get_filter_product($this->brand_id, $price_range);
            $this->getBrands();
        } elseif ($this->checkBrand()) {

            $this->brand_id = session()->get('brand_id');
            $this->filterBrand($this->brand_id);
            $this->getBrands();
        } elseif ($this->checkOnlyPrice()) {
            $price_range = [
                'min_price' => session()->get('min_price'),
                'max_price' => session()->get('max_price')
            ];
            $this->PriceFilter($price_range);
            $this->getBrands();
        } elseif ($this->previous_category == $this->category_id) {
            $this->getProducts();
            $this->getBrands();
        } else {
            session()->forget('category_id');
            session()->forget('brand_id');
            session()->forget('min_price');
            session()->forget('max_price');
            $this->getProducts();
            $this->getBrands();
        }
    }

    public function checkBrand()
    {
        if (session()->has('brand_id') && !session()->has('min_price') && !session()->has('max_price') && $this->previous_category == $this->category_id) {
            return true;
        } else {
            return false;
        }
    }
    public function checkOnlyPrice()
    {
        if (!session()->has('brand_id') && session()->has('min_price') && session()->has('max_price') && $this->previous_category == $this->category_id) {
            return true;
        } else {
            return false;
        }
    }
    public function checkBrandAndPrice()
    {
        if (session()->has('brand_id') && session()->has('min_price') && $this->previous_category == $this->category_id) {
            return true;
        } else {
            return false;
        }
    }

    public function hydrate()
    {
        $this->getBrands();
    }

    public function filterBrand($brand_id)
    {
        session()->put('brand_id', $brand_id);
        session()->put('category_id', $this->category_id);
        $category_id = $this->category_id;
        $products_query = Product::whereExists(function ($query) use ($category_id) {
            $query->from('category_product')
                ->whereColumn('category_product.product_id', 'products.id')
                ->where('category_product.category_id', $category_id);
        })
            ->withSum('stocks', 'qty')
            ->withSum('sales', 'qty')
            ->where('brand_id', $brand_id);
        $this->products = $products_query->paginate(20);
        $this->make_paginate();
    }

    public function make_paginate()
    {
        $paginate = new LengthAwarePaginator($this->products->items(), $this->products->total(), 20);
        $paginate->setPath(session()->get('page_url'));
        $this->paginate = $paginate->links()->render();
    }

    public function PriceFilter($formData)
    {
        session()->put('category_id', $this->category_id);
        $price_filter = [
            "min_price" => $formData['min_price'],
            "max_price" => $formData['max_price']
        ];
        session()->put('min_price',  $formData['min_price']);
        session()->put('max_price',  $formData['max_price']);

        $this->products_query = Product::whereExists(function ($query) {
            $query->from('category_product')
                ->whereColumn('category_product.product_id', 'products.id')
                ->where('category_product.category_id', $this->category_id);
        })
            ->whereBetween('sales_price', [(int) $price_filter['min_price'], (int) $price_filter['max_price']])
            ->withSum('stocks', 'qty')
            ->withSum('sales', 'qty');

        if (session()->has('brand_id')) {
            $brand_id = session()->get('brand_id');
            $this->products_query->where('brand_id', $brand_id);
        }

        $this->products = $this->products_query->paginate(20);
        $this->make_paginate();
    }

    public function getProducts()
    {
        session()->put('category_id', $this->category_id);
        $this->products_query = Product::whereExists(function ($query) {
            $query->from('category_product')
                ->whereColumn('category_product.product_id', 'products.id')
                ->where('category_product.category_id', $this->category_id);
        })
            ->withSum('stocks', 'qty')
            ->withSum('sales', 'qty');
        $this->products = $this->products_query->paginate(20);
        $this->make_paginate();
    }

    public function get_filter_product($brand_id, $price_range)
    {
        session()->put('category_id', $this->category_id);
        session()->put('min_price',  $price_range['min_price']);
        session()->put('max_price',  $price_range['max_price']);
        $this->products_query = Product::whereExists(function ($query) {
            $query->from('category_product')
                ->whereColumn('category_product.product_id', 'products.id')
                ->where('category_product.category_id', $this->category_id);
        })
            ->where('brand_id', $brand_id)
            ->withSum('stocks', 'qty')
            ->withSum('sales', 'qty')
            ->whereBetween('sales_price', [(int) $price_range['min_price'], (int) $price_range['max_price']]);
        // $this->getBrands();
        $this->products = $this->products_query->paginate(20);
        $this->make_paginate();
    }

    public function getPriceProduct($price_range)
    {
        $this->products_query = Product::whereExists(function ($query) {
            $query->from('category_product')
                ->whereColumn('category_product.product_id', 'products.id')
                ->where('category_product.category_id', $this->category_id);
        })
            ->withSum('stocks', 'qty')
            ->withSum('sales', 'qty')
            ->whereBetween('sales_price', [(int) $price_range['min_price'], (int) $price_range['max_price']]);
        // $this->getBrands();
        $this->products = $this->products_query->paginate(20);
        $this->make_paginate();
    }


    public function getBrands()
    {
        $category_id = $this->category_id;
        $this->brands = DB::table('category_product')
            ->join('product_brands', 'category_product.product_id', '=', 'product_brands.product_id')
            ->join('brands', 'brands.id', '=', 'product_brands.brand_id')
            ->select('category_product.*', 'product_brands.*', 'brands.name')
            ->where('category_id', $this->category_id)
            ->get()->unique('brand_id');
    }

    public function render()
    {
        // $temp = $this->products_query->paginate(20);
        // $pagination_links = $temp->links()->render();

        // $url = session()->get('category_url');
        // $pagination_links = str_replace("livewire/message/", "", $pagination_links);
        // $pagination_links = str_replace(url('')."/category-product?", $url."?", $pagination_links);
        // dump($this->products);

        return view('livewire.category-product', [
            'all_products' => $this->products,
        ])
            ->extends('layouts.app', [
                'meta' => [
                    "title" => $this->category_name . " - " . $_SERVER['SERVER_NAME'],
                ],
            ]);
    }
}
