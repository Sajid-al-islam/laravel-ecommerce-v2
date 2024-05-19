<?php

namespace App\Http\Livewire;

use App\Models\OrderAddress;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Address extends Component
{
    public $user; 
    public $address=[];
    public function render()
    {
        $this->user = Auth::user();
        if($this->user) {
            $this->address = OrderAddress::where('user_id', $this->user->id)->get();
        }
        return view('livewire.address')->extends('layouts.app', [
            'meta' => [
                "title" => "My Addresses" . " - " . $_SERVER['SERVER_NAME'],
            ],
        ]);
    }
}
