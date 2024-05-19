<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = [
        "image_link"
    ];

    public function getImageLinkAttribute()
    {
        return url('') . '/' . $this->image;
    }
}
