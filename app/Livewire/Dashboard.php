<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Livewire\Attributes\Rule;
use Livewire\Component;
use App\Models\Group;
use App\Models\GroupUser;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;

class Dashboard extends Component
{
    use WithFileUploads;

    public bool $showSidebar = false;

    #[Rule('required|min:3|max:50|string')]
    public $groupName;

    #[Rule('nullable|min:10|max:1000|string')]
    public $groupDescription;

    #[Rule('required|image|mimes:jpeg,png,jpg,svg|max:2048')]
    public $groupImage;

    public $photo;

    public function toggleSidebar()
    {
        $this->showSidebar = ! $this->showSidebar;
    }

    public function storeGroup() {
        $this->validate();

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

        session()->flash('success', 'Group Created Successfully');

       // return $this->redirect('/groups', navigate: true);
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
