import { socket } from './config';

document.addEventListener('livewire:initialized', () => {
    Livewire.on('join-room', ({ group }) => {
        socket.emit('joinRoom', { group });
    });

    Livewire.on('send-message', ({ roomName, message, receiverId, fromUser }) => {
        socket.emit('messageSent', {
            roomName,
            message,
            receiverId,
            fromUser
        });
    });

    Livewire.on('typing', ({ username, senderId, room }) => {
        socket.emit('userTyping', ({ username, senderId, room }));
    });

    Livewire.on('stopTyping', ({ username, room }) => {
        socket.emit('stopUserTyping', ({ username, room }));
    });

    Livewire.on('scroll-to-bottom', () => {
        const container = $('.chat-messages');
        if (!container.length) return;

        requestAnimationFrame(() => {
            container.scrollTop(container[0].scrollHeight);
        });
    });
});

socket.on('message', (receiverId, message) => {
    console.log(message, receiverId)
    Livewire.dispatch('receiveMessage', { receiverId, message });
});

socket.on('incrementMessage', ({ receiverId, fromUser }) => {
    const unreadSpan = $(`.unread-count-${receiverId}-${fromUser.id}`);
    unreadSpan.text(parseInt(unreadSpan.text()) + 1);
    console.log('increment')

    const unreadDiv = $(`.unread-div-${receiverId}-${fromUser.id}`);
    unreadDiv.show();

    const filter = $(`.filter-${receiverId}-${fromUser.id}`);
    filter.addClass('unread');
    filter.removeClass('read');
});

socket.on('typing', ({ username, senderId }) => {
    Livewire.dispatch('typing', { username, senderId });
});

socket.on('stopTyping', ({ groupId, username }) => {
    Livewire.dispatch('endTyping', { username });
});
