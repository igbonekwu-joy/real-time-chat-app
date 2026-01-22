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
var deleteGroupBtn = $('#deleteGroup');
var leaveGroupBtn = $('#leaveGroup');
var addMemberBtn = $('#addMemberBtn');
let activeGroupId;

var socket = io('http://localhost:3000'); //connect to server

//get group details when a group is clicked
group.on('click', function () {
    const group = $(this).data('room');
    activeGroupId = $(this).data('group-id');
    const groupImage = $(this).data('image');
    const isAdmin = $(this).data('is-admin');
    const username = user.name;

    //check if user is admin
    if (isAdmin == 1) {
        addMemberBtn.show();
        deleteGroupBtn.show();
    } else {
        addMemberBtn.hide();
        deleteGroupBtn.hide();
    }

    socket.emit('joinRoom', { username, group });

    //get messages
    getMessages(activeGroupId);

    $('.no-message-container').hide();
    $('.chat-container').show();
    $('.group-img').attr('src', groupImage);
    $('.group-name').text(group);
    $('#group-id').val(activeGroupId);

    //mark messages as read
    $.post('/group/mark-as-read', { groupId: activeGroupId });

    $(`.unread-div-${activeGroupId}`).hide(); //remove the unread message counter
    $(`.filter-${activeGroupId}`).addClass('read');
    $(`.filter-${activeGroupId}`).removeClass('unread');
});

socket.on('message', (message) => {
    $('.no-messages').hide();
    var messageContainer = $('.all-messages');
    var groupId = message.groupId;

    //check if message belongs to the active group
    if(groupId != activeGroupId) {
        return;
    }

    if(message.username == 'System Bot') {
        var message = ` <div style="text-align: center;" class="bot-message m-3">
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
                <div class="text-main">
                    ${message.username}
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

socket.on('incrementMessage', ({ groupId }) => {
    incrementUnreadMessages(groupId);
})

//send group message
sendBtn.on('click', function (e) {
    e.preventDefault();
    var groupName = $('.group-name').text();
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
            group_id: activeGroupId,
            message: message,
            user_id: userId,
        },
        success: function (data) {
            socket.emit('newGroupMessage', { groupName, message, username, groupId: activeGroupId});
        },
        error: function (error) {
            console.log(error);
            alert(error.responseJSON.message);
        },
    });


});

//add group member form
addMemberForm.on('submit', function (e) {
    e.preventDefault();

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
            groupId: activeGroupId,
            username,
        },
        success: function (data) {
            $('.all-messages').empty();
            //refresh the messages
            getMessages(activeGroupId);

            // close modal
            $('#addMemberModal').modal('hide');

            //hide the load button
            loadBtn.hide();
        },
        error: function (error) {
            console.log(error.responseJSON.message);
            alert(error.responseJSON.message);

            //hide the load button
            loadBtn.hide();
        },
    });
});

//delete group
deleteGroupBtn.on('click', function (e) {
    e.preventDefault();

    $.ajax({
        url: '/group/delete-group',
        type: 'DELETE',
        data: {
            groupId: activeGroupId,
        },
        success: function (data) {
            window.location.href = '/groups';
        },
        error: function (error) {
            console.log(error.responseJSON.message);
        },
    });

})

//leave group
leaveGroupBtn.on('click', function (e) {
    e.preventDefault();

    var groupName = $('.group-name').text();
    var userId = user.id;
    var username = user.name;

    $.ajax({
        url: '/group/leave-group',
        type: 'POST',
        data: {
            groupId: activeGroupId,
            userId
        },
        success: function (data) {
           socket.emit('leaveGroup', { groupName, username, groupId: activeGroupId});
        },
        error: function (error) {
            console.log(error.responseJSON.message);
            alert(error.responseJSON.message);
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
    $('.loader-container').show();

    $.ajax({
        url: '/group/get-messages',
        type: 'GET',
        data: { group_id: groupId },
        success: function (data) {

            let lastRenderedDay = null;
            const messagesContainer = $('.all-messages');
            messagesContainer.empty();
            $('.loader').hide();

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
                        <div style="text-align: center;" class="bot-message m-3">
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
                        <div class="text-main">
                         ${msg.user.name}
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

            //if there are no messages in the group yet
            if(data.messages.length == 0) {
                messagesContainer.append(`<div class="no-messages">
                                            <i class="material-icons md-48">forum</i>
                                            <p>Seems people are shy to start the chat. Break the ice send the first message.</p>
                                        </div>`);
            }

            scrollToBottom();
        }
    });
}

function incrementUnreadMessages(groupId) {
    $(`.unread-div-${groupId}`).show();
    $(`.unread-count-${groupId}`).text(parseInt($(`.unread-count-${groupId}`).text()) + 1);

    $(`.filter-${groupId}`).addClass('unread');
    $(`.filter-${groupId}`).removeClass('read');
}

                        // <img class="avatar-md"
                        //     src="${msg.user_image ?? '/images/default-avatar.png'}"
                        //     title="${msg.user.name ?? 'User'}"
                        //     alt="avatar"></img>

