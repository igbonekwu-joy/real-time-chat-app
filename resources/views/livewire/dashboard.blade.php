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
                                    <input type="search" class="form-control" id="conversations" placeholder="Search for groups..." wire:model.live.debounce.300ms="group">
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
                                                <p>
                                                    {{ \Illuminate\Support\Str::limit($group->description ?? $group->messages->first()->message, 15, '...') }}
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

        @include('layouts.partials.group.chat-area')

        @include('layouts.partials.modals')

        <input type="hidden" id="user-details" value={{ auth()->user() }}>
        <input type="hidden" id="group-id" value="" wire:model="groupId">
    </div> <!-- Layout -->
</main>
