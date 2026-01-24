<?php

namespace App\Livewire;

use App\Models\UserFriend;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Friends extends Component
{
    public function render()
    {
        $friends = UserFriend::with('user')
                    ->where('user_id', Auth::user()->id)
                    ->orWhere('friend_id', Auth::user()->id)
                    ->get();

        return view('livewire.friends', compact('friends'));
    }
}
