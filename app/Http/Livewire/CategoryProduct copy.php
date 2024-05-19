<?php

namespace App\Http\Livewire;


use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CategoryProduct_2 extends Component
{
    protected $products_query=null;
    protected $products=null;
    protected $brand_products_query=null;
    public $category_id;
    public $min_price=1;
    public $max_price=0;
    public $brands;
    public $sub_categories;
    public $category_name;
    public $brand_query = false;
    public $brand_id;
    public $view_product;
    
    public function mount($id, $category_name)
    {
        $this->category_id = $id;
        $this->category_name = $category_name;

        // session()->put('category_url',  explode('?',url()->full())[0]);
        
        $this->sub_categories = Category::where('parent_id', $id)->select('id','name')->get();

        if(session()->has('brand_id')) {
            $this->getBrandProduct($this->brand_id);
        }

        if(session()->has('min_price') && session()->has('max_price')) {
            $price_filter = [
                'min_price'=> session()->get('min_price'),
                'max_price' => session()->get('max_price')
            ];
            $this->getPriceProduct($price_filter);
        }

        if(session()->has('brand_id') && session()->has('min_price') && session()->has('max_price')) {
            $price_filter = [
                'min_price'=> session()->has('min_price'),
                'max_price' => session()->has('max_price')
            ];
            $brand_id = session()->get('brand_id');
            $this->get_filter_product($brand_id, $price_filter);
        }
        
        $this->getProducts();
        $this->getBrands();
    }

    public function filterBrand()
    {
        dd($this->brand_id);
        if(count($this->brand_id) > 0) {

            session()->put('brand_id', $this->brand_id);
            $this->products_query = Product::whereExists(function ($query)  {
                $query->from('category_product')
                        ->whereColumn('category_product.product_id', 'products.id')
                        ->where('category_product.category_id', $this->category_id);
            })->where('brand_id', $this->brand_id);
            $this->getBrands();
            $this->products = $this->products_query->paginate(18);
            
        }else {
            session()->remove('brand_id');
        }
    }

    public function quickView($product)
    {
        // $this->is_showModal = true;
        // $this->view_product = Product::find($product);
    }

    public function PriceFilter($formData) {
        $this->min_price  = $formData['min_price'];
        session()->put('min_price', $this->min_price);
        $this->max_price  = $formData['max_price'];
        session()->put('max_price', $this->max_price);
        $price_filter = [
            "min_price" => $formData['min_price'],
            "max_price" => $formData['max_price']
        ];
        $this->getPriceProduct($price_filter);
    }

    public function getProducts()
    {
        $this->products_query = Product::whereExists(function ($query)  {
            $query->from('category_product')
                    ->whereColumn('category_product.product_id', 'products.id')
                    ->where('category_product.category_id', $this->category_id);
        });
        $this->getBrands();
        $this->products = $this->products_query->paginate(18);
    }

    public function get_filter_product($brand_id, $price_range)
    {
        $this->products_query = Product::whereExists(function ($query)  {
            $query->from('category_product')
                    ->whereColumn('category_product.product_id', 'products.id')
                    ->where('category_product.category_id', $this->category_id);
        })
        ->whereIn('brand_id', $brand_id)
        ->whereBetween('sales_price', [ (int) $price_range['min_price'], (int) $price_range['max_price'] ]);
        $this->getBrands();
        $this->products = $this->products_query->paginate(18);
    }

    public function getPriceProduct($price_range)
    {
        $this->products_query = Product::whereExists(function ($query)  {
            $query->from('category_product')
                    ->whereColumn('category_product.product_id', 'products.id')
                    ->where('category_product.category_id', $this->category_id);
        })->whereBetween('sales_price', [ (int) $price_range['min_price'], (int) $price_range['max_price'] ]);
        $this->getBrands();
        $this->products = $this->products_query->paginate(18);
    }

    
    public function getBrandProduct($brand_id) 
    {
        $this->products_query = Product::whereExists(function ($query)  {
            $query->from('category_product')
                    ->whereColumn('category_product.product_id', 'products.id')
                    ->where('category_product.category_id', $this->category_id);
        })->whereIn('brand_id', $brand_id);
        $this->getBrands();
        $this->products = $this->products_query->paginate(18);
    }

    public function getBrands()
    {
        $brand_id = $this->products_query->pluck('brand_id');
        $this->brands = Brand::whereIn('id', $brand_id)->get();
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
            'all_products' => $this->products
        ])
        ->extends('layouts.app', [
            'meta' => [
                "title" => $this->category_name . " - " . $_SERVER['SERVER_NAME'],
            ],
        ]);
    }
}
