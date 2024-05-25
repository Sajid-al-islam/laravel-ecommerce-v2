<?php

namespace App\Models;

use App\Models\Product\ProductVariantValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    /**
     * Get the user associated with the OrderDetails
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id')->select('id', 'product_name');
    }

    public function variant()
    {
        return $this->hasOne(ProductVariantValue::class, 'id', 'size');
    }
}
