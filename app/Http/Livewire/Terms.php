<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Terms extends Component
{
    public $page_content="";
    public function render()
    {
        $content = DB::table('dynamic_html_pages')->where('page_name', 'terms_and_conditions')->first();
        $this->page_content = $content->page_content;
        return view('livewire.terms')->extends('layouts.app');
    }
}
