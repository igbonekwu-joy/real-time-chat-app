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

    public function checkFriendRequest($userId) {
        return UserFriend::where('user_id', $userId)
                        ->where('friend_id', Auth::user()->id)
                        ->where('accepted', false)
                        ->exists();
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

    public function isFriend($userId) {
        $caseOne = UserFriend::where('user_id', Auth::user()->id)
                        ->where('friend_id', $userId)
                        ->where('accepted', true)
                        ->exists();

        $caseTwo = UserFriend::where('user_id', $userId)
                        ->where('friend_id', Auth::user()->id)
                        ->where('accepted', true)
                        ->exists();

        return $caseOne || $caseTwo;
    }

    public function isPending($userId) {
        return UserFriend::where('user_id', Auth::user()->id)
                        ->where('friend_id', $userId)
                        ->where('accepted', false)
                        ->exists();
    }

    public function unFriend($userId) {
        UserFriend::where('user_id', Auth::user()->id)
                    ->where('friend_id', $userId)
                    ->delete();

        session()->flash('success', 'The friend request has been removed.');
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
