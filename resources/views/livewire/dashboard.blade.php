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
                                    @foreach($groups as $group)
                                        <a
                                            href="#"
                                            class="filterDiscussions all read single" id="list-chat-list"
                                            data-room="{{ $group->name }}"
                                            data-group-id={{ $group->id }}
                                            data-image={{ asset('storage') . '/'. $group->image }}
                                            data-toggle="list"
                                            role="tab"
                                            wire:key="group-{{ $group->id }}"
                                        >
                                            <img class="avatar-md" src={{ asset('storage') . '/'. $group->image }} data-toggle="tooltip" data-placement="top" title="Janette" alt="avatar">
                                            <div class="data">
                                                <h5>{{ $group->name }}</h5>
                                                <p>{{ $group->description }}</p>
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
        <!-- Start of Add Friends -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="requests">
                    <div class="title">
                        <h1>Add your friends</h1>
                        <button type="button" class="btn" data-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
                    </div>
                    <div class="content">
                        <form>
                            <div class="form-group">
                                <label for="user">Username:</label>
                                <input type="text" class="form-control" id="user" placeholder="Add recipient..." required>
                                <div class="user" id="contact">
                                    <img class="avatar-sm" src="dist/img/avatars/avatar-female-5.jpg" alt="avatar">
                                    <h5>Keith Morris</h5>
                                    <button class="btn"><i class="material-icons">close</i></button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="welcome">Message:</label>
                                <textarea class="text-control" id="welcome" placeholder="Send your welcome message...">Hi Keith, I'd like to add you as a contact.</textarea>
                            </div>
                            <button type="submit" class="btn button w-100">Send Friend Request</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Add Friends -->
        <!-- Start of Create Group -->
        <div class="modal fade" id="startnewchat" tabindex="-1" role="dialog" aria-labelledby="startnewchat" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="requests">
                    <div class="title">
                        <h1>Create New Group</h1>
                        <button type="button" class="btn" data-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
                    </div>
                    <div class="content">
                        @if (session('success'))
                            <div
                                x-data
                                x-init="
                                    setTimeout(() => {
                                        Livewire.navigate('/groups')
                                    }, 3000)
                                "
                                class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form wire:submit.prevent="storeGroup" id="createGroupForm">
                            <div class="form-group">
                                <label for="topic">Group Name:</label>
                                <input type="text" class="form-control" id="topic" placeholder="What's the group name?" wire:model="groupName">

                                @error('groupName')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="message">Group Description: (optional)</label>
                                <textarea class="text-control" id="message" placeholder="Enter group description..." wire:model="groupDescription"></textarea>

                                @error('groupDescription')
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="image">Group Image:</label>
                                <input type="file" class="form-control" id="image" wire:model="groupImage">

                                <div wire:loading wire:target="groupImage">
                                    Uploading image...
                                </div>

                                @error('groupImage')
                                    <div class="error">{{ $message }}</div>
                                @enderror

                                @if ($photo)
                                    <img src="{{ asset('storage/' . $photo) }}" alt="Uploaded Image" width="200">
                                @endif
                            </div>
                            <button type="submit" class="btn button w-100" id="createGroup">
                                Create Group
                                <span wire:loading wire:target="storeGroup" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Create Group -->

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
                                                <img class="avatar-md group-img" src="dist/img/avatars/avatar-female-5.jpg" data-toggle="tooltip" data-placement="top" title="Group Image" alt="avatar">
                                            </a>

                                            <div class="data">
                                                <h5 class="group-name"><a href="#"></a></h5>
                                            </div>
                                            <button class="btn d-md-block d-none"><i class="material-icons md-30">info</i></button>
                                            <div class="dropdown">
                                                <button class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons md-30">more_vert</i></button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <button class="dropdown-item"><i class="material-icons">clear</i>Clear History</button>
                                                    <button class="dropdown-item"><i class="material-icons">block</i>Leave Group</button>
                                                    <button class="dropdown-item"><i class="material-icons">delete</i>Delete Group</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="content" id="content">
                                <div class="container">
                                    <div class="col-md-12 all-messages">
                                        <p style="text-align: center; background: #2196f3; color: #fff; padding: 3px; border-radius: 3px;">This is a bot message</p>
                                        <div class="date">
                                            <hr>
                                            <span>Yesterday</span>
                                            <hr>
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
        <input type="hidden" id="user-details" value={{ auth()->user() }}>
        <input type="hidden" id="group-id" value="">
    </div> <!-- Layout -->
</main>
