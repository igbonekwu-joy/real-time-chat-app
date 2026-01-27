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
                        {{-- <a href="#notifications" class="f-grow1">
                            <i class="material-icons">notifications_none</i>
                        </a> --}}
                        <a href="{{ route('friends') }}" title="Friends" wire:navigate>
                            <i class="material-icons {{ request()->routeIs('friends') ? 'active' : '' }}">
                                link
                            </i>
                        </a>
                        <a href="{{ route('requests') }}" title="Friend Requests" wire:navigate>
                            <div class="requests-div-{{ auth()->user()->id }}" style="border-radius: 50%; background: #2196f3; color: #fff; width: 20px; {{ $friendRequestsCount == 0 ? 'display: none;' : '' }}">
                                <span class="requests-count-{{ auth()->user()->id }}">
                                    {{ $friendRequestsCount }}
                                </span>
                            </div>
                            <i class="material-icons {{ request()->routeIs('requests') ? 'active' : '' }}">
                                group_add
                            </i>
                        </a>
                        <a href="{{ route('users') }}" title="Site Users" wire:navigate>
                            <i class="material-icons {{ request()->routeIs('users') ? 'active' : '' }}">
                                people
                            </i>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn power" type="submit" onclick="visitPage();">
                                <i class="material-icons">power_settings_new</i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
