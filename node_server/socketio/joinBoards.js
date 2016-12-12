var psql = require('../db_connect').dbquery;
var helper = require('../helper');

var listen = function(io, socket, clientList, socketIdList) {
    var socket_id = socket.id;

    socket.on('joinBoards', function() {
        // get session for this user based on the socket id
        psql('SELECT * FROM "session" WHERE socketid = $1::VARCHAR;', [socket_id], function(err, result) {
            if (err) {
                return console.error('error running query', err);
            }

            // if no rows found, it means we can't find the logged in user
            if (!result) {
                return false;
            }
            if (result.rows.length < 1) {
                // should let client know
                // ...
                return false;
            }

            // get the user id from the byte array session information
            var PHPUnserialize = require('php-unserialize');
            var unserialized = new Buffer(result.rows[0]['data']).toString('ascii');
            var session_json = JSON.parse(JSON.stringify(PHPUnserialize.unserializeSession(unserialized)));
            var user_id = session_json['__id'];

            if (clientList[socket_id] == null) {
                clientList[socket_id] = {
                    user_id: user_id,
                    board_ids: []
                };
            }
            if (socketIdList[user_id] == null) {
                socketIdList[user_id] = [];
            }
            socketIdList[user_id].push(socket_id);

            // join all boards where this user is a member
            joinBoards(user_id);
        });
    });

    function joinBoards(user_id) {
        psql('SELECT * FROM "board_user" WHERE user_id = $1::INT;', [user_id], function(err, result) {
            if (err) {
                return console.error('error running query', err);
            }

            if (!result) {
                return [];
            }
            if (result.rows.length < 1) {
                return [];
            }

            // join each board, represented by a socketio room
            for (var i = 0; i < result.rows.length; i++) {
                /*if (boardList[board_id] === null) {
                    boardList[board_id] = {};
                }*/

                var board_id = result.rows[i]['board_id'];
                socket.join(board_id);
                clientList[socket_id]['board_ids'].push(board_id);
                //boardList[board_id][socket_id] = user_id;
            }
            //console.log(clientList);
            //console.log(socketIdList);
            //console.log(boardList);
        });
    }
};

module.exports = listen;