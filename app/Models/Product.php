<?php

namespace App\Models;

use App\Models\Product\ProductVariant;
use App\Models\Product\ProductVariantValueProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isNull;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = [
        'related_categories',
        'related_images',
    ];

    public function getRelatedCategoriesAttribute()
    {
        if (strlen($this->selected_categories)) {
            $json_categories_id = json_decode($this->selected_categories);
            $category = [];

            foreach ($json_categories_id as $id) {
                if (Category::where('id', $id)->exists()) {
                    array_push($category, Category::where('id', $id)->select('id', 'name')->first());
                }
            }
            return $category;
        }
        return [];
    }

    public function getRelatedImagesAttribute()
    {
        return ProductImage::where('product_id', $this->id)->get();
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id');
    }

    public function related_image()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function discount()
    {
        return $this->hasOne(DiscountProduct::class)->orderBy('id','DESC');
    }

    public function discounts() {
        return $this->hasOne(DiscountProduct::class, 'product_id')->orderBy('id','DESC');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function product_brand() {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function stocks()
    {
        return $this->hasMany(ProductStockLog::class,'product_id')->where('type','!=','sell');
    }

    public function sales()
    {
        return $this->hasMany(ProductStockLog::class,'product_id')->where('type','sell');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariantValueProduct::class, 'product_id');
    }

    public function sizes()
    {
        $size = ProductVariant::where('title','size')->first();
        if($size) {
            return $this->hasMany(ProductVariantValueProduct::class, 'product_id')->where('product_variant_id',$size->id);
        }
    }


}
