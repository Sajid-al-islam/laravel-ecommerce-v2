<?php

namespace App\Http\Livewire;

use App\Models\ContactMessage;
use Livewire\Component;

class Contact extends Component
{
    public $name;
    public $email;
    public $subject;
    public $message;
    public $feedback_message = '';  
 
    protected $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'message' => 'required|string',
    ];

    public function submit()
    {
        $this->validate();
 
        // Execution doesn't reach here if validation fails.
        
        $contact = new ContactMessage();
        $contact->full_name = $this->name;
        $contact->email = $this->email;
        $contact->subject = $this->subject;
        $contact->message = $this->message;
        $contact->save();
        $this->feedback_message = "Your message submitted successfully.";
        $this->name = "";
        $this->email = "";
        $this->subject = "";
        $this->message = "";
    }

    public function render()
    {
        return view('livewire.contact')->extends('layouts.app');
    }
}
