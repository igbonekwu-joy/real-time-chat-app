<?php

namespace App\Livewire;

use Livewire\Attributes\Rule;
use Livewire\Component;

class Register extends Component
{
    #[Rule('required|string|min:5|max:25')]
    public $name;

    #[Rule('required|string|min:5|max:25')]
    public $password;

    #[Rule('required|email|min:5|max:25')]
    public $email;

    public function register() {
        $this->validate();
    }

    public function render()
    {
        return view('livewire.register');
    }
}
