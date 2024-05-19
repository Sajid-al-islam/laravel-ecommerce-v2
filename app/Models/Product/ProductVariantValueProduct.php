<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantValueProduct extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function value()
    {
        return $this->hasOne(ProductVariantValue::class,'id','product_variant_value_id');
    }
}
