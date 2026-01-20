const express = require('express');
require('dotenv').config();
const http = require('http');
const { Server } = require('socket.io');

const app = express();
const server = http.createServer(app);
const PORT = process.env.PORT || 3000;
//const io = socketio(app);

app.use(express.json());
app.use(express.urlencoded({ extended: true }));

const io = new Server(server, {
    cors: {
        origin: '*', // tighten later
    },
});


app.listen(PORT, () => {
    console.log('Server is running on port 3000');
});
