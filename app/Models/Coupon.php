<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $guarded = [];

    const NOT_USED = 0;
    const STATUS_TRUE = true;
    const STATUS_FALSE = false;
}
