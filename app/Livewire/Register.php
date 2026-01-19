<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Register extends Component
{
    #[Rule('required|string|min:5|max:25')]
    public $name;

    #[Rule('required|string|min:5|max:25')]
    public $password;

    #[Rule('required|email|min:5|max:25|unique:users')]
    public $email;

    #[Layout('layouts.auth')]
    public function register() {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);

        session()->flash('success', 'Registration Successful');

        //$this->redirect('/', navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
