<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\UserFriend;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Requests extends Component
{
    public $selectedUser;
    public $request;

    public function selectUser($userId) {
        $this->selectedUser = User::findOrFail($userId);
    }

    public function ignoreRequest($userId) {
        UserFriend::where('user_id', $userId)
                    ->where('friend_id', Auth::user()->id)
                    ->delete();

        session()->flash('success', 'The friend request has been removed.');
    }

    public function acceptRequest($userId) {
        UserFriend::where('user_id', $userId)
                    ->where('friend_id', Auth::user()->id)
                    ->update(['accepted' => true]);

        session()->flash('success', 'The friend request has been accepted.');
    }

    public function render()
    {
        $requests = UserFriend::with('user')
                            ->where('friend_id', Auth::user()->id)
                            ->where('accepted', false)
                            ->get();

        if($this->request) {
            $requests = UserFriend::with('user')
                                ->where('friend_id', Auth::id())
                                ->where('accepted', false)
                                ->whereHas('user', function ($q) {
                                    $q->where('name', 'like', '%' . $this->request . '%')
                                    ->orWhere('email', 'like', '%' . $this->request . '%');
                                })
                                ->get();
        }

        return view('livewire.requests', compact('requests'));
    }
}
