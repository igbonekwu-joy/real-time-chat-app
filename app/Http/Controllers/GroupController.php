<?php

namespace App\Http\Controllers;

use App\Models\GroupMessage;
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
}
