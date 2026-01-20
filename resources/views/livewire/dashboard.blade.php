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
                                    <a href="#list-chat" class="filterDiscussions all unread single active" id="list-chat-list" data-toggle="list" role="tab">
                                        <img class="avatar-md" src="dist/img/avatars/avatar-female-1.jpg" data-toggle="tooltip" data-placement="top" title="Janette" alt="avatar">
                                        <div class="data">
                                            <h5>My Group</h5>
                                            <p>group message...</p>
                                        </div>
                                    </a>
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
        <!-- Start of Create Chat -->
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
        <!-- End of Create Chat -->

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

                        <div style="display: none;">
                            <div class="top">
                                <div class="container">
                                    <div class="col-md-12">
                                        <div class="inside">
                                            <a href="#"><img class="avatar-md" src="dist/img/avatars/avatar-female-5.jpg" data-toggle="tooltip" data-placement="top" title="Keith" alt="avatar"></a>
                                            <div class="status">
                                                <i class="material-icons online">fiber_manual_record</i>
                                            </div>
                                            <div class="data">
                                                <h5><a href="#">Keith Morris</a></h5>
                                                <span>Active now</span>
                                            </div>
                                            <button class="btn connect d-md-block d-none" name="1"><i class="material-icons md-30">phone_in_talk</i></button>
                                            <button class="btn connect d-md-block d-none" name="1"><i class="material-icons md-36">videocam</i></button>
                                            <button class="btn d-md-block d-none"><i class="material-icons md-30">info</i></button>
                                            <div class="dropdown">
                                                <button class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons md-30">more_vert</i></button>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <button class="dropdown-item connect" name="1"><i class="material-icons">phone_in_talk</i>Voice Call</button>
                                                    <button class="dropdown-item connect" name="1"><i class="material-icons">videocam</i>Video Call</button>
                                                    <hr>
                                                    <button class="dropdown-item"><i class="material-icons">clear</i>Clear History</button>
                                                    <button class="dropdown-item"><i class="material-icons">block</i>Block Contact</button>
                                                    <button class="dropdown-item"><i class="material-icons">delete</i>Delete Contact</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="content" id="content">
                                <div class="container">
                                    <div class="col-md-12">
                                        <div class="date">
                                            <hr>
                                            <span>Yesterday</span>
                                            <hr>
                                        </div>
                                        <div class="message">
                                            <img class="avatar-md" src="dist/img/avatars/avatar-female-5.jpg" data-toggle="tooltip" data-placement="top" title="Keith" alt="avatar">
                                            <div class="text-main">
                                                <div class="text-group">
                                                    <div class="text">
                                                        <p>We've got some killer ideas kicking about already.</p>
                                                    </div>
                                                </div>
                                                <span>09:46 AM</span>
                                            </div>
                                        </div>
                                        <div class="message me">
                                            <div class="text-main">
                                                <div class="text-group me">
                                                    <div class="text me">
                                                        <p>Can't wait! How are we coming along with the client?</p>
                                                    </div>
                                                </div>
                                                <span>11:32 AM</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="col-md-12">
                                    <div class="bottom">
                                        <form class="position-relative w-100">
                                            <textarea class="form-control" placeholder="Start typing for reply..." rows="1"></textarea>
                                            <button class="btn emoticons"><i class="material-icons">insert_emoticon</i></button>
                                            <button type="submit" class="btn send"><i class="material-icons">send</i></button>
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
                    <!-- Start of Call -->
                    <div class="call" id="call1">
                        <div class="content">
                            <div class="container">
                                <div class="col-md-12">
                                    <div class="inside">
                                        <div class="panel">
                                            <div class="participant">
                                                <img class="avatar-xxl" src="dist/img/avatars/avatar-female-5.jpg" alt="avatar">
                                                <span>Connecting</span>
                                            </div>
                                            <div class="options">
                                                <button class="btn option"><i class="material-icons md-30">mic</i></button>
                                                <button class="btn option"><i class="material-icons md-30">videocam</i></button>
                                                <button class="btn option call-end"><i class="material-icons md-30">call_end</i></button>
                                                <button class="btn option"><i class="material-icons md-30">person_add</i></button>
                                                <button class="btn option"><i class="material-icons md-30">volume_up</i></button>
                                            </div>
                                            <button class="btn back" name="1"><i class="material-icons md-24">chat</i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Call -->
                </div>
                <!-- End of Babble -->
                <!-- Start of Babble -->
                <div class="babble tab-pane fade" id="list-empty" role="tabpanel" aria-labelledby="list-empty-list">
                    <!-- Start of Chat -->
                    <div class="chat" id="chat2">
                        <div class="top">
                            <div class="container">
                                <div class="col-md-12">
                                    <div class="inside">
                                        <a href="#"><img class="avatar-md" src="dist/img/avatars/avatar-female-2.jpg" data-toggle="tooltip" data-placement="top" title="Lean" alt="avatar"></a>
                                        <div class="status">
                                            <i class="material-icons offline">fiber_manual_record</i>
                                        </div>
                                        <div class="data">
                                            <h5><a href="#">Lean Avent</a></h5>
                                            <span>Inactive</span>
                                        </div>
                                        <button class="btn connect d-md-block d-none" name="2"><i class="material-icons md-30">phone_in_talk</i></button>
                                        <button class="btn connect d-md-block d-none" name="2"><i class="material-icons md-36">videocam</i></button>
                                        <button class="btn d-md-block d-none"><i class="material-icons md-30">info</i></button>
                                        <div class="dropdown">
                                            <button class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons md-30">more_vert</i></button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <button class="dropdown-item connect" name="2"><i class="material-icons">phone_in_talk</i>Voice Call</button>
                                                <button class="dropdown-item connect" name="2"><i class="material-icons">videocam</i>Video Call</button>
                                                <hr>
                                                <button class="dropdown-item"><i class="material-icons">clear</i>Clear History</button>
                                                <button class="dropdown-item"><i class="material-icons">block</i>Block Contact</button>
                                                <button class="dropdown-item"><i class="material-icons">delete</i>Delete Contact</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content empty">
                            <div class="container">
                                <div class="col-md-12">
                                    <div class="no-messages">
                                        <i class="material-icons md-48">forum</i>
                                        <p>Seems people are shy to start the chat. Break the ice send the first message.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="col-md-12">
                                <div class="bottom">
                                    <form class="position-relative w-100">
                                        <textarea class="form-control" placeholder="Start typing for reply..." rows="1"></textarea>
                                        <button class="btn emoticons"><i class="material-icons">insert_emoticon</i></button>
                                        <button type="submit" class="btn send"><i class="material-icons">send</i></button>
                                    </form>
                                    <label>
                                        <input type="file">
                                        <span class="btn attach d-sm-block d-none"><i class="material-icons">attach_file</i></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Chat -->
                    <!-- Start of Call -->
                    <div class="call" id="call2">
                        <div class="content">
                            <div class="container">
                                <div class="col-md-12">
                                    <div class="inside">
                                        <div class="panel">
                                            <div class="participant">
                                                <img class="avatar-xxl" src="dist/img/avatars/avatar-female-2.jpg" alt="avatar">
                                                <span>Connecting</span>
                                            </div>
                                            <div class="options">
                                                <button class="btn option"><i class="material-icons md-30">mic</i></button>
                                                <button class="btn option"><i class="material-icons md-30">videocam</i></button>
                                                <button class="btn option call-end"><i class="material-icons md-30">call_end</i></button>
                                                <button class="btn option"><i class="material-icons md-30">person_add</i></button>
                                                <button class="btn option"><i class="material-icons md-30">volume_up</i></button>
                                            </div>
                                            <button class="btn back" name="2"><i class="material-icons md-24">chat</i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Call -->
                </div>
                <!-- End of Babble -->
                <!-- Start of Babble -->
                <div class="babble tab-pane fade" id="list-request" role="tabpanel" aria-labelledby="list-request-list">
                    <!-- Start of Chat -->
                    <div class="chat" id="chat3">
                        <div class="top">
                            <div class="container">
                                <div class="col-md-12">
                                    <div class="inside">
                                        <a href="#"><img class="avatar-md" src="dist/img/avatars/avatar-female-6.jpg" data-toggle="tooltip" data-placement="top" title="Louis" alt="avatar"></a>
                                        <div class="status">
                                            <i class="material-icons offline">fiber_manual_record</i>
                                        </div>
                                        <div class="data">
                                            <h5><a href="#">Louis Martinez</a></h5>
                                            <span>Inactive</span>
                                        </div>
                                        <button class="btn disabled d-md-block d-none" disabled><i class="material-icons md-30">phone_in_talk</i></button>
                                        <button class="btn disabled d-md-block d-none" disabled><i class="material-icons md-36">videocam</i></button>
                                        <button class="btn d-md-block disabled d-none" disabled><i class="material-icons md-30">info</i></button>
                                        <div class="dropdown">
                                            <button class="btn disabled" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled><i class="material-icons md-30">more_vert</i></button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <button class="dropdown-item"><i class="material-icons">phone_in_talk</i>Voice Call</button>
                                                <button class="dropdown-item"><i class="material-icons">videocam</i>Video Call</button>
                                                <hr>
                                                <button class="dropdown-item"><i class="material-icons">clear</i>Clear History</button>
                                                <button class="dropdown-item"><i class="material-icons">block</i>Block Contact</button>
                                                <button class="dropdown-item"><i class="material-icons">delete</i>Delete Contact</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content empty">
                            <div class="container">
                                <div class="col-md-12">
                                    <div class="no-messages request">
                                        <a href="#"><img class="avatar-xl" src="dist/img/avatars/avatar-female-6.jpg" data-toggle="tooltip" data-placement="top" title="Louis" alt="avatar"></a>
                                        <h5>Louis Martinez would like to add you as a contact. <span>Hi Keith, I'd like to add you as a contact.</span></h5>
                                        <div class="options">
                                            <button class="btn button"><i class="material-icons">check</i></button>
                                            <button class="btn button"><i class="material-icons">close</i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="col-md-12">
                                <div class="bottom">
                                    <form class="position-relative w-100">
                                        <textarea class="form-control" placeholder="Messaging unavailable" rows="1" disabled></textarea>
                                        <button class="btn emoticons disabled" disabled><i class="material-icons">insert_emoticon</i></button>
                                        <button class="btn send disabled" disabled><i class="material-icons">send</i></button>
                                    </form>
                                    <label>
                                        <input type="file" disabled>
                                        <span class="btn attach disabled d-sm-block d-none"><i class="material-icons">attach_file</i></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Chat -->
                </div>
                <!-- End of Babble -->
            </div>
        </div>
    </div> <!-- Layout -->
</main>
