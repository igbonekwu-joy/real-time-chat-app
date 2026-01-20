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
var form = $('#createGroupForm');
const group = $('.filterDiscussions');

var socket = io('http://localhost:3000'); //connect to server

group.on('click', function () {
    const group = $(this).data('room');
    const groupId = $(this).data('group-id');
    const groupImage = $(this).data('image');
    const username = user.name;

    socket.emit('joinRoom', { username, group });

    $('.no-message-container').css('display', 'none');
    $('.chat-container').css('display', 'block');
    $('.group-img').attr('src', groupImage);
    $('.group-name').text(group);
    $('#group-id').val(groupId);
});

socket.on('message', (message) => {
    if(message.username == 'System Bot') {

    }
    else{
        if(user.name == message.username) {
            var messageContainer = $('.all-messages');
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
