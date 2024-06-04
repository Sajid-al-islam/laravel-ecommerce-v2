<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function landingProducts() {
        return $this->hasMany(LandingPageProduct::class, 'landing_page_id', 'id');
    }

    public function landingFaq() {
        return $this->hasMany(LandingPageFaq::class, 'landing_page_id', 'id');
    }

}
