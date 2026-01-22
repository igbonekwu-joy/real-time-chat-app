const express = require('express');
require('dotenv').config();
const http = require('http');
const moment = require('moment/moment');
const { Server } = require('socket.io');

const app = express();
const server = http.createServer(app);
const PORT = process.env.PORT || 3000;
const bot = 'System Bot';
//const io = socketio(app);

app.use(express.json());
app.use(express.urlencoded({ extended: true }));

const io = new Server(server, {
    cors: {
        origin: '*',
    },
});

io.on('connection', (socket) => {
    socket.on('joinRoom', ({ username, group}) => {
        const alreadyInRoom = socket.rooms.has(group);

        if (!alreadyInRoom) {
            socket.join(group);
        }
    });

    socket.on('typing', ({ username, groupId }) => {
        socket.broadcast.emit('typing', { groupId, username });
    });

    socket.on('stopTyping', ({ username, groupId }) => {
        socket.broadcast.emit('stopTyping', { groupId, username });
    });

    socket.on('newGroupMessage', ({ groupName, message, username, groupId }) => {
        socket.broadcast.emit('incrementMessage', { groupId });
        io.to(groupName).emit('message', formatMessage(username, message, groupId));
    });

    socket.on('leaveGroup', ({ groupName, username, groupId }) => {
        io.to(groupName).emit('message', formatMessage(bot, `${username} left the group`, groupId));
    })
});

function formatMessage(username, text, groupId) {
    return {
        username,
        text,
        groupId,
        time: moment().format('h:mm a')
    }
}


server.listen(PORT, () => {
    console.log('Server is running on port 3000');
});
