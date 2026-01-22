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
                        <!-- Start of Groups Discussions -->
                        <div id="discussions" class="tab-pane fade active show">
                            <div class="search">
                                <form class="form-inline position-relative">
                                    <input type="search" class="form-control" id="conversations" placeholder="Search for groups...">
                                    <button type="button" class="btn btn-link loop"><i class="material-icons">search</i></button>
                                </form>
                                <button class="btn create" data-toggle="modal" data-target="#startnewchat">
                                    <i class="material-icons">create</i>
                                </button>
                            </div>
                            <div class="list-group sort">
                                <button class="btn filterDiscussionsBtn active show" data-toggle="list" data-filter="all">All</button>
                                <button class="btn filterDiscussionsBtn" data-toggle="list" data-filter="read">Read</button>
                                <button class="btn filterDiscussionsBtn" data-toggle="list" data-filter="unread">Unread</button>
                            </div>
                            <div class="discussions">
                                <h1>Groups</h1>
                                <div class="list-group" id="chats" role="tablist">
                                    @if(count($groups) == 0)
                                        <p class="text-center">No groups found. Create groups to start a conversation</p>
                                    @endif

                                    @foreach($groups as $group)
                                        <a
                                            href="#"
                                            class="filterDiscussions all {{ $group->unread_count > 0 ? 'unread' : 'read' }} single filter-{{ $group->id }}"
                                            id="list-chat-list"
                                            data-room="{{ $group->name }}"
                                            data-is-admin="{{ $group->users->where('id', auth()->user()->id)->first()?->pivot->is_admin ?? 0 }}"
                                            data-group-id={{ $group->id }}
                                            data-image={{ asset('storage') . '/'. $group->image }}
                                            data-toggle="list"
                                            role="tab"
                                            wire:key="group-{{ $group->id }}"
                                        >
                                            <img class="avatar-md" src={{ asset('storage') . '/'. $group->image }} data-toggle="tooltip" data-placement="top" title="Janette" alt="avatar">

                                            <div
                                                class="new bg-yellow unread-div-{{ $group->id }}"
                                                style="{{ $group->unread_count > 0 ? '' : 'display: none' }}"
                                            >
                                                <span>+<span class="unread-count-{{ $group->id }}">{{ $group->unread_count }}</span></span>
                                            </div>

                                            <div class="data">
                                                <h5>{{ $group->name }}</h5>
                                                <p>{{ $group->description }}</p>
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

        <div class="main">
            <div class="tab-content" id="nav-tabContent">
                <!-- Start of Babble -->
                <div class="babble tab-pane fade active show" id="list-chat" role="tabpanel" aria-labelledby="list-chat-list">
                    <!-- Start of Chat -->
                    <div class="chat" id="chat1">
                        <div class="no-message-container">
                            <div class="no-message">
                                <p>Welcome!. Share what's on your mind with other people</p>
                            </div>
                        </div>

                        <div class="chat-container" style="display: none;">
                            <div class="top">
                                <div class="container">
                                    <div class="col-md-12">
                                        <div class="inside">
                                            <a href="#">
                                                <img class="avatar-md group-img" src="" data-toggle="tooltip" data-placement="top" title="Group Image" alt="avatar">
                                            </a>

                                            <div class="data">
                                                <h5>
                                                    <a href="#" class="group-name"></a>
                                                </h5>
                                            </div>
                                            <button class="btn d-md-block d-none"><i class="material-icons md-30">info</i></button>
                                            <div class="dropdown">
                                                <button class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons md-30">more_vert</i></button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <button type="button" id="addMemberBtn" data-toggle="modal" data-target="#addMemberModal" class="dropdown-item">
                                                        <i class="material-icons">person_add</i>Add Member
                                                    </button>

                                                    <button class="dropdown-item"><i class="material-icons">clear</i>Clear History</button>
                                                    <button class="dropdown-item" id="leaveGroup">
                                                        <i class="material-icons">block</i>Leave Group
                                                    </button>
                                                    <button class="dropdown-item" id="deleteGroup">
                                                        <i class="material-icons">delete</i>Delete Group
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="content" id="content">
                                <div class="container">
                                    <div class="col-md-12 all-messages">
                                        <div class="loader-container">
                                            <div class="loader">
                                                <span class="spinner-border spinner-border-sms" role="status"></span>
                                            </div>
                                        </div>
                                        {{-- messages go here --}}

                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="col-md-12">
                                    <div class="bottom">
                                        <form class="position-relative w-100">
                                            <textarea class="form-control message-content" placeholder="Start typing for reply..." rows="1"></textarea>
                                            <button class="btn emoticons"><i class="material-icons">insert_emoticon</i></button>
                                            <button type="submit" class="btn send send-message"><i class="material-icons">send</i></button>
                                        </form>
                                        <label>
                                            <input type="file">
                                            <span class="btn attach d-sm-block d-none"><i class="material-icons">attach_file</i></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Chat -->
                </div>
                <!-- End of Babble -->
            </div>
        </div>

        @include('layouts.partials.modals')

        <input type="hidden" id="user-details" value={{ auth()->user() }}>
        <input type="hidden" id="group-id" value="" wire:model="groupId">
    </div> <!-- Layout -->
</main>
