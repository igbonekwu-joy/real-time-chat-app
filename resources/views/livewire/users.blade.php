<main>
    <div class="layout">
        @include('layouts.partials.sidebar')

        <!-- Start of Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="container">
                <div class="col-md-12">
                    <div class="tab-content">
                        <!-- Start of Groups Discussions -->
                        <div id="discussions" class="tab-pane fade active show">
                            <div class="search">
                                <form class="form-inline position-relative">
                                    <input type="search" class="form-control" id="conversations" placeholder="Search for users..." wire:model.live.debounce.300ms="user">
                                    <button type="button" class="btn btn-link loop"><i class="material-icons">search</i></button>
                                </form>
                            </div>

                            <div class="discussions">
                                <h1>Site Users</h1>
                                <div class="list-group" id="chats" role="tablist">
                                    @if(count($users) == 0)
                                        <p class="text-center">No users found.</p>
                                    @endif

                                    @foreach($users as $user)
                                        <a
                                            href="#"
                                            class="filterDiscussions all single"
                                            id="user-list"
                                            wire:click.prevent="selectUser({{ $user->id }})"
                                            wire:key="user-{{ $user->id }}"
                                        >
                                            @if($user->image)
                                                <img class="avatar-md" src={{ asset('storage') . '/'. $user->image }} data-toggle="tooltip" data-placement="top" title="Janette" alt="avatar">
                                            @else
                                                <div class="avatar-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" xml:space="preserve"><path fill="#282828" d="M135.832 140.848h-70.9c-2.9 0-5.6-1.6-7.4-4.5-1.4-2.3-1.4-5.7 0-8.6l4-8.2c2.8-5.6 9.7-9.1 14.9-9.5 1.7-.1 5.1-.8 8.5-1.6 2.5-.6 3.9-1 4.7-1.3-.2-.7-.6-1.5-1.1-2.2-6-4.7-9.6-12.6-9.6-21.1 0-14 9.6-25.3 21.5-25.3s21.5 11.4 21.5 25.3c0 8.5-3.6 16.4-9.6 21.1-.5.7-.9 1.4-1.1 2.1.8.3 2.2.7 4.6 1.3 3 .7 6.6 1.3 8.4 1.5 5.3.5 12.1 3.8 14.9 9.4l3.9 7.9c1.5 3 1.5 6.8 0 9.1-1.6 2.9-4.4 4.6-7.2 4.6zm-35.4-78.2c-9.7 0-17.5 9.6-17.5 21.3 0 7.4 3.1 14.1 8.2 18.1.1.1.3.2.4.4 1.4 1.8 2.2 3.8 2.2 5.9 0 .6-.2 1.2-.7 1.6-.4.3-1.4 1.2-7.2 2.6-2.7.6-6.8 1.4-9.1 1.6-4.1.4-9.6 3.2-11.6 7.3l-3.9 8.2c-.8 1.7-.9 3.7-.2 4.8.8 1.3 2.3 2.6 4 2.6h70.9c1.7 0 3.2-1.3 4-2.6.6-1 .7-3.4-.2-5.2l-3.9-7.9c-2-4-7.5-6.8-11.6-7.2-2-.2-5.8-.8-9-1.6-5.8-1.4-6.8-2.3-7.2-2.5-.4-.4-.7-1-.7-1.6 0-2.1.8-4.1 2.2-5.9.1-.1.2-.3.4-.4 5.1-3.9 8.2-10.7 8.2-18-.2-11.9-8-21.5-17.7-21.5z"/></svg>
                                                </div>
                                            @endif

                                            <div class="data">
                                                <h5>{{ $user->name }}</h5>
                                                <p>
                                                    {{ $user->email }}
                                                </p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                        <!-- End of Groups Discussions -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Sidebar -->

        @if($selectedUser)
            <section class="section about-section gray-bg" id="about">
                <div class="container">
                    @if(session('success'))
                        <div class="bg-green-100 text-green-800 text-center px-4 py-2 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="row align-items-center flex-row-reverse">
                        <div class="col-lg-6">
                            <div class="about-text go-to">
                                <h4 class="dark-color">About <span class="username">{{ $selectedUser->name }}</span></h4>
                                <h6 class="theme-color lead" id="about">{{ $selectedUser->about ?? 'User' }}</h6>
                                <div class="row about-list">
                                    <div class="col-md-6">
                                        <div class="">
                                            <label>E-mail</label><br/>
                                            <p id="email">{{ $selectedUser->email }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="">
                                            <label>Username</label> <br/>
                                            <p class="username">{{  $selectedUser->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            @if($selectedUser->image)
                                <div class="about-avatar">
                                    <img src="{{ asset('storage/' . $selectedUser->image) }}" alt="avatar">
                                </div>
                            @else
                                <div class="about-avatar">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200" xml:space="preserve"><path fill="#282828" d="M135.832 140.848h-70.9c-2.9 0-5.6-1.6-7.4-4.5-1.4-2.3-1.4-5.7 0-8.6l4-8.2c2.8-5.6 9.7-9.1 14.9-9.5 1.7-.1 5.1-.8 8.5-1.6 2.5-.6 3.9-1 4.7-1.3-.2-.7-.6-1.5-1.1-2.2-6-4.7-9.6-12.6-9.6-21.1 0-14 9.6-25.3 21.5-25.3s21.5 11.4 21.5 25.3c0 8.5-3.6 16.4-9.6 21.1-.5.7-.9 1.4-1.1 2.1.8.3 2.2.7 4.6 1.3 3 .7 6.6 1.3 8.4 1.5 5.3.5 12.1 3.8 14.9 9.4l3.9 7.9c1.5 3 1.5 6.8 0 9.1-1.6 2.9-4.4 4.6-7.2 4.6zm-35.4-78.2c-9.7 0-17.5 9.6-17.5 21.3 0 7.4 3.1 14.1 8.2 18.1.1.1.3.2.4.4 1.4 1.8 2.2 3.8 2.2 5.9 0 .6-.2 1.2-.7 1.6-.4.3-1.4 1.2-7.2 2.6-2.7.6-6.8 1.4-9.1 1.6-4.1.4-9.6 3.2-11.6 7.3l-3.9 8.2c-.8 1.7-.9 3.7-.2 4.8.8 1.3 2.3 2.6 4 2.6h70.9c1.7 0 3.2-1.3 4-2.6.6-1 .7-3.4-.2-5.2l-3.9-7.9c-2-4-7.5-6.8-11.6-7.2-2-.2-5.8-.8-9-1.6-5.8-1.4-6.8-2.3-7.2-2.5-.4-.4-.7-1-.7-1.6 0-2.1.8-4.1 2.2-5.9.1-.1.2-.3.4-.4 5.1-3.9 8.2-10.7 8.2-18-.2-11.9-8-21.5-17.7-21.5z"/></svg>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="loader-container">
                        @if($this->isFriend($selectedUser->id))
                            <button
                                class="btn btn-primary loader"
                                style="background: #2196f3; width: 80%;"
                                wire:click.prevent="addFriend({{ $selectedUser->id }})"
                            >
                                <i class="fa fa-user-minus"></i>
                                Unfriend
                            </button>
                        @elseif($this->isPending($selectedUser->id))
                            <button
                                class="btn btn-primary loader"
                                style="background: #2196f3; width: 80%;"
                                wire:click.prevent="addFriend({{ $selectedUser->id }})"
                            >
                                <i class="fa fa-clock"></i>
                                Pending
                            </button>
                        @else
                            <button
                                class="btn btn-primary loader"
                                style="background: #2196f3; width: 80%;"
                                wire:click.prevent="addFriend({{ $selectedUser->id }})"
                            >
                                <i class="fa fa-user-plus"></i>
                                Add Friend
                            </button>
                        @endif
                    </div>
                </div>
            </section>
        @endif
    </div>
</main>
