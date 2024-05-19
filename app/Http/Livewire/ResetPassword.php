<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ResetPassword extends Component
{
    public $user,$old_password, $newpassword, $newpassword_confirmation;

    public function mount()
    {
        $this->user = Auth::user();
    }
    public function render()
    {
        return view('livewire.reset-password')->extends('layouts.app', [
            'meta' => [
                "title" => "Password reset" . " - " . $_SERVER['SERVER_NAME'],
            ],
        ]);
    }

    public function updatePassword()
    {
        $validatedDate = $this->validate([
            'old_password' => 'required|string',
            'newpassword' => 'required|confirmed',
            'newpassword_confirmation' => 'required',
        ]);

        if (Hash::check($this->old_password, $this->user->password)) {
            if (strlen($this->newpassword) && strlen($this->newpassword_confirmation)) {
                
                $user = User::find($this->user->id);
                $user->password = Hash::make($this->newpassword);
                $user->update();

                session()->flash('message', "Your password is updated successfully.");
            }
        } else {
            session()->flash('error', 'your given old password not matching.');
        }
    }
}
