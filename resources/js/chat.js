import { socket } from './config';

document.addEventListener('livewire:initialized', () => {
    Livewire.on('join-room', ({ group }) => {
        socket.emit('joinRoom', { group });
    });

    Livewire.on('send-message', ({ roomName, message, fromUser }) => {
        socket.emit('messageSent', {
            roomName,
            message,
            fromUser
        });
    });

    Livewire.on('typing', ({ username, room }) => {
        socket.emit('userTyping', ({ username, room }));
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

socket.on('message', (message) => {
    Livewire.dispatch('receiveMessage', { message });
});

socket.on('typing', ({ username }) => {
    Livewire.dispatch('typing', { username });
});

socket.on('stopTyping', ({ groupId, username }) => {
    Livewire.dispatch('endTyping', { username });
});
