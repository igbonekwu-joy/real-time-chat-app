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

    public $group;


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
        $groups = Group::whereIn(
            'id',
            GroupUser::where('user_id', Auth::id())->pluck('group_id')
        )
        ->withCount([
            'messages as unread_count' => function ($q) {
                $q->whereHas('reads', function ($r) {
                    $r->where('user_id', Auth::id())
                    ->whereNull('read_at');
                });
            }
        ])
        ->get();
        
        //for searches
        if($this->group) {
            $groups = Group::whereIn(
                'id',
                GroupUser::where('user_id', Auth::id())->pluck('group_id')
            )
            ->where('name', 'like', '%' . $this->group . '%')
            ->withCount([
                'messages as unread_count' => function ($q) {
                    $q->whereHas('reads', function ($r) {
                        $r->where('user_id', Auth::id())
                        ->whereNull('read_at');
                    });
                }
            ])
            ->get();
        }


        return view('livewire.dashboard', compact('groups'));
    }
}
