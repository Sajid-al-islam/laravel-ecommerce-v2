<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RefundPolicy extends Component
{
    public $page_content="";
    public function render()
    {
        $content = DB::table('dynamic_html_pages')->where('page_name', 'refund_and_return_policy')->first();
        $this->page_content = $content->page_content;
        return view('livewire.refund-policy')->extends('layouts.app');
    }
}
