<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Livewire\OfferProduct;
use App\Models\CategoryProduct;
use App\Models\ContactMessage;
use App\Models\DiscountProduct;
use App\Models\LandingPage;
use App\Models\LandingPageFaq;
use App\Models\LandingPageProduct;
use App\Models\Product;
use App\Models\Product\ProductVariantValue;
use App\Models\Product\ProductVariantValueProduct;
use App\Models\ProductBrand;
use App\Models\ProductImage;
use App\Models\ProductStock;
use App\Models\ProductStockLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as interImage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Throwable;
use Illuminate\Support\Str;

class ProductController extends Controller
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

        $query = Product::where('status', $status)->orderBy($orderBy, $orderByType);

        if (request()->has('search_key')) {
            $key = request()->search_key;
            $query->where(function ($q) use ($key) {
                return $q->where('id', $key)
                    ->orWhere('product_name', $key)
                    ->orWhere('sales_price', $key)
                    ->orWhere('product_name', 'LIKE', '%' . $key . '%')
                    ->orWhere('sales_price', 'LIKE', '%' . $key . '%');
            });
        }
        $query->withSum('stocks', 'qty');
        $query->withSum('sales', 'qty');
        $users = $query->paginate($paginate);
        return response()->json($users);
    }

    public function allLandingPage() {
        $paginate = (int) request()->paginate;
        $orderBy = request()->orderBy;
        $orderByType = request()->orderByType;

        $query = LandingPage::orderBy($orderBy, $orderByType);

        if (request()->has('search_key')) {
            $key = request()->search_key;
            $query->where(function ($q) use ($key) {
                return $q->where('id', $key)
                    ->orWhere('name', $key)
                    ->orWhere('first_title', $key)
                    ->orWhere('first_title', 'LIKE', '%' . $key . '%')
                    ->orWhere('second_title', 'LIKE', '%' . $key . '%');
            });
        }
        $landing_pages = $query->paginate($paginate);
        return response()->json($landing_pages);
    }

    public function storeLandingPage() {
        $validator = Validator::make(request()->all(), [
            'name' => ['required', 'unique:landing_pages'],
            'title' => ['required', 'string', 'max:100'],
            'sub_title' => ['required', 'string', 'max:200'],
            'first_btn_text' => ['string', 'max:60'],
            'first_btn_color' => ['max:10'],
            'second_btn_color' => ['max:10'],
            'primary_color' => ['max:10'],
            'secondary_color' => ['max:10'],
            'delivery_cost' => ['required'],
            'middle_title' => ['required','string', 'max:200'],
            'video_link' => ['string'],
            'image1' => ['nullable', 'image', 'mimes:jpg,png,webp'],
            'image2' => ['nullable', 'image', 'mimes:jpg,png,webp'],
            'faq_title' => ['required', 'string']
        ]);

        $landing_info = request()->except([
            'image1',
            'image2',
            'faqs',
            'product_ids'
        ]);


        try{
            if ($validator->fails()) {
                return response()->json([
                    'err_message' => 'validation error',
                    'errors' => $validator->errors(),
                ], 422);
            }
            DB::beginTransaction();

            $landing_page = LandingPage::create($landing_info);
            $landing_page->slug = Str::slug($landing_page->name);
            $this->setLandingPageProduct($landing_page->id, request()->product_ids);
            $this->setLandingFaq($landing_page->id, request()->faqs);

            try {
                if(request()->hasFile('image1')) {
                    $landing_page->image_1 = $this->store_product_file(request()->file('image1'));
                }
                if(request()->hasFile('image2')) {
                    $landing_page->image_2 = $this->store_product_file(request()->file('image2'));
                }
                $landing_page->save();
            } catch (\Throwable $e) {
                return response()->json($e->getMessage(), 500);
            }
            DB::commit();

            $message = "Landing Page Created!";
            return response()->json([
                'message' => $message
            ], 200);

        }catch(Throwable $th) {
            Log::error($th->getMessage());
            DB::rollBack();
        }
    }

    public function setLandingPageProduct($landing_page_id, $product_ids) {
        if(is_array($product_ids)) {
            foreach ($product_ids as $key => $product_id) {
                LandingPageProduct::create([
                    "product_id" => $product_id,
                    "landing_page_id" => $landing_page_id,
                ]);
            }
        }
    }

    public function setLandingFaq($landing_page_id, $faqs) {
        if(!empty($faqs)) {
            $faqs = json_decode($faqs);
            foreach($faqs as $faq) {
                LandingPageFaq::create([
                    'landing_page_id' => $landing_page_id,
                    'title' => $faq->title,
                    'description' => $faq->description,
                ]);
            }
        }
    }

    public function show($id)
    {
        $data = Product::where('id', $id)->with([
            'categories' => function ($q) {
                return $q->select('categories.id', 'categories.parent_id', 'categories.name');
            },
            'brand' => function ($q) {
                return $q->select('id', 'name');
            },
            'discount' => function ($q) {
                return $q->where('discount_last_date', '>', Carbon::today())->orderBy('id', 'DESC');
            },
            'variants' => function ($q) {
                return $q;
            },
        ])
            ->withSum('stocks', 'qty')
            ->withSum('sales', 'qty')
            ->first();

        if (!$data) {
            return response()->json([
                'err_message' => 'not found',
                'errors' => ['role' => ['data not found']],
            ], 422);
        }
        return response()->json($data, 200);
    }

    public function store()
    {
        // dd(request()->all());
        $validator = Validator::make(request()->all(), [
            'product_name' => ['required'],
            'sales_price' => ['required'],
            'brand_id' => ['required'],
            'selected_categories' => ['required'],
            'specification' => ['required'],
            'description' => ['required'],
            'search_keywords' => ['required'],
            'page_title' => ['required'],
            'image1' => ['required'],
            "cost" => ['numeric'],
            "sales_price" => ['numeric'],
            // 'product_url' => ['required', 'unique:products'],
            'meta_description' => ['required'],
            'stock' => ['required'],
            'low_stock' => ['required'],
        ], [
            'low_stock.required' => 'stock is required',
            'low_stock.required' => 'low stock is required',
            'image1.required' => 'thumbnail image is required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $product_info = request()->except([
            'variants',
            'selected_categories',
            'image1',
            'image2',
            'image3',
            'image4',
            'image5',
            'image6',
        ]);

        $product_info['selected_categories'] = json_encode(request()->selected_categories);
        // $product_info['custom_fields'] = $request->custom_fields;
        // $product_info['hs_codes'] = $request->hs_codes;

        $related_images = [];
        for ($i = 1; $i <= 6; $i++) {
            if (request()->hasFile('image' . $i)) {
                try {
                    $path = $this->store_product_file(request()->file('image' . $i));
                    array_push($related_images, $this->save_image($path));
                } catch (\Throwable $e) {
                    return response()->json($e->getMessage(), 500);
                }
            }
        }

        if (count($related_images) > 0) {
            $product = Product::create($product_info);
            $product->categories()->attach(request()->selected_categories);

            $this->product_stock_set(null, $product->id, $product->created_at, $product->stock);
            $this->product_stock_log_set($product->id, $product->stock, 'initial');

            $this->product_variant_set(request()->variants, $product->id);

            for ($i = 0; $i < count($related_images); $i++) {
                $related_iamge = $related_images[$i];
                $related_iamge->product_id = $product->id;
                $related_iamge->save();
            }

            $message = "product created!";
            return response()->json([
                'message' => $message
            ], 200);

        } else {
            return response()->json('Upload valid jpg or jpeg image.', 500);
        }
    }

    public function product_stock_set($supplier_id = null, $product_id, $purchase_date, $qty)
    {
        ProductStock::create([
            'supplier_id' => $supplier_id,
            'product_id' => $product_id,
            'purchase_date' => $purchase_date,
            'qty' => $qty,
        ]);
    }

    public function product_stock_log_set($product_id, $qty, $type)
    {
        ProductStockLog::create([
            'product_id' => $product_id,
            'qty' => $qty,
            'type' => $type,
            'creator' => auth()->user()->id,
        ]);
    }

    function product_variant_set($variants, $product_id) {
        ProductVariantValueProduct::where('product_id',$product_id)->delete();
        if(!empty($variants)) {
            foreach ($variants as $variant_id => $variant) {
                foreach($variant as $variant_values) {
                    if(!empty($variant_values['variant_id'])) {
                        ProductVariantValueProduct::create([
                            "product_id" => $product_id,
                            "product_variant_id" => $variant_id,
                            "product_variant_value_id" => $variant_values['variant_id'],
                            "variant_price" => $variant_values['variant_price']
                        ]);
                    }
                }
            }
        }
    }

    public function store_product_file($image)
    {
        // $path = Storage::put('uploads/file_manager',$request->file('fm_file'));
        $file = $image;
        $extension = $file->getClientOriginalExtension();
        $temp_name  = uniqid(10) . time();
        $image = interImage::make($file);

        // main image
        // $path = 'uploads/product/product_' . $temp_name . '.' . $extension;
        // $image->save($path);
        // $this->image_save_to_db($path);

        // rectangle
        // $image->fit(848, 438, function ($constraint) {
        //     $constraint->aspectRatio();
        // });
        // $path = 'uploads/file_manager/fm_image_848x438_' . $temp_name . '.' . $extension;
        // $image->save($path);
        // $this->image_save_to_db($path);

        // square
        $canvas = interImage::canvas(800, 800);
        $image->fit(800, 800, function ($constraint) {
            $constraint->aspectRatio();
        });
        $canvas->insert($image);
        // $canvas->insert(interImage::make(public_path('ilogo.png')), 'bottom-right');

        $path = 'uploads/product/product_image_800x800_' . $temp_name . '.' . $extension;
        $canvas->save($path);

        return $path;
    }

    public function canvas_store()
    {
        $validator = Validator::make(request()->all(), [
            'full_name' => ['required'],
            'email' => ['required'],
            'subject' => ['required'],
            'message' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = new ContactMessage();
        $data->full_name = request()->full_name;
        $data->email = request()->email;
        $data->subject = request()->subject;
        $data->message = request()->message;
        $data->save();

        return response()->json($data, 200);
    }

    public function update()
    {
        $validator = Validator::make(request()->all(), [
            'product_name' => ['required'],
            'sales_price' => ['required'],
            'brand_id' => ['required'],
            'selected_categories' => ['required'],
            'specification' => ['required'],
            'description' => ['required'],
            'search_keywords' => ['required'],
            'page_title' => ['required'],
            "cost" => ['numeric'],
            "sales_price" => ['numeric'],
            "updated_stock" => ['numeric'],
            // 'product_url' => ['required', 'unique:products'],
            'meta_description' => ['required'],
            'low_stock' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $product_info = request()->except([
            'variants',
            'selected_categories',
            'image1',
            'image2',
            'image3',
            'image4',
            'image5',
            'image6',
            'stock_log_type',
            'updated_stock',
        ]);
        $product_info['selected_categories'] = json_encode(request()->selected_categories);

        $product = Product::find(request()->id);
        $product->fill($product_info);

        $product_images = $product->related_image()->get();
        for ($i = 1; $i <= 6; $i++) {
            if (request()->hasFile('image' . $i)) {
                if (isset($product_images[$i - 1])) {
                    $single_image = $product_images[$i - 1];
                    $path = public_path($single_image->image);
                    if (file_exists($path)) {
                        unlink($path);
                    }
                    try {
                        $path = $this->store_product_file(request()->file('image' . $i));
                        $single_image->image = $path;
                        $single_image->save();
                    } catch (\Throwable $e) {
                        return response()->json($e, 500);
                    }
                } else {
                    try {
                        $path = $this->store_product_file(request()->file('image' . $i));
                        $product_image = $this->save_image($path);
                        $product_image->product_id = $product->id;
                        $product_image->save();
                    } catch (\Throwable $e) {
                        return response()->json($e, 500);
                    }
                }
            }
        }


        $this->product_variant_set(request()->variants, $product->id);

        $product->save();
        $product->categories()->sync(request()->selected_categories);

        $stock_qty = request()->updated_stock;
        $type = request()->stock_log_type;
        if ($stock_qty > 0) {
            switch (request()->stock_log_type) {
                case 'sell':
                    $this->product_stock_log_set($product->id, -$stock_qty, $type);
                    break;

                case 'purchase':
                    $this->product_stock_log_set($product->id, $stock_qty, $type);
                    break;

                default:
                    break;
            }
        }

        $product->stock = $product->stocks()->sum('qty');
        $product->save();
        // $path = '';
        $message = "product updated!";
        return response()->json([
            'message' => $message,
            "product" => $product,
        ], 200);
    }

    public function update_is_top_product()
    {
        $product = Product::find(request()->id);
        if($product){
            $product->is_top_product = request()->is_top_product;
            $product->save();
        }
        return $product->is_top_product;
    }

    public function delete_related_image()
    {
        $id = request()->id;
        $related_image = ProductImage::find($id);
        if ($related_image) {
            if (file_exists(public_path($related_image->image))) {
                unlink(public_path($related_image->image));
            }
            $related_image->delete();
        }
        return response()->json('file deleted');
    }

    public function save_image($path)
    {
        return ProductImage::create([
            // 'product_id' => $product->id,
            'product_id' => 0,
            'image' => $path,
            'creator' => Auth::user()->id,
            'created_at' => Carbon::now()->toDateTimeString(),
        ]);
    }

    public function canvas_update()
    {
        $data = Product::find(request()->id);
        if (!$data) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => ['name' => ['user_role not found by given id ' . (request()->id ? request()->id : 'null')]],
            ], 422);
        }

        $validator = Validator::make(request()->all(), [
            'full_name' => ['required'],
            'email' => ['required'],
            'subject' => ['required'],
            'message' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data->full_name = request()->full_name;
        $data->email = request()->email;
        $data->subject = request()->subject;
        $data->message = request()->message;
        $data->save();

        return response()->json($data, 200);
    }

    public function soft_delete()
    {
        $validator = Validator::make(request()->all(), [
            'id' => ['required', 'exists:products,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = Product::find(request()->id);
        $data->status = 0;
        $data->save();

        return response()->json([
            'result' => 'deactivated',
        ], 200);
    }

    public function destroyLandingPage()
    {
        $validator = Validator::make(request()->all(), [
            'id' => ['required', 'exists:landing_pages,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }
        try {
            DB::beginTransaction();
            LandingPage::find(request()->id)->delete();
            LandingPageFaq::where('landing_page_id', request()->id)->delete();
            LandingPageProduct::where('landing_page_id', request()->id)->delete();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info($th->getMessage());
        }

        return response()->json([
            'result' => 'deactivated',
        ], 200);
    }

    public function destroy()
    {
        $validator = Validator::make(request()->all(), [
            'id' => ['required', 'exists:products,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }
        try {
            DB::beginTransaction();
                Product::where('id', request()->id)->delete();
                ProductStock::where('product_id', request()->id)->delete();
                ProductStockLog::where('product_id', request()->id)->delete();
                ProductImage::where('product_id', request()->id)->delete();
                CategoryProduct::where('product_id', request()->id)->delete();
                DiscountProduct::where('product_id', request()->id)->delete();
                ProductBrand::where('product_id', request()->id)->delete();
                OfferProduct::where('product_id', request()->id)->delete();
                ProductVariantValueProduct::where('product_id', request()->id)->delete();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info($th->getMessage());
        }
        return response()->json([
            'result' => 'deleted',
        ], 200);
    }

    public function set_product_offer()
    {
        $validator = Validator::make(request()->all(), [
            'product_id' => ['required'],
            'discount_percent' => ['required'],
            'discount_amount' => ['required'],
            'discount_last_date' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        DiscountProduct::where('product_id', request()->product_id)
            ->whereDate('discount_last_date','>=', Carbon::now()->toDateString())
            ->update([
                "discount_last_date" => Carbon::now()->subHours(1)->toDateTimeString()
            ]);

        if(request()->discount_percent > 0){
            $discount = DiscountProduct::create([
                ...request()->all(),
                'creator'=>auth()->user()->id,
            ]);
            return $discount;
        }
        return 'removed';
    }

    public function restore()
    {
        $validator = Validator::make(request()->all(), [
            'id' => ['required', 'exists:products,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'err_message' => 'validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = Product::find(request()->id);
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
            $check = Product::where('id', $item->id)->first();
            if (!$check) {
                try {
                    Product::create((array) $item);
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
