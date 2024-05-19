<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;
    public $auth_check;
    public $access_token;

    public function mount()
    {
        $this->auth_check = auth()->check();

        if(auth()->check()){
            return redirect()->route('frontend.profile');
        }
    }

    public function login()
    {
        $validatedDate = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $this->email;
        $password = $this->password;

        $user = User::where(function($q) use($email){
            return $q->where('email', $email)
                ->orWhere('user_name', $email)
                ->orWhere('mobile_number', $email);
        })
        ->where('status',1)
        ->first();
        if($user){
            if(Hash::check($password, $user->password)){
                $check_admin = $user->roles()->whereIn('name',['admin','super_admin'])->first();
                if($check_admin){
                    $this->access_token = $user->createToken('accessToken')->accessToken;
                    $this->auth_check = auth()->check();
                    return 1;
                }
                auth()->login($user);
                session()->flash('message', "You are Logged in successfully.");
                return redirect()->route('frontend.profile');
            }else{
                return session()->flash('error', 'password incorrect.');
            }
        }else{
            return session()->flash('error', 'email or username incorrect.');
        }
    }

    public function render()
    {
        return view('livewire.login')
            ->extends('layouts.app', [
                "title" => "Login into your account" . " - " . $_SERVER['SERVER_NAME'],
            ]);
    }

    public function login_submit()
    {
        $email = $this->email;
        $password = $this->password;
        $user = User::where(function($q) use($email){
            return $q->where('email', $email)
                ->orWhere('user_name', $email)
                ->orWhere('mobile_number', $email);
        })->first();
        if($user){
            auth()->login($user);
            $this->auth_check = auth()->check();
            $this->access_token = $user->createToken('accessToken')->accessToken;
        }
    }
}
