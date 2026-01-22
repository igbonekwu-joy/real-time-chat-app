<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\UserFriend;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Users extends Component
{
    public $user;
    public $selectedUser = null;

    public function selectUser($userId)
    {
        $this->selectedUser = User::findOrFail($userId);
    }

    public function addFriend($userId) {
        UserFriend::create([
            'user_id' => Auth::user()->id,
            'friend_id' => $userId
        ]);

        session()->flash('success', 'A friend request has been sent. You would be notified when they accept.');
    }

    public function isFriend($userId) {
        return UserFriend::where('user_id', Auth::user()->id)
                        ->where('friend_id', $userId)
                        ->where('accepted', true)
                        ->exists();
    }

    public function isPending($userId) {
        return UserFriend::where('user_id', Auth::user()->id)
                        ->where('friend_id', $userId)
                        ->where('accepted', false)
                        ->exists();
    }

    public function render()
    {
        $users = User::where('id', '!=', Auth::user()->id)->get();

        if($this->user) {
            $users = User::where('name', 'like', '%' . $this->user . '%')
                            ->orWhere('email', 'like', '%' . $this->user . '%')
                            ->where('id', '!=', Auth::user()->id)
                            ->get();
        }

        return view('livewire.users', compact('users'));
    }
}
