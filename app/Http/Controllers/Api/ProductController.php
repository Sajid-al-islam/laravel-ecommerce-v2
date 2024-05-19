<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{
    public function top_products()
    {
        $page = request()->page ?? 1;
        $get_json = request()->get_json;
        $take = 5;
        $skip = ($page - 1) * $take;

        $products = Product::where('status',1)
            ->where('is_top_product', 1)
            ->take($take)
            ->with('discounts', function ($q) {
                $q->orderBy('created_at', 'DESC')->where('discount_last_date', '>', Carbon::now())
                    ->select('id', 'product_id', 'discount_percent', 'discount_amount', 'discount_last_date');
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
            ->withSum('stocks', 'qty')
            ->withSum('sales', 'qty')
            ->skip($skip)
            ->orderBy('is_top_product', 'DESC')
            ->get();

        if ($get_json) {
            return response()->json([
                "data" => $products
            ]);
        } else {
            $product_html = "";
            foreach ($products as $product) {
                $product_html .= view('frontend.include.product', compact('product'))->render();
            }
            return response()->json([
                "data" => $product_html,
            ]);
        }
    }

    public function category_products($category_id, $category_name)
    {
        $category = null;
        $products = null;

        $min = request()->min && is_numeric(request()->min) ? request()->min : 0;
        $max = request()->max && is_numeric(request()->max) ? request()->max : 500000;
        $query_brands = request()->brands ? request()->brands : null;
        $query_availability = request()->availability ? request()->availability : null;

        $min_product_price = Product::orderBy('sales_price', 'ASC')->first();
        $max_product_price = Product::orderBy('sales_price', 'DESC')->first();

        $products = [];
        $links = '';

        if ($min_product_price) {
            $min_product_price = $min_product_price->sales_price;
            $max_product_price = $max_product_price->sales_price;

            if (Category::where('id', $category_id)->exists()) {
                $category = Category::where('id', $category_id)->first();

                $data_query = $category->products()
                    ->whereBetween('products.sales_price', [$min, $max])
                    ->where('status', 1);

                if ($query_brands) {
                    $data_query->whereIn('brand_id', $query_brands);
                }

                if ($query_availability) {
                    $data_query->where($query_availability, 1);
                }

                $data_query->orderBy('sales_price', 'ASC')
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
                    // ->withSum('stocks','qty')
                    // ->withSum('sales','qty')
                ;

                $total = $data_query->count();
                $page = request()->page ?? 1;
                $perpage = 20;
                $skip = ($page - 1) * $perpage;
                $items = $data_query->skip($skip)->take($perpage)->get();
                $data = new LengthAwarePaginator($items, $total, $perpage, $page, ["path" => url("/category/$category_id/" . $category->name)]);


                $products = $data->items();
                if ($min >= 0) {
                    $data->appends('min', $min);
                }
                if ($max >= 0) {
                    $data->appends('max', $max);
                }
                if ($query_brands) {
                    $data->appends('brands', $query_brands);
                }
                $links = $data->links()->render();
            }
        }

        $product_html = "";
        foreach ($products as $product) {
            $product_html .= view('frontend.include.product', compact('product'))->render();
        }
        return response()->json([
            'products' => $product_html ? $product_html : 'there is no product found.',
            'links' => $links,
        ]);
    }

    public function category_product_brands($category_id)
    {
        $brand_ids = Product::select('brand_id')->whereJsonContains('selected_categories', $category_id)->groupBy('brand_id')->get()->map(function ($e) {
            return $e->brand_id;
        });
        $brands = Brand::select('id', 'name')->whereIn('id', $brand_ids)->orderBy('name', 'ASC')->get();
        $query_brands = request()->brands ? request()->brands : null;
        $brand_html = view('frontend.category_product.brand', compact('brands', 'query_brands'))->render();
        return response()->json([
            "data" => $brand_html,
        ]);
    }

    public function search_products()
    {
        $key = request()->key;
        $products = Product::where('status', 1)
            ->select([
                "id",
                "product_name",
                "sales_price",
            ])
            ->where(function ($q) use ($key) {
                return $q->where('id', $key)
                    ->orWhere('product_name', "LIKE", '%' . $key . '%')
                    ->orWhere('search_keywords', "LIKE", '%' . $key . '%');
            })->get();

        $result = view('frontend.components.search_results',compact('products'))->render();
        return $result;
    }

}
