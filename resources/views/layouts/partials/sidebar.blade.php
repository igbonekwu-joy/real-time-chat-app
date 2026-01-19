<div class="navigation">
            <div class="container">
                <div class="inside">
                    <div class="nav nav-tab menu">
                        <button class="btn">
                            <img class="avatar-xl" src="dist/img/avatars/avatar-male-1.jpg" alt="avatar">
                        </button>
                        <a href={{ route('dashboard') }} class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" data-toggle="tab" wire:navigate>
                            <i class="material-icons {{ request()->routeIs('dashboard') ? 'active' : '' }}">account_circle</i>
                        </a>
                        <a href="{{ route('chats') }}" data-toggle="tab" class="{{ request()->routeIs('chats') ? 'active' : '' }}" wire:navigate>
                            <i class="material-icons {{ request()->routeIs('chats') ? 'active' : '' }}">chat_bubble_outline</i>
                        </a>
                        <a href="#notifications" data-toggle="tab" class="f-grow1" wire:navigate>
                            <i class="material-icons">notifications_none</i>
                        </a>
                        <button class="btn mode">
                            <i class="material-icons">brightness_2</i>
                        </button>
                        <a href="#settings" data-toggle="tab"><i class="material-icons">settings</i></a>
                        <button class="btn power" onclick="visitPage();"><i class="material-icons">power_settings_new</i></button>
                    </div>
                </div>
            </div>
        </div>
