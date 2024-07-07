<?php

namespace App\Http\Controllers\Admin\Website;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
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

        $query = Coupon::where('status', $status)->orderBy($orderBy, $orderByType);

        if (request()->has('search_key')) {
            $key = request()->search_key;
            $query->where(function ($q) use ($key) {
                return $q->where('id', $key)
                    ->orWhere('code', $key)
                    ->orWhere('type', $key)
                    ->orWhere('start_date', 'LIKE', '%' . $key . '%')
                    ->orWhere('end_date', 'LIKE', '%' . $key . '%')
                    ->orWhere('code', 'LIKE', '%' . $key . '%');
            });
        }

        $coupons = $query->paginate($paginate);
        return response()->json($coupons);
    }

    public function show($id)
    {
        $data = Coupon::where('id', $id)->first();
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
            'code' => ['required', 'string'],
            'type' => ['required'],
            'value' => ['required', 'numeric'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = new Coupon();
        $data->code = $request->code;
        $data->type = $request->type;
        $data->value = $request->value;
        $data->start_date = $request->start_date;
        $data->end_date = $request->end_date;
        $data->usage_limit = $request->usage_limit;
        $data->used = Coupon::NOT_USED;
        $data->status = Coupon::STATUS_TRUE;
        $data->save();

        return response()->json($data, 200);
    }

    public function update(Request $request)
    {
        $data = Coupon::find(request()->id);
        if (!$data) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => ['name' => ['data not found by given id ' . (request()->id ? request()->id : 'null')]],
            ], 422);
        }


        $validator = Validator::make(request()->all(), [
            'code' => ['required', 'string'],
            'type' => ['required'],
            'value' => ['required', 'numeric'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }


        $data->code = $request->code;
        $data->type = $request->type;
        $data->value = $request->value;
        $data->start_date = $request->start_date;
        $data->end_date = $request->end_date;
        $data->usage_limit = $request->usage_limit;
        $data->used = Coupon::NOT_USED;
        $data->status = Coupon::STATUS_TRUE;
        $data->save();

        return response()->json($data, 200);
    }

    public function toggle_status()
    {
        $data = Coupon::find(request()->id);
        if (!$data) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => ['name' => ['data not found by given id ' . (request()->id ? request()->id : 'null')]],
            ], 422);
        }

        $data->status = $data->status ? 0 : 1;
        $data->save();

        return response()->json($data->status);
    }

    public function destroy()
    {
        $validator = Validator::make(request()->all(), [
            'id' => ['required', 'exists:coupons,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = Coupon::where('id',request()->id)->delete();

        return response()->json([
            'result' => 'deleted',
        ], 200);
    }

    // public function destroy()
    // {
    // }

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
            $check = Coupon::where('id', $item->id)->first();
            if (!$check) {
                try {
                    Coupon::create((array) $item);
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
