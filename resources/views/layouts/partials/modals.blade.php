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
                                window.location.href = '/groups'
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

{{-- Add Member Modal --}}
<div class="modal fade" id="addMemberModal" tabindex="-1" role="dialog" aria-labelledby="addMemberLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="requests">
            <div class="title">
                <h1>Add Member to Group</h1>
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close"><i class="material-icons">close</i></button>
            </div>
            <div class="content">
                <form id="addMember">
                    <div class="form-group">
                        <label for="username">Username or Email:</label>
                        <input type="text" class="form-control" id="member_username" placeholder="username or email..." wire:model="name">

                        @error('name')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn button w-100">
                        Add Member
                        <span class="spinner-border spinner-border-sms submit-button" role="status" aria-hidden="true" style="display: none"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- End Add Member Modal --}}
