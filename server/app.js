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
            console.log(`${username} joined ${group} for the first time`);

            socket.emit('message', formatMessage(bot, `Welcome to ${group}, ${username}`));
            // socket.broadcast.to(group).emit('userJoined', username);
        } else {
            console.log(`${username} already in ${group}`);
        }
    });

    socket.on('newGroupMessage', ({ groupName, message, username }) => {
        io.to(groupName).emit('message', formatMessage(username, message));
    });
});

function formatMessage(username, text) {
    return {
        username,
        text,
        time: moment().format('h:mm a')
    }
}


server.listen(PORT, () => {
    console.log('Server is running on port 3000');
});
