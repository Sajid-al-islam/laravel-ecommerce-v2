<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AccountDetails extends Component
{
    public $first_name, $last_name, $username, $email, $phone;
    public $userData=[];
    public $success_mssg;

    public function mount()
    {
        $user = Auth::user();
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->phone = $user->phone;
    }

    public function updateUser()
    {
        $validatedDate = $this->validate([
            'first_name' => 'required|string',
            'last_name' => 'string',
            'email' => 'required|email',
            'phone' => 'nullable'
        ]);

        $userUpdate = User::find(Auth::user()->id);
        $userUpdate->first_name = $this->first_name;
        $userUpdate->last_name = $this->last_name;
        $userUpdate->username = $this->username;
        $userUpdate->email = $this->email;
        $userUpdate->phone = $this->phone;
        $userUpdate->update();

        $this->success_mssg = "Profile Updated Successfully";
    }
    
    public function render()
    {
        return view('livewire.account-details')->extends('layouts.app',[
            'meta' => [
                "title" => "Account Details" . " - " . $_SERVER['SERVER_NAME'],
            ],
        ]);
    }
}
