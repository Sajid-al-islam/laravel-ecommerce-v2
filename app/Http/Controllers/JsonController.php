<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\CouponService;
use Illuminate\Http\Request;

class JsonController extends Controller
{
    public $skip = 0;
    public $take = 0;
    public function get_category_product($category_id, $chunk_size, $chunk_no)
    {

        $category = Category::where('id', $category_id)->first();

        $skip = $chunk_size * ($chunk_no - 1);
        $this->skip = $skip;
        $this->take = $chunk_size;

        // dd($chunk_size, $chunk_no,['skip'=>$skip] , $category->products()->get()->chunk($chunk_size)->count());

        $category_products = Category::where('id', $category_id)
            ->with([
                // 'products:id,product_name,sales_price,selected_categories',
                'products' => function ($query) {
                    $query->select([
                        'products.id',
                        'product_name',
                        'sales_price',
                        'selected_categories',
                    ])
                        ->skip($this->skip)
                        ->take($this->take)
                        ->get();
                }
            ])
            ->first();

        $result = [
            'total' => 0,
            'lastPage' => 0,
            'items' => [],
            'perPage' => $chunk_size,
            'currentPage' => $chunk_no,
            'nextPageUrl' => '',
            'prevPageUrl' => '',
        ];

        $chunks_count = $category->products->chunk($chunk_size)->count();
        $route_name = 'get_category_product_json';
        if ($chunk_no <= $chunks_count && $chunk_no > 0) {
            $items = $category_products->products;
            $total = $chunks_count;
            $nextPageUrl = '';
            $prevPageUrl = '';

            if ($chunk_no < $total) {
                $nextPageUrl = route($route_name, [
                    $category_id,
                    $chunk_size,
                    $chunk_no + 1,
                ]);
            }

            if ($chunk_no > 1) {
                $prevPageUrl = route($route_name, [
                    $category_id,
                    $chunk_size,
                    $chunk_no - 1,
                ]);
            }

            $result = [
                'total' => $total,
                'lastPage' => $chunks_count - 1,
                'items' => $items,
                'perPage' => $chunk_size,
                'currentPage' => $chunk_no,
                'nextPageUrl' => $nextPageUrl,
                'prevPageUrl' => $prevPageUrl,
            ];
        }

        return $result;
        dd($result, $this->skip, $this->take);
    }

    public function make_chunk($data, $chunk_size, $chunk_no, $route_name, $extra_info)
    {
        $chunks = $data->chunk($chunk_size);
        $result = [
            'total' => 0,
            'lastPage' => 0,
            'items' => [],
            'perPage' => $chunk_size,
            'currentPage' => $chunk_no,
            'nextPageUrl' => '',
            'prevPageUrl' => '',
        ];

        if ($chunk_no <= count($chunks)) {
            $chunk_results = $data->chunk($chunk_size)[$chunk_no];
            $total = count($chunk_results);
            $id = $extra_info['url_id'];
            $nextPageUrl = '';
            $prevPageUrl = '';

            if ($chunk_no <= $total) {
                $nextPageUrl = route($route_name, [
                    $id,
                    $chunk_size,
                    $chunk_no + 1,
                ]);
            }

            if ($chunk_no > 0) {
                $nextPageUrl = route($route_name, [
                    $id,
                    $chunk_size,
                    $chunk_no - 1,
                ]);
            }

            $result = [
                'total' => $total,
                'lastPage' => count($chunk_results) - 1,
                'items' => $chunk_results,
                'perPage' => $chunk_size,
                'currentPage' => $chunk_no,
                'nextPageUrl' => $nextPageUrl,
                'prevPageUrl' => $prevPageUrl,
            ];
        }

        // return $result;
        dd([$data, $chunk_size, $chunk_no, $route_name, $result, Product::paginate(2)]);
    }

    public function search_product()
    {
        $key = request()->key;
        $products = Product::where('status', 1)
            ->where('product_name', $key)
            ->orWhere('sku', $key)
            ->orWhere('brand_id', $key)

            ->orWhere('product_name', 'LIKE', '%' . $key . '%')
            ->orWhere('sku', 'LIKE', '%' . $key . '%')
            ->orWhere('brand_id', 'LIKE', '%' . $key . '%')

            ->select([
                'id',
                'product_name',
                'sales_price',
            ])

            ->paginate(5);

        return response()->json($products);
    }

    public function update_cart_html() {
        $product_id = request()->product_id;
        $delivery_cost = request()->delivery_cost;
        $empty_cart = (new CartController())->emptyCart();

        $cart = (new CartController())->add_to_cart($product_id, 1);

        $product = Product::where('id', $product_id)->first();

        $result = view('frontend.cart-table', compact('product', 'delivery_cost'))->render();

        return response()->json([
            'status' => true,
            'result' => $result,
            'message' => 'Data loaded',
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $code = $request->input('coupon_code');
        // $product = Product::find($request->input('product_id'));

        $result = (new CouponService)->applyCoupon($code);

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 400);
        }

        return response()->json(['message' => $result['message'], 'discount' => $result['discount']]);
    }

}
