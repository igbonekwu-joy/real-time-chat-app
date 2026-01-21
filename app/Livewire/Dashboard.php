<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Livewire\Attributes\Rule;
use Livewire\Component;
use App\Models\Group;
use App\Models\GroupMessage;
use App\Models\GroupUser;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;

class Dashboard extends Component
{
    use WithFileUploads;

    public $groupName;
    public $groupDescription;
    public $groupImage;
    public $photo;


    public function storeGroup() {
        $this->validate([
            'groupName' => 'required|min:3|max:50|string',
            'groupDescription' => 'nullable|min:10|max:1000|string',
            'groupImage' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $user = Auth::user();

        $this->photo = $this->groupImage->store('group-images', 'public');
        //Log::info('path to image: ', $this->photo);

        $group = Group::create([
            'user_id' => $user->id,
            'name' => $this->groupName,
            'description' => $this->groupDescription,
            'image' => $this->photo
        ]);

        //add user to group automatically
        GroupUser::create([
            'group_id' => $group->id,
            'user_id' => $user->id,
            'is_admin' => 1
        ]);

        GroupMessage::create([
            'group_id' => $group->id,
            'user_id' => $user->id,
            'message' => $user->name . ' created ' . $this->groupName,
            'bot' => true
        ]);

        session()->flash('success', 'Group Created Successfully');

       // return $this->redirect('/groups', navigate: true);
    }

    public function render()
    {
        $groupIds = GroupUser::where('user_id', Auth::id())
            ->pluck('group_id');

        $groups = Group::whereIn('id', $groupIds)->get();

        return view('livewire.dashboard', compact('groups'));
    }
}
