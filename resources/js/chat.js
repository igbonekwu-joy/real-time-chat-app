import { socket } from './config';

//check for friend request event
document.addEventListener('livewire:initialized', () => {
    Livewire.on('friend-request-sent', ({ toUserId, fromUser }) => {
        socket.emit('friendRequest', {
            toUserId,
            fromUser,
        });
    });
});

socket.on('friendRequestNotification', ({ toUserId, fromUser }) => {
    const div = $(`.requests-div-${toUserId}`);
    div.show();

    const badge = $(`.requests-count-${toUserId}`);
    badge.text(parseInt(badge.text()) + 1);
});
