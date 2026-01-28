import { socket } from './config';

document.addEventListener('livewire:initialized', () => {
    Livewire.on('join-room', ({ group }) => {
        socket.emit('joinRoom', { group });
    });

    Livewire.on('send-message', ({ roomName, message, attachment, attachmentName, attachmentType, receiverId, fromUser }) => {
        socket.emit('messageSent', {
            roomName,
            message,
            attachment,
            attachmentName,
            attachmentType,
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

socket.on('message', (attachment, attachmentName, attachmentType, receiverId, message) => {
    Livewire.dispatch('receiveMessage', { receiverId, message, attachment, attachmentName, attachmentType });
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


//add emoji to message
$(document).on('click', '.emoji', function () {
    const emoji = $(this).data('emoji');
    const textarea = $('#messageBox')[0];

    textarea.focus();

    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const text = textarea.value;

    textarea.value =
        text.substring(0, start) +
        emoji +
        text.substring(end);

    const cursorPos = start + emoji.length;
    textarea.selectionStart = cursorPos;
    textarea.selectionEnd = cursorPos;

    // Notify Livewire
    textarea.dispatchEvent(new Event('input'));
});
