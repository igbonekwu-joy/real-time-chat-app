<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Login extends Component
{
    #[Rule('required|email|max:50')]
    public $email;

    #[Rule('required|string|min:5|max:25')]
    public $password;

    #[Layout('layouts.auth')]
    public function login(Request $request) {
        $this->validate();

        if(Auth::attempt([
            'email' => $this->email,
            'password' => $this->password
        ])) {
            $request->session()->regenerate();

            $this->redirect('/groups');
        }

        $this->addError('invalid', 'Invalid login credentials');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
