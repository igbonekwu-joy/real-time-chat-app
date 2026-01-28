{{-- Top Area --}}
<div class="top">
    <div class="container">
        <div class="col-md-12">
            <div class="inside">
                <a href="#">
                    {!! $image !!}
                </a>
                <div class="status">
                    <i class="material-icons online">fiber_manual_record</i>
                </div>
                <div class="data">
                    <h5><a href="#">{{ $selectedFriend->name }}</a></h5>
                    <span>Active now</span>
                </div>
                <button class="btn d-md-block d-none"><i class="material-icons md-30">info</i></button>

                <div class="dropdown">
                    <button class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons md-30">more_vert</i></button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" wire:click="clearHistory({{ $selectedFriend->id }})">
                            <i class="material-icons">clear</i>Clear History
                        </button>
                        <button
                            class="dropdown-item"
                            wire:click="blockContact({{ $selectedFriend->id }})"
                        >
                            <i class="material-icons">block</i>
                            @if($blockedStatus == 'self')
                                Unblock
                            @elseif($blockedStatus == 'friend')
                                Blocked
                            @else
                                Block Contact
                            @endif
                        </button>
                        <button
                            class="dropdown-item" wire:click="deleteContact({{ $selectedFriend->id }})"
                        >
                            <i class="material-icons">delete</i>Delete Contact
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Messages area --}}
<div class="content" id="content">
    <div class="container">
        <div class="col-md-12">
            <div
                class="chat-messages"
            >
                @php
                    $previousDate = null;
                @endphp

                @if(count($oldMessages) == 0 && count($messages) == 0)
                    <div class="no-messages">
                        <i class="material-icons md-48">forum</i>
                        <p>Seems your friend is shy to start the chat. Break the ice send the first message.</p>
                    </div>
                @endif

                @foreach($oldMessages as $msg)
                    @php
                        $messageDate = \Carbon\Carbon::parse(
                            $msg['created_at'] ?? now()
                        )->startOfDay();
                    @endphp

                    @if(!$previousDate || !$messageDate->equalTo($previousDate))
                        <div class="date">
                            <hr>
                            <span>
                                @if($messageDate->isToday())
                                    Today
                                @elseif($messageDate->isYesterday())
                                    Yesterday
                                @else
                                    {{ $messageDate->format('F j, Y') }}
                                @endif
                            </span>
                            <hr>
                        </div>

                        @php
                            $previousDate = $messageDate;
                        @endphp
                    @endif

                    @if($msg->attachment)
                        <div class="message {{ $msg['sender_id'] === auth()->user()->id ? 'me' : '' }}">
                            <div class="text-main">
                                <div class="text-group {{ $msg['sender_id'] === auth()->user()->id ? 'me' : ''}}">
                                    @if($msg->attachment_type == 'png' || $msg->attachment_type == 'jpg' || $msg->attachment_type == 'jpeg' || $msg->attachment_type == 'svg')
                                        <img src="{{ asset('storage/' . $msg->attachment) }}" class="preview-image">
                                    @else
                                        <div class="text">
                                            <div class="attachment">
                                                <button class="btn attach"><i class="material-icons md-18">insert_drive_file</i></button>
                                                <div class="file">
                                                    <h5><a href="{{ asset('storage/' . $msg->attachment) }}">{{ $msg->attachment_name }}</a></h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="message {{ $msg['sender_id'] === auth()->user()->id ? 'me' : '' }}">
                        <div class="text-main">
                            <div class="text-group {{ $msg['sender_id'] === auth()->user()->id ? 'me' : ''}}">
                                <div class="text {{ $msg['sender_id'] === auth()->user()->id ? 'me' : ''}}">
                                    <p>{{ $msg['message'] }}</p>
                                </div>
                            </div>
                            <span>
                                {{ \Carbon\Carbon::parse($msg['created_at'])->setTimezone('Africa/Lagos')->format('g:i a') }}
                            </span>
                        </div>
                    </div>
                @endforeach

                @foreach($messages as $message)
                    @php
                        $messageDate = \Carbon\Carbon::parse(
                            $message['created_at'] ?? now()
                        )->startOfDay();
                    @endphp

                    @if(!$previousDate || !$messageDate->equalTo($previousDate))
                        <div class="date">
                            <hr>
                            <span>
                                @if($messageDate->isToday())
                                    Today
                                @elseif($messageDate->isYesterday())
                                    Yesterday
                                @else
                                    {{ $messageDate->format('F j, Y') }}
                                @endif
                            </span>
                            <hr>
                        </div>

                        @php
                            $previousDate = $messageDate;
                        @endphp
                    @endif

                    @if($message['attachment'])
                        <div class="message {{ $message['sender_id'] === auth()->user()->id ? 'me' : '' }}">
                            <div class="text-main">
                                <div class="text-group {{ $message['sender_id'] === auth()->user()->id ? 'me' : ''}}">
                                    @if($message['attachment_type'] == 'png' || $message['attachment_type'] == 'jpg' || $message['attachment_type'] == 'jpeg' || $message['attachment_type'] == 'svg')
                                        <img src="{{ asset('storage/' . $message['attachment']) }}" class="preview-image">
                                    @else
                                        <div class="text">
                                            <div class="attachment">
                                                <button class="btn attach"><i class="material-icons md-18">insert_drive_file</i></button>
                                                <div class="file">
                                                    <h5><a href="{{ asset('storage/' . $message['attachment']) }}">{{ $message['attachment_name'] }}</a></h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="message {{ $message['sender_id'] === auth()->user()->id ? 'me' : '' }}">
                        <div class="text-main">
                            <div class="text-group {{ $message['sender_id'] === auth()->user()->id ? 'me' : ''}}">
                                <div class="text {{ $message['sender_id'] === auth()->user()->id ? 'me' : ''}}">
                                    <p>{{ $message['text'] }}</p>
                                </div>
                            </div>
                            <span>{{ $message['time'] }}</span>
                        </div>
                    </div>
                @endforeach

                @if($blockedStatus == 'self')
                    <div style="text-align: center;" class="bot-message m-3">
                        <p style="
                            display: inline-block;
                            background: #9abdda;
                            color: #fff;
                            padding: 3px 8px;
                            border-radius: 3px;
                        ">
                            You blocked this contact
                        </p>
                    </div>
                @endif

                @if($isTyping)
                    <div class="message">
                        <div class="text-main">
                            <div class="text-group">
                                <div class="text typing">
                                    <div class="wave">
                                        <span class="dot"></span>
                                        <span class="dot"></span>
                                        <span class="dot"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Preview uploaded image immediately if there is any --}}
                @if ($attachment)
                    <div class="attachment-preview">
                        @if (str_starts_with($attachment->getMimeType(), 'image/'))
                            <img src="{{ $attachment->temporaryUrl() }}" class="preview-image">
                        @else
                            <p>{{ $attachment->getClientOriginalName() }}</p>
                        @endif
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
