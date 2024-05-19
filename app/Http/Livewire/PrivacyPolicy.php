<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PrivacyPolicy extends Component
{
    public $page_content="";
    public function render()
    {
        $content_q = DB::table('dynamic_html_pages')->where('page_name', 'privacy')->first();
        $this->page_content = $content_q->page_content;
        return view('livewire.privacy-policy')->extends('layouts.app');
    }
}
