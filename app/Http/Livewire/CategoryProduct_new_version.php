<?php

namespace App\Http\Livewire;


use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CategoryProduct_copy extends Component
{
    protected $products_query = null;
    protected $products = null;
    protected $brand_products_query = null;
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

    public function mount($id, $category_name)
    {
        $this->category_id = $id;
        $this->category_name = $category_name;

        if (!strpos(url()->full(), 'livewire')) {
            session()->put('page_url',  explode('?', url()->full())[0]);
        }
        $previous_category = session()->get('category_id');

        $this->sub_categories = Category::where('parent_id', $id)->select('id', 'name')->get();
        // dd(session()->all());
        
        // initial check not filter added
        if($previous_category == null &&  $previous_category == $this->category_id && !session()->has('brand_id') && !session()->has('min_price') && !session()->has('max_price')) {
            session()->remove('category_id');
            session()->remove('brand_id');
            session()->remove('min_price');
            session()->remove('max_price');
            dd('from init');
            $this->getProducts();
            $this->getBrands();
        }

        // check if there was a filter in the previous category, if not load manual data
        if(isset($previous_category) && $previous_category !== $this->category_id) {
            session()->remove('category_id');
            session()->remove('brand_id');
            session()->remove('min_price');
            session()->remove('max_price');
            dd('from not matched');
            $this->getProducts();
            $this->getBrands();
        }
        else {
            // filter section
            dd('from filtered else');
            $this->getProducts();
            $this->getBrands();
            // checking if any brand is present in the filter
            if (session()->has('brand_id')) {
                dd('frome else brnad', session()->all());

                $this->brand_id = session()->get('brand_id');
                $this->getBrands();
                $this->filterBrand($this->brand_id);
            } elseif (!session()->has('brand_id') && session()->has('min_price') && session()->has('max_price')) {
                // checking if brand not present and min price and max price present in the filter
                dump('frome else price', session()->all());
                
                $price_filter = [
                    'min_price' => session()->get('min_price'),
                    'max_price' => session()->get('max_price')
                ];
                $this->min_price = session()->get('min_price');
                $this->max_price = session()->get('min_price');
                if($this->min_price == "" && $this->max_price == "") {
                    session()->remove('min_price');
                    session()->remove('max_price');
                }
                // dd('dd from min max', session()->all());
                $this->getBrands();
                $this->getPriceProduct($price_filter);
            } elseif (session()->has('brand_id') && session()->has('min_price') && session()->has('max_price')) {
                // checking if both brand and min, max price present in the filter
                dd('hello from both');

                $price_filter = [
                    'min_price' => session()->get('min_price'),
                    'max_price' => session()->get('max_price')
                ];
                $this->getBrands();
                $brand_id = session()->get('brand_id');
                $this->get_filter_product($brand_id, $price_filter);
            } 
        }
    }

    public function hydrate()
    {
        $this->getBrands();
        // dd('adsf');
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
        })->where('brand_id', $brand_id);
        $this->products = $products_query->paginate(18);
        $this->make_paginate();
        
    }

    public function make_paginate()
    {
        $paginate = new LengthAwarePaginator($this->products->items(), $this->products->total(), 18);
        $paginate->setPath(session()->get('page_url'));
        $this->paginate = $paginate->links()->render();
    }

    public function quickView($product)
    {
        // $this->is_showModal = true;
        // $this->view_product = Product::find($product);
    }

    public function PriceFilter($formData)
    {
        session()->put('category_id', $this->category_id);

        session()->put('min_price', $formData['min_price']);
        session()->put('max_price', $formData['max_price']);

        $this->min_price  = session()->has('min_price') ? session()->get('min_price') : $formData['min_price'];
        $this->max_price  = session()->has('max_price') ? session()->get('max_price') : $formData['max_price'];
        
        $price_filter = [
            "min_price" => $formData['min_price'],
            "max_price" => $formData['max_price']
        ];
        $this->products_query = Product::whereExists(function ($query) {
            $query->from('category_product')
                ->whereColumn('category_product.product_id', 'products.id')
                ->where('category_product.category_id', $this->category_id);
        })->whereBetween('sales_price', [(int) $price_filter['min_price'], (int) $price_filter['max_price']]);
        // $this->getBrands();
        $this->products = $this->products_query->paginate(18);
        $this->make_paginate();
    }

    public function getProducts()
    {
        session()->put('category_id', $this->category_id);
        $this->products_query = Product::whereExists(function ($query) {
            $query->from('category_product')
                ->whereColumn('category_product.product_id', 'products.id')
                ->where('category_product.category_id', $this->category_id);
        });
        $this->products = $this->products_query->paginate(18);
        $this->make_paginate();
    }

    public function get_filter_product($brand_id, $price_range)
    {
        session()->put('category_id', $this->category_id);
        $this->products_query = Product::whereExists(function ($query) {
            $query->from('category_product')
                ->whereColumn('category_product.product_id', 'products.id')
                ->where('category_product.category_id', $this->category_id);
        })
            ->whereIn('brand_id', $brand_id)
            ->whereBetween('sales_price', [(int) $price_range['min_price'], (int) $price_range['max_price']]);
        // $this->getBrands();
        $this->products = $this->products_query->paginate(18);
        $this->make_paginate();
    }

    public function getPriceProduct($price_range)
    {
        $this->products_query = Product::whereExists(function ($query) {
            $query->from('category_product')
                ->whereColumn('category_product.product_id', 'products.id')
                ->where('category_product.category_id', $this->category_id);
        })->whereBetween('sales_price', [(int) $price_range['min_price'], (int) $price_range['max_price']]);
        // $this->getBrands();
        $this->products = $this->products_query->paginate(18);
        $this->make_paginate();
    }


    public function getBrands()
    {
        $category_id = $this->category_id;
        // $this->brands = Brand::whereExists(function ($query)  use ($category_id) {
        //     $query->from('products')
        //         ->select('id','brand_id')
        //         ->whereColumn('products.brand_id', 'brands.id')
        //         ->whereExists(function ($q) use ($category_id) {
        //             $q->from('category_product')
        //                 ->whereColumn('category_product.product_id', 'products.id')
        //                 ->where('category_product.category_id', $category_id);
        //         });
        // })->select('id','name')->get();

        // $this->brands = Brand::whereExists(function ($q1) use ($category_id) {
        //     $q1->from('product_brands')
        //     ->whereColumn('brands.id', 'product_brands.brand_id')
        //     ->whereExists(function ($q2) use ($category_id) {
        //         $q2->from('category_product')
        //         ->whereColumn('category_product.product_id', 'product_brands.product_id')
        //         ->where('category_product.category_id', $category_id);
        //     });
        // })->select('id','name')->get();

        // $this->brands = DB::table('category_product')->where('category_id', $category_id)
        // ->whereExists(function ($q1) use ($category_id) {
        //     $q1->from('product_brands')
        //     ->whereColumn('product_brands.product_id', 'category_product.product_id');
        // })->get();

        $this->brands = DB::table('category_product')
        ->join('product_brands', 'category_product.product_id', '=', 'product_brands.product_id')
        ->join('brands', 'brands.id', '=','product_brands.brand_id')
        ->select('category_product.*', 'product_brands.*', 'brands.name')
        ->where('category_id', $this->category_id)
        ->get()->unique('brand_id');

        
        // $brand_id = $this->products_query->pluck('brand_id');
        // $this->brands = Brand::whereIn('id', $brand_id)->get();
    }

    public function render()
    {
        // $temp = $this->products_query->paginate(18);
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
