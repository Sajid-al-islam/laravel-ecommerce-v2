<?php

namespace App\Http\Controllers\Admin\Order;

use App\Http\Controllers\Controller;
use App\Mail\InvoiceMail;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderOrderCourierSteadFast;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function all()
    {
        $paginate = (int) request()->paginate;
        $orderBy = request()->orderBy;
        $orderByType = request()->orderByType;

        $status = 1;
        if (request()->has('status')) {
            $status = request()->status;
        }

        $query = Order::where('status', $status)->orderBy($orderBy, $orderByType);

        if (request()->has('search_key')) {
            $key = request()->search_key;
            $query->where(function ($q) use ($key) {
                return $q->where('id', $key)
                    ->orWhere('order_status', $key)
                    ->orWhere('total_price', 'LIKE', '%' . $key . '%')
                    ->orWhere('invoice_id', 'LIKE', '%' . $key . '%');
            });
        }

        $query->with([
            'order_payments' => function ($q) {
                return $q->select('payment_method', 'id', 'order_id');
            },
            'order_address' => function ($q) {
                return $q->select('id', 'order_id','first_name', 'mobile_number');
            },
            'stead_fast',
        ]);

        $data = $query->paginate($paginate);

        foreach ($data->all() as $item) {
            $product_ids = $item->order_details()->select('order_id', 'product_id')
                ->get()->pluck('product_id');
            $item->products = Product::select('id', 'product_name')
                ->whereIn('id', $product_ids)
                ->get();
        }
        return response()->json($data);
    }

    public function show($id)
    {
        $data = Order::where('id', $id)
            ->with([
                'order_address',
                'order_payments',
                'stead_fast',
                'order_details' => function ($q) {
                    $q->with(['product', 'variant']);
                }
            ])->first();
        if (!$data) {
            return response()->json([
                'err_message' => 'not found',
                'errors' => ['role' => ['data not found']],
            ], 422);
        }
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'name' => ['required', 'unique:Orders']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = new Order();
        $data->name = $request->name;
        $data->creator = Auth::user()->id;
        $data->save();
        $data->slug = $data->id . uniqid(5);
        $data->save();

        return response()->json($data, 200);
    }

    public function canvas_store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'name' => ['required', 'unique:Orders']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = new Order();
        $data->name = $request->name;
        $data->creator = Auth::user()->id;
        $data->save();
        $data->slug = $data->id . uniqid(5);
        $data->save();

        return response()->json($data, 200);
    }

    public function update_courier_status()
    {
        $id = request()->id;
        $stead_fast = OrderOrderCourierSteadFast::where('order_id', $id)->first();
        $order = Order::where('id', $id)->first();
        if ($stead_fast) {
            $response = Http::withHeaders(
                [
                    "Api-Key" => "at8f3p06nfiqizwdcisimpjjxoncwljo",
                    "Secret-Key" => "txgfd00ut5pikkbi4lgpnta5",
                ]
            )->get("https://portal.steadfast.com.bd/api/v1/status_by_cid/" . $stead_fast->consignment_id);

            $data = $response->collect()->toArray();
            $stead_fast->status = $data["delivery_status"];
            $stead_fast->save();

            switch ($data["delivery_status"]) {
                case 'pending':
                    $order->order_status = "pending";
                    break;
                case 'in_review':
                    $order->order_status = "accepted";
                    break;
                case 'cancelled':
                    $order->order_status = "cancelled";
                    break;
                case 'delivered':
                    $order->order_status = "delivered";
                    break;
                case 'partial_delivered':
                    $order->order_status = "processing";
                    break;
                default:
                    break;
            }

            $order->save();

            return $stead_fast;
        }
        return 0;
    }

    public function update()
    {
        $data = Order::find(request()->id);
        if (!$data) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => ['name' => ['user_role not found by given id ' . (request()->id ? request()->id : 'null')]],
            ], 422);
        }

        $validator = Validator::make(request()->all(), [
            'name' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data->name = request()->name;
        $data->update();

        return response()->json($data, 200);
    }

    public function canvas_update()
    {
        $data = Order::find(request()->id);
        if (!$data) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => ['name' => ['user_role not found by given id ' . (request()->id ? request()->id : 'null')]],
            ], 422);
        }

        $validator = Validator::make(request()->all(), [
            'name' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data->name = request()->name;
        $data->save();

        return response()->json($data, 200);
    }

    public function soft_delete()
    {
        $validator = Validator::make(request()->all(), [
            'id' => ['required', 'exists:categories,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = Order::find(request()->id);
        $data->status = 0;
        $data->save();

        return response()->json([
            'result' => 'deactivated',
        ], 200);
    }

    public function destroy()
    {
    }

    public function status_update()
    {
        $data = Order::find(request()->id);
        if (!$data) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => ['name' => ['order not found by given id ' . (request()->id ? request()->id : 'null')]],
            ], 422);
        }
        if(isset(request()->delivery_cost) && !empty(request()->delivery_cost)) {
            $data->total_price = $data->sub_total + request()->delivery_cost;
            $data->delivery_cost = request()->delivery_cost;
        }
        if(isset(request()->subtotal) && !empty(request()->subtotal)) {
            $data->sub_total = request()->subtotal;
        }
        if(isset(request()->total_discount) && !empty(request()->total_discount)) {
            $data->total_discount = request()->total_discount;
        }
        $data->order_status = request()->order_status;
        $data->save();

        return response()->json($data, 200);
    }

    public function dashboard_info()
    {
        $total_sales = Order::where('order_status', 'Accepted')->sum('total_price');


        $total_sales_this_month = Order::where('order_status', 'Accepted')
            ->whereMonth('created_at', Carbon::now()->month)->sum('total_price');

        $total_sales_today = Order::where('order_status', 'Accepted')
            ->whereMonth('created_at', Carbon::today())->sum('total_price');


        $total_customer = User::with(['roles' => function ($q) {
            $q->where('role_id', 3);
        }])->count();
        $total_pending_order = Order::where('order_status', 'Pending')->count();
        $total_product = Product::count();
        $total_categories = Category::count();

        $top_selling_product = DB::table('products')
            ->whereExists(function ($query) {
                $query->from('order_details')
                    ->whereColumn('order_details.product_id', 'products.id');
            })
            ->leftJoin('order_details', 'products.id', '=', 'order_details.product_id')
            ->selectRaw('products.id, COALESCE(sum(order_details.qty),0) total')
            ->groupBy('products.id')
            ->orderBy('total', 'desc')
            ->get();

        $less_selling_product = DB::table('products')
            ->whereExists(function ($query) {
                $query->from('order_details')
                    ->whereColumn('order_details.product_id', '!=', 'products.id');
            })
            ->leftJoin('order_details', 'products.id', '=', 'order_details.product_id')
            ->selectRaw('products.id, COALESCE(sum(order_details.qty),0) total')
            ->groupBy('products.id')
            ->orderBy('total', 'desc')
            ->get();

        $data = [
            "total_sales" => $total_sales,
            "total_sales_this_month" => $total_sales_this_month,
            "total_sales_today" => $total_sales_today,
            "total_customer" => $total_customer,
            "total_pending_order" => $total_pending_order,
            "total_product" => $total_product,
            "total_categories" => $total_categories,
            "top_selling_product" => count($top_selling_product),
            "less_selling_product" => count($less_selling_product)
        ];
        return response()->json($data, 200);
    }

    public function send_email()
    {
        $order_id = request()->order_id;
        $order_details = Order::where('id', $order_id)->with(['order_address', 'order_payments', 'order_details' => function ($q) {
            $q->with('product');
        }])->first();
        $emails = json_decode(request()->emails);
        foreach ($emails as $key => $value) {
            Mail::to($value)->send(new InvoiceMail($order_details));
        }

        $data = "Mail sent successfully";

        return response()->json($data, 200);
    }


    public function restore()
    {
        $validator = Validator::make(request()->all(), [
            'id' => ['required', 'exists:categories,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = Order::find(request()->id);
        $data->status = 1;
        $data->save();

        return response()->json([
            'result' => 'activated',
        ], 200);
    }

    public function bulk_import()
    {
        $validator = Validator::make(request()->all(), [
            'data' => ['required', 'array'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        foreach (request()->data as $item) {
            $item['created_at'] = $item['created_at'] ? Carbon::parse($item['created_at']) : Carbon::now()->toDateTimeString();
            $item['updated_at'] = $item['updated_at'] ? Carbon::parse($item['updated_at']) : Carbon::now()->toDateTimeString();
            $item = (object) $item;
            $check = Order::where('id', $item->id)->first();
            if (!$check) {
                try {
                    Order::create((array) $item);
                } catch (\Throwable $th) {
                    return response()->json([
                        'err_message' => 'validation error',
                        'errors' => $th->getMessage(),
                    ], 400);
                }
            }
        }

        return response()->json('success', 200);
    }
}
