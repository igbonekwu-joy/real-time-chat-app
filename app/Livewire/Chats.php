<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\User;
use App\Models\UserFriend;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Chats extends Component
{
    public $friend;
    public $selectedFriend;
    public $image;
    public $message;

    protected $listeners = ['receiveMessage', 'typing', 'endTyping'];
    public array $messages = [];
    public $oldMessages;
    public bool $isTyping = false;

    public function selectFriend($friendId) {
        $this->messages = [];
        $this->isTyping = false;
        $this->selectedFriend = User::findOrFail($friendId);

        if($this->selectedFriend->image) {
            $this->image = '<img class="avatar-md" src="asset(\'storage\')/'.$this->selectedFriend->image.'" data-toggle="tooltip" data-placement="top" title="Keith" alt="avatar">';
        }
        else{
            $this->image = '<div class="avatar-md">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" xml:space="preserve"><path fill="#282828" d="M135.832 140.848h-70.9c-2.9 0-5.6-1.6-7.4-4.5-1.4-2.3-1.4-5.7 0-8.6l4-8.2c2.8-5.6 9.7-9.1 14.9-9.5 1.7-.1 5.1-.8 8.5-1.6 2.5-.6 3.9-1 4.7-1.3-.2-.7-.6-1.5-1.1-2.2-6-4.7-9.6-12.6-9.6-21.1 0-14 9.6-25.3 21.5-25.3s21.5 11.4 21.5 25.3c0 8.5-3.6 16.4-9.6 21.1-.5.7-.9 1.4-1.1 2.1.8.3 2.2.7 4.6 1.3 3 .7 6.6 1.3 8.4 1.5 5.3.5 12.1 3.8 14.9 9.4l3.9 7.9c1.5 3 1.5 6.8 0 9.1-1.6 2.9-4.4 4.6-7.2 4.6zm-35.4-78.2c-9.7 0-17.5 9.6-17.5 21.3 0 7.4 3.1 14.1 8.2 18.1.1.1.3.2.4.4 1.4 1.8 2.2 3.8 2.2 5.9 0 .6-.2 1.2-.7 1.6-.4.3-1.4 1.2-7.2 2.6-2.7.6-6.8 1.4-9.1 1.6-4.1.4-9.6 3.2-11.6 7.3l-3.9 8.2c-.8 1.7-.9 3.7-.2 4.8.8 1.3 2.3 2.6 4 2.6h70.9c1.7 0 3.2-1.3 4-2.6.6-1 .7-3.4-.2-5.2l-3.9-7.9c-2-4-7.5-6.8-11.6-7.2-2-.2-5.8-.8-9-1.6-5.8-1.4-6.8-2.3-7.2-2.5-.4-.4-.7-1-.7-1.6 0-2.1.8-4.1 2.2-5.9.1-.1.2-.3.4-.4 5.1-3.9 8.2-10.7 8.2-18-.2-11.9-8-21.5-17.7-21.5z"/></svg>
                    </div>';
        }

        $this->loadMessages($friendId);

        $authId = Auth::user()->id;
        $roomName = 'chat_' . min($authId, $friendId) . '_' . max($authId, $friendId);
        $this->dispatch('join-room',
            group: $roomName
        );

        $this->dispatch('scroll-to-bottom');
    }

    public function sendMessage($receiverId) {
        $this->validate([
            'message' => 'required|string'
        ]);

        $toUser = User::findOrFail($receiverId);

        Message::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => $receiverId,
            'message' => $this->message,
            'sent_at' => Carbon::now()
        ]);

        $authId = Auth::user()->id;
        $roomName = 'chat_' . min($authId, $receiverId) . '_' . max($authId, $receiverId);
        $this->dispatch('send-message',
            roomName: $roomName,
            message: $this->message,
            receiverId: $receiverId,
            fromUser: [
                'id' => Auth::user()->id,
                'name' => Auth::user()->name,
                'image' => Auth::user()->image
            ]
        );

        $this->stopTyping($receiverId);

        $this->dispatch('scroll-to-bottom');
    }

    public function receiveMessage($receiverId, $message) {
        if($this->selectedFriend->id !== $receiverId) {
            return;
        }

        $this->messages[] = [
            'username' => $message['username'],
            'text' => $message['text'],
            'time' => $message['time'],
            'sender_id' =>  $message['groupId']
        ];

        $this->message = '';
    }

    public function startTyping($friendId, $senderId)
    {
        if($this->message !== '') {
            $this->dispatch('typing',
                username: Auth::user()->name,
                senderId: $senderId,
                room: 'chat_' . min(Auth::user()->id, $friendId) . '_' . max(Auth::user()->id, $friendId)
            );
        }
    }

    public function typing($username, $senderId) {
        if($username === Auth::user()->name) {
            return;
        }

        if($this->selectedFriend->id !== $senderId) {
            return;
        }

        $this->isTyping = true;
    }

    public function stopTyping($friendId)
    {
        $this->dispatch('stopTyping',
            username: Auth::user()->name,
            room: 'chat_' . min(Auth::user()->id, $friendId) . '_' . max(Auth::user()->id, $friendId)
        );
    }

    public function endTyping($username) {
        if($username === Auth::user()->name) {
            return;
        }

        $this->isTyping = false;
    }

    public function loadMessages($friendId) {
        $messages = Message::where(function ($q) use ($friendId) {
                    $q->where('sender_id', Auth::user()->id)
                    ->where('receiver_id', $friendId);
                })
                ->orWhere(function ($q) use ($friendId) {
                    $q->where('sender_id', $friendId)
                    ->where('receiver_id', Auth::user()->id);
                })
                ->orderBy('created_at')
                ->get();

        //get old messages
        $this->oldMessages = $messages;

        //update read status
        Message::where('sender_id', $friendId)
                ->where('receiver_id', Auth::user()->id)
                ->where('is_read', false)
                ->update([
                    'is_read' => true
                ]);
    }

    public function render()
    {
        $friends = UserFriend::with(['user', 'friend'])
                    ->where('user_id', Auth::user()->id)
                    ->orWhere('friend_id', Auth::user()->id)
                    ->get();

        if($this->friend) {
            $friends = UserFriend::with(['user', 'friend'])
                        ->where('user_id', Auth::user()->id)
                        ->orWhere('friend_id', Auth::user()->id)
                        ->whereHas('user', function ($q) {
                            $q->where('name', 'like', '%' . $this->friend . '%')
                            ->orWhere('email', 'like', '%' . $this->friend . '%');
                        })
                        ->get();
        }

        $friendsList = $friends->map(function ($row) {
            $friend = $row->user_id == Auth::user()->id ?
                                    $row->friend :
                                    $row->user;

            $friend->unreadCount = Message::where('sender_id', $friend->id)
                                            ->where('receiver_id', Auth::user()->id)
                                            ->where('is_read', false)
                                            ->count();

            $friend->lastMessage = Message::where('sender_id', $friend->id)
                                ->where('receiver_id', Auth::id())
                                ->latest('created_at')
                                ->value('created_at');

            return $friend;
        });



        return view('livewire.chats', compact('friendsList'));
    }
}
