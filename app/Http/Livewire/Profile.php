<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Profile extends Component
{
    public $user = [];

    public function mount()
    {
        if(!Auth::check()) {
            return redirect()->route('website_login');
        }
    }

    public function render()
    {
        $this->user = Auth::user();
        return view('livewire.profile')->extends('layouts.app', [
            'meta' => [
                "title" => "Profile page" . " - " . $_SERVER['SERVER_NAME'],
            ],
        ]);
    }
}
