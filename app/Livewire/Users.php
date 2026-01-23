<?php

namespace App\Livewire;

use App\Models\Notification;
use App\Models\User;
use App\Models\UserFriend;
use App\Services\RequestsService;
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

        Notification::create([
            'user_id' => $userId,
            'message' => Auth::user()->name . ' has sent you a friend request.'
        ]);

        //notify the frontend of the friend request event
        $this->dispatch('friend-request-sent',
            toUserId: $userId,
            fromUser: [
                'id' => Auth::user()->id,
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'image' => Auth::user()->image
            ]
        );

        session()->flash('success', 'A friend request has been sent. You would be notified when they accept.');
    }

    public function checkFriendRequest($userId) {
        return UserFriend::where('user_id', $userId)
                        ->where('friend_id', Auth::user()->id)
                        ->where('accepted', false)
                        ->exists();
    }

    public function ignoreRequest($userId) {
        app(RequestsService::class)->ignoreRequest($userId);

        session()->flash('success', 'The friend request has been removed.');
    }

    public function acceptRequest($userId) {
        app(RequestsService::class)->acceptRequest($userId);

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
        $caseOne = UserFriend::where('user_id', Auth::user()->id)
                    ->where('friend_id', $userId)
                    ->delete();

        $caseTwo = UserFriend::where('user_id', $userId)
                    ->where('friend_id', Auth::user()->id)
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
