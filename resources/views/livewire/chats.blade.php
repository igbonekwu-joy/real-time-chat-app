<main>
    <div class="layout">
        <!-- Start of Navigation -->
        @include('layouts.partials.sidebar')
        <!-- End of Navigation -->
        <!-- Start of Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="container">
                <div class="col-md-12">
                    <div class="tab-content">
                        <!-- Start of Discussions -->
                        <div id="discussions" class="tab-pane fade active show">
                            <div class="search">
                                <form class="form-inline position-relative">
                                    <input type="search" class="form-control" id="conversations" placeholder="Search for conversations...">
                                    <button type="button" class="btn btn-link loop"><i class="material-icons" wire:model.live.debounce.300ms="friend">search</i></button>
                                </form>
                                <button class="btn create" data-toggle="modal" data-target="#startnewchat"><i class="material-icons">create</i></button>
                            </div>
                            <div class="list-group sort">
                                <button class="btn filterDiscussionsBtn active show" data-toggle="list" data-filter="all">All</button>
                                <button class="btn filterDiscussionsBtn" data-toggle="list" data-filter="read">Read</button>
                                <button class="btn filterDiscussionsBtn" data-toggle="list" data-filter="unread">Unread</button>
                            </div>
                            <div class="discussions">
                                <h1>Discussions</h1>
                                <div class="list-group" id="chats" role="tablist">
                                    @if(count($friendsList) == 0)
                                        <p class="text-center">No chats yet. Add a friend to start a chat</p>
                                    @endif

                                    @foreach($friendsList as $friend)
                                        <a
                                            href="#"
                                            class="filterDiscussions all read single filter-{{ auth()->user()->id }}-{{ $friend['id'] }}"
                                            id="user-list"
                                            wire:click.prevent="selectFriend({{ $friend['id'] }})"
                                            wire:key="user-{{ $friend['id'] }}"
                                        >
                                            @if($friend['image'])
                                                <img class="avatar-md" src={{ asset('storage') . '/'. $friend->image }} data-toggle="tooltip" data-placement="top" title="Janette" alt="avatar">
                                            @else
                                                <div class="avatar-md">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" xml:space="preserve"><path fill="#282828" d="M135.832 140.848h-70.9c-2.9 0-5.6-1.6-7.4-4.5-1.4-2.3-1.4-5.7 0-8.6l4-8.2c2.8-5.6 9.7-9.1 14.9-9.5 1.7-.1 5.1-.8 8.5-1.6 2.5-.6 3.9-1 4.7-1.3-.2-.7-.6-1.5-1.1-2.2-6-4.7-9.6-12.6-9.6-21.1 0-14 9.6-25.3 21.5-25.3s21.5 11.4 21.5 25.3c0 8.5-3.6 16.4-9.6 21.1-.5.7-.9 1.4-1.1 2.1.8.3 2.2.7 4.6 1.3 3 .7 6.6 1.3 8.4 1.5 5.3.5 12.1 3.8 14.9 9.4l3.9 7.9c1.5 3 1.5 6.8 0 9.1-1.6 2.9-4.4 4.6-7.2 4.6zm-35.4-78.2c-9.7 0-17.5 9.6-17.5 21.3 0 7.4 3.1 14.1 8.2 18.1.1.1.3.2.4.4 1.4 1.8 2.2 3.8 2.2 5.9 0 .6-.2 1.2-.7 1.6-.4.3-1.4 1.2-7.2 2.6-2.7.6-6.8 1.4-9.1 1.6-4.1.4-9.6 3.2-11.6 7.3l-3.9 8.2c-.8 1.7-.9 3.7-.2 4.8.8 1.3 2.3 2.6 4 2.6h70.9c1.7 0 3.2-1.3 4-2.6.6-1 .7-3.4-.2-5.2l-3.9-7.9c-2-4-7.5-6.8-11.6-7.2-2-.2-5.8-.8-9-1.6-5.8-1.4-6.8-2.3-7.2-2.5-.4-.4-.7-1-.7-1.6 0-2.1.8-4.1 2.2-5.9.1-.1.2-.3.4-.4 5.1-3.9 8.2-10.7 8.2-18-.2-11.9-8-21.5-17.7-21.5z"/></svg>
                                                </div>
                                            @endif

                                            <div class="status">
                                                @if($friend['isOnline'])
                                                    <i class="material-icons online">fiber_manual_record</i>
                                                @else
                                                    <i class="material-icons offline">fiber_manual_record</i>
                                                @endif
                                            </div>

                                            <div
                                                class="new bg-pink {{  $friend['unreadCount'] == 0 ? 'd-none' : ''}} unread-div-{{ auth()->user()->id }}-{{ $friend['id'] }}"
                                            >
                                                <span>+
                                                    <span
                                                        class="unread-count-{{ auth()->user()->id }}-{{ $friend['id'] }}"
                                                    >
                                                        {{ $friend['unreadCount'] }}
                                                    </span>
                                                </span>
                                            </div>

                                            <div class="data">
                                                <h5>{{ $friend['name'] }}</h5>

                                                @if($friend['blocked_by'] == auth()->user()->id)
                                                    <span>Blocked</span>
                                                @else
                                                    <span>{{ \Carbon\Carbon::parse($friend['lastMessage'])->format('D') }}</span>
                                                @endif

                                                <p>
                                                    {{ $friend['email'] }}
                                                </p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- End of Discussions -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Sidebar -->

        @include('layouts.partials.chat.chat-area')

    </div> <!-- Layout -->
</main>
