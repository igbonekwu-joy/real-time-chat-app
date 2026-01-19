<?php

namespace App\Livewire;

use Illuminate\Support\Facades\View;
use Livewire\Component;

class Dashboard extends Component
{
    public bool $showSidebar = false;

    public function toggleSidebar()
    {
        $this->showSidebar = ! $this->showSidebar;
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
