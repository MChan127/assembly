var app = require('express')();
var server = require('http').createServer(app);
var io = require('socket.io')(server);

var psql = require('../node_server/db_connect').dbquery;

var validator = require('validator');

// list of socket ids and the boards/rooms they are present in
var clientList = {};
// list of user ids and the socket ids associated with each
var socketIdList = {};
// list of boards and the user/socket ids belonging to each
//var boardList = {};

io.on('connection', function(socket) {
	//console.log(client.conn.id);
	var socket_id = socket.id;
    console.log(socket_id + ' has connected');

    socket.on('disconnect', function() {
        delete clientList[socket_id];
        
        for (var x in socketIdList) {
            var index = socketIdList[x].indexOf(socket_id);
            if (index > -1)
                socketIdList[x].splice(index, 1);
        }

        /*for (var x in boardList) {
            for (var y in boardList[x]) {
                if (y == socket_id)
                    delete boardList[x][y];
            }
        }*/

        //console.log(clientList);
        //console.log(socketIdList);
        //console.log(boardList);

        // ...
    });

    // events where user is added to the appropriate boards (rooms)
    require('../node_server/socketio/joinBoards')(io, socket, clientList, socketIdList);
    // events involving adding new users or removing users from a board
    require('../node_server/socketio/userManagement')(io, socket, clientList, socketIdList);

    socket.on('changeBoardName', function(new_name, board_id) {
        // check permissions
        // ...

        new_name = validator.escape(new_name);

        psql('UPDATE board SET name = $1::VARCHAR WHERE id = $2::INT;', [new_name, board_id], function(err, result) {
            if (err) {
                console.error('error running query', err);
            }

            // send success msg to admin
            socket.emit('doneChangeBoardName', new_name);

            // broadcast to entire room including admin
            io.in(board_id).emit('broadcastChangedBoardName', new_name);
        });
    });
});

server.listen(3000, function() {
	console.log('Express listening on port 3000');
});