<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Users extends Component
{
    public $user;

    public function render()
    {
        $users = User::all();

        if($this->user) {
            $users = User::where('name', 'like', '%' . $this->user . '%')
                            ->orWhere('email', 'like', '%' . $this->user . '%')
                            ->get();
        }

        return view('livewire.users', compact('users'));
    }
}
