const btn = $('#createGroup');
var form = $('#createGroupForm');

//const socket = io();
var socket = io('http://localhost:3000');

// form.on('submit', (e) => {
//     e.preventDefault();
//     //join the group
//     socket.emit('joinRoom', { username, room });
// });
