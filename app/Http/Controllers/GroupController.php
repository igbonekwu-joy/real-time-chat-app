<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMessage;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function sendMessage (Request $request) {
        $message = GroupMessage::create([
            'group_id' => $request->group_id,
            'user_id' => $request->user_id,
            'message' => $request->message
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Message saved successfully'
        ], 200);
    }

    public function getMessages (Request $request) {
        $messages = GroupMessage::with('user')
                    ->where('group_id', $request->group_id)
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
}
