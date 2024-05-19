<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AboutUs extends Component
{
    public $about_us="";
    public function render()
    {
        $about_us = DB::table('dynamic_html_pages')->where('page_name', 'about_us')->first();
        $this->about_us = $about_us->page_content;
        return view('livewire.about-us')->extends('layouts.app');
    }
}
