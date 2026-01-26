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
    /*Groups*/
    socket.on('joinRoom', ({ group }) => {
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

    socket.on('addMember', ({ groupName, groupId, username }) => {
        io.to(groupName).emit('message', formatMessage(bot, `${username} was added`, groupId));
    })

    socket.on('leaveGroup', ({ groupName, username, groupId }) => {
        io.to(groupName).emit('message', formatMessage(bot, `${username} left the group`, groupId));
    })
    /*End Groups*/

    /*Friend Requests*/
    socket.on('friendRequest', ({ toUserId, fromUser }) => {
        socket.broadcast.emit('friendRequestNotification', { toUserId, fromUser });
    });
    /*End Friend Requests*/

    /**Peer to Peer Chat */
    socket.on('messageSent', ({ roomName, message, fromUser }) => {
        io.to(roomName).emit('message', formatMessage(fromUser.name, message, fromUser.id));
    });

    socket.on('userTyping', ({ username, room }) => {
        io.to(room).emit('typing', { username });
    });

    socket.on('stopUserTyping', ({ username, room }) => {
        io.to(room).emit('stopTyping', { username });
    })
    /**End Peer to Peer Chat */
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
