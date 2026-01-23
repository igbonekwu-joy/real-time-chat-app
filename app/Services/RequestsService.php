<?php

namespace App\Services;

use App\Models\UserFriend;
use Illuminate\Support\Facades\Auth;

class RequestsService
{
    public function acceptRequest(int $userId): void
    {
        $friend = UserFriend::where('user_id', $userId)
                    ->where('friend_id', Auth::user()->id)
                    ->first();

        if($friend) {
            $friend->update(['accepted' => true]);
        }
    }

    public function ignoreRequest($userId) {
        UserFriend::where('user_id', $userId)
                    ->where('friend_id', Auth::user()->id)
                    ->delete();
    }
}
