<aside class="kiri-side">
    {{-- {{ $showSidebar ? 'sidebar-open' : '' }} --}}
    <div class="user-head">
        <i class="fa fa-comments-o"></i>
    </div>
    <ul class="chat-list">
        {{-- <li class="">
            <a class="lobby" href="#lobby.html">
                <h4>
                    <i class="fa fa-list"></i>
                    Lobby
                </h4>
            </a>
        </li> --}}
        <li class={{ request()->routeIs('dashboard') ? 'active' : '' }}>
            <a href={{ route('dashboard') }}>
                <i class="fa fa-list"></i>
                <span>Groups</span>
                <i class="fa fa-times pull-right"></i>
            </a>
        </li>
        <li class={{ request()->routeIs('chats') ? 'active' : '' }}>
            <a href={{ route('chats') }}>
                <i class="fa fa-comments"></i>
                <span>Chats</span>
                <i class="fa fa-times pull-right"></i>
            </a>
        </li>
    </ul>
    <footer>
        <a class="chat-avatar" href="#javascript:;">
            <img alt="" src="https://bootdey.com/img/Content/avatar/avatar1.png">
        </a>
        <div class="user-status">
            <i class="fa fa-circle text-success"></i>
            Available
        </div>
        <a class="chat-dropdown pull-right" href="#javascript:;">
            <i class="fa fa-chevron-down"></i>
        </a>
    </footer>
</aside>
