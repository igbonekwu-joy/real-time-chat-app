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
});

socket.on('message', (message) => {
    Livewire.dispatch('receiveMessage', { message });
});
