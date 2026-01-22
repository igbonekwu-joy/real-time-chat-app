<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupClear;
use App\Models\GroupMessage;
use App\Models\GroupMessageRead;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function sendMessage (Request $request) {
        $member = GroupUser::where('user_id', $request->user_id)
                    ->where('group_id', $request->group_id)
                    ->first();
        if(!$member) {
            return response()->json([
                'status' => false,
                'message' => 'You are not a member of this group'
            ], 409);
        }

        //save message
        $message = GroupMessage::create([
            'group_id' => $request->group_id,
            'user_id' => $request->user_id,
            'message' => $request->message
        ]);

        //mark message as unread for everyone except the sender
        $members = GroupUser::where('group_id', $request->group_id)->pluck('user_id');

        foreach($members as $userId) {
            if($userId !== Auth::user()->id) {
                GroupMessageRead::create([
                    'group_message_id' => $message->id,
                    'user_id' => $userId,
                    'read_at' => null
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Message saved successfully'
        ], 200);
    }

    public function getMessages (Request $request) {
        $clearedAt = GroupClear::where('group_id', $request->group_id)
            ->where('user_id', Auth::user()->id)
            ->value('cleared_at');

        $messages = GroupMessage::with('user')
            ->where('group_id', $request->group_id)
            ->when($clearedAt, function ($q) use ($clearedAt) {
                $q->where('created_at', '>', $clearedAt);
            })
            ->orderBy('created_at')
            ->get();

        return response()->json([
            'status' => true,
            'messages' => $messages
        ], 200);
    }

    public function addMember (Request $request) {
        $groupId = $request->input('groupId');
        $username = $request->input('username');

        $user = User::where('name', $username)
                    ->orWhere('email', $username)
                    ->first();

        //if user does not exist
        if(!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User does not exist'
            ], 404);
        }

        //if user is already a member
        if(GroupUser::where('group_id', $groupId)->where('user_id', $user->id)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'User is already a member'
            ], 409);
        }

        GroupUser::create([
            'group_id' => $groupId,
            'user_id' => $user->id
        ]);

        //create new bot message
        GroupMessage::create([
            'group_id' => $groupId,
            'user_id' => $user->id,
            'message' => $user->name . ' was added',
            'bot' => 1
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Member added successfully'
        ]);
    }

    public function clearHistory (Request $request) {
        $groupId = $request->input('groupId');
        $userId = $request->input('userId');

        $request->validate([
            'groupId' => 'required|exists:groups,id',
            'userId' => 'required|exists:users,id'
        ]);

        GroupClear::updateOrCreate(
            [
                'group_id' => $groupId,
                'user_id' => $userId
            ],
            [
                'cleared_at' => now()
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'History cleared successfully'
        ]);
    }

    public function leaveGroup (Request $request) {
        $groupId = $request->input('groupId');
        $userId = $request->input('userId');

        $user = User::where('id', $userId)->first();

        $group = Group::where('id', $groupId)->first();
        if($group->user_id == $userId) { //if the user is the creator
            return response()->json([
                'status' => false,
                'message' => 'You cannot leave your own group. Delete instead.'
            ], 409);
        }

        GroupUser::where('group_id', $groupId)->where('user_id', $userId)->delete();

        GroupMessage::create([
            'group_id' => $groupId,
            'user_id' => $userId,
            'message' => $user->name . ' left the group',
            'bot' => 1
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Member left successfully'
        ]);
    }

    public function deleteGroup (Request $request) {
        $messages = GroupMessage::where('group_id', $request->groupId)->get();

        foreach($messages as $message) {
            $message->delete();
        }

        Group::where('id', $request->groupId)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Group deleted successfully'
        ]);
    }

    public function markAsRead (Request $request) {
        GroupMessageRead::where('user_id', Auth::user()->id)
            ->whereHas('message', function ($q) use ($request) {
                $q->where('group_id', $request->input('groupId'));
            })
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['status' => 'ok']);
    }
}
