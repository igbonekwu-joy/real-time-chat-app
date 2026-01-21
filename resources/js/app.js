$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content')
    }
}); //set csrf token

const rawUser = $('#user-details');
const user = JSON.parse(rawUser.val());
const sendBtn = $('.send-message');
const group = $('.filterDiscussions');
const addMemberForm = $('#addMember');

var socket = io('http://localhost:3000'); //connect to server

//get group details when a group is clicked
group.on('click', function () {
    const group = $(this).data('room');
    const groupId = $(this).data('group-id');
    const groupImage = $(this).data('image');
    const isAdmin = $(this).data('is-admin');
    const username = user.name;
    var addMemberBtn = $('#addMemberBtn');

    //check if user is admin
    if (isAdmin == 1) {
        addMemberBtn.show();
    } else {
        addMemberBtn.hide();
    }

    socket.emit('joinRoom', { username, group });

    $('.no-message-container').hide();
    $('.chat-container').show();
    $('.group-img').attr('src', groupImage);
    $('.group-name').text(group);
    $('#group-id').val(groupId);

    //get messages
    getMessages(groupId);
});

socket.on('message', (message) => {
    console.log(message)
    var messageContainer = $('.all-messages');
    if(message.username == 'System Bot') {
        var message = ` <div style="text-align: center;">
                            <p style="
                                display: inline-block;
                                background: #9abdda;
                                color: #fff;
                                padding: 3px 8px;
                                border-radius: 3px;
                            ">
                                ${message.text}
                            </p>
                        </div>`;
        messageContainer.append(message);
    }
    else{
        if(user.name == message.username) {
            var message = `<div class="message me">
                <div class="text-main">
                    <div class="text-group me">
                        <div class="text me">
                            <p>${message.text}</p>
                        </div>
                    </div>
                    <span>${message.time}</span>
                </div>
            </div>`;
            messageContainer.append(message);
        }
        else{
            var messageContainer = $('.all-messages');
            var message = `<div class="message">
                <img class="avatar-md" src="" data-toggle="tooltip" data-placement="top" title="Keith" alt="avatar">
                <div class="text-main">
                    <div class="text-group">
                        <div class="text">
                            <p>${message.text}</p>
                        </div>
                    </div>
                    <span>02:56 PM</span>
                </div>
            </div>`;
            messageContainer.append(message);
        }

    }

    scrollToBottom();
});

//send group message
sendBtn.on('click', function (e) {
    e.preventDefault();
    var groupName = $('.group-name').text();
    var groupId = $('#group-id').val();
    var message = $('.message-content').val();
    var userId = user.id;
    var username = user.name;

    if(message == '') {
        return;
    }

    $('.message-content').val('')

    //save message to database
    $.ajax({
        url: '/group/send-message',
        type: 'POST',
        data: {
            group_id: groupId,
            message: message,
            user_id: userId,
        },
        success: function (data) {
            socket.emit('newGroupMessage', { groupName, message: message, username });
        },
        error: function (error) {
            console.log(error);
        },
    });


});

//add group member form
addMemberForm.on('submit', function (e) {
    e.preventDefault();

    var groupId = $('#group-id').val();
    var username = $('#member_username').val();
    var loadBtn = $('.submit-button');

    if(username == '') {
        return;
    }

    loadBtn.show();

    $.ajax({
        url: '/group/add-member',
        type: 'POST',
        data: {
            groupId,
            username,
        },
        success: function (data) {
            //refresh the messages
            getMessages(groupId);

            //hide the load button
            loadBtn.hide();
        },
        error: function (error) {
            console.log(error.responseJSON.message);
        },
    });
})

function formatTime(dateString) {
    const date = new Date(dateString);
    return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
}

function isSameDay(d1, d2) {
    return d1.getFullYear() === d2.getFullYear() &&
           d1.getMonth() === d2.getMonth() &&
           d1.getDate() === d2.getDate();
}

function getDayLabel(dateString) {
    const messageDate = new Date(dateString);
    const today = new Date();

    const yesterday = new Date();
    yesterday.setDate(today.getDate() - 1);

    if (isSameDay(messageDate, today)) {
        return 'Today';
    }

    if (isSameDay(messageDate, yesterday)) {
        return 'Yesterday';
    }

    return messageDate.toLocaleDateString(undefined, {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

function scrollToBottom() {
    const container = $('.content');
    container.scrollTop(container.prop('scrollHeight'));
}

function getMessages (groupId) {
    $.ajax({
        url: '/group/get-messages',
        type: 'GET',
        data: { group_id: groupId },
        success: function (data) {
            let lastRenderedDay = null;
            const messagesContainer = $('.all-messages');
            messagesContainer.html('');

            data.messages.forEach((msg) => {
                const messageDate = new Date(msg.created_at);
                const currentDay = messageDate.toDateString();

                if (lastRenderedDay !== currentDay) {
                    lastRenderedDay = currentDay;

                    $('.all-messages').append(`
                        <div class="date">
                            <hr>
                            <span>${getDayLabel(msg.created_at)}</span>
                            <hr>
                        </div>
                    `);
                }

                if (msg.bot === 1) {
                    messagesContainer.append(`
                        <div style="text-align: center;" class="bot-message">
                            <p style="
                                display: inline-block;
                                background: #9abdda;
                                color: #fff;
                                padding: 3px 8px;
                                border-radius: 3px;
                            ">
                                ${msg.message}
                            </p>
                        </div>
                    `);
                    return;
                }

                //my messages
                if (msg.user_id === user.id) {
                    messagesContainer.append(`
                        <div class="message me">
                            <div class="text-main">
                                <div class="text-group me">
                                    <div class="text me">
                                        <p>${msg.message}</p>
                                    </div>
                                </div>
                                <span>${formatTime(msg.created_at)}</span>
                            </div>
                        </div>
                    `);
                    return;
                }

                //members' messages
                messagesContainer.append(`
                    <div class="message">
                        <img class="avatar-md"
                            src="${msg.user_image ?? '/images/default-avatar.png'}"
                            title="${msg.user_name ?? 'User'}"
                            alt="avatar">

                        <div class="text-main">
                            <div class="text-group">
                                <div class="text">
                                    <p>${msg.message}</p>
                                </div>
                            </div>
                            <span>${formatTime(msg.created_at)}</span>
                        </div>
                    </div>
                `);
            });

            scrollToBottom();
        }
    });
}

