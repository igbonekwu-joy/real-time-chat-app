<div class="navigation">
            <div class="container">
                <div class="inside">
                    <div class="nav nav-tab menu">
                        <button class="btn">
                            <img class="avatar-xl" src="dist/img/avatars/avatar-male-1.jpg" alt="avatar">
                        </button>
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" title="Groups">
                            <i class="material-icons {{ request()->routeIs('dashboard') ? 'active' : '' }}">account_circle</i>
                        </a>
                        <a href="{{ route('chats') }}" class="{{ request()->routeIs('chats') ? 'active' : '' }}" title="Chats" wire:navigate>
                            <i class="material-icons {{ request()->routeIs('chats') ? 'active' : '' }}">chat_bubble_outline</i>
                        </a>
                        <a href="#notifications" class="f-grow1">
                            <i class="material-icons">notifications_none</i>
                        </a>
                        <a href="#friends" title="Friends">
                            <div style="border-radius: 50%; background: #2196f3; color: #fff; width: 20px;">
                                <span>7</span>
                            </div>
                            <i class="material-icons">
                                link
                            </i>
                        </a>
                        <a href="{{ route('users') }}" title="Site Users" wire:navigate>
                            <div style="border-radius: 50%; background: #2196f3; color: #fff; width: 20px;">
                                <span>7</span>
                            </div>
                            <i class="material-icons {{ request()->routeIs('users') ? 'active' : '' }}">
                                people
                            </i>
                        </a>
                        <button class="btn power" onclick="visitPage();"><i class="material-icons">power_settings_new</i></button>
                    </div>
                </div>
            </div>
        </div>
