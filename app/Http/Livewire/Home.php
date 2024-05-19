<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $top_categories = Category::where('is_top_category',1)->where('status',1)->get();
        return view('livewire.home',[
                'top_categories' => $top_categories,
            ])->extends('layouts.app');
    }
}
