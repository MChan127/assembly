var psql = require('../db_connect').dbquery;
var helper = require('../helper');

var listen = function(io, socket, clientList, socketIdList) {
    var socket_id = socket.id;

    socket.on('addNewUser', function(username, board_id) {
        // check if the current user has the proper permissions to add user for this board
        var user_id = clientList[socket_id]['user_id'];
        // ...

        // get user from username
        helper.getUserFromUsername(username).then(function(added_user) {
            var added_user_id = added_user.id;

            // add user to the board
            psql('INSERT INTO "board_user" (board_id, user_id) VALUES ($1::INT, $2::INT) RETURNING joined_at;', [board_id, added_user_id], function(err, result) {
                if (err) {
                    return console.error('error running query', err);
                }
                var joined_at = '';
                if (result) {
                    if (result.rows.length > 0) {
                        joined_at = result.rows[0].joined_at;
                    }
                }
                // notify the admin who added this user
                socket.emit('doneAddNewUser', {
                    id: added_user_id,
                    username: username,
                    email: added_user.email,
                    joined_at: joined_at
                });

                // notify the added user that he has been added to this board
                // get the added user's socket ids, if they exist
                var added_usr_socket_ids = [];
                if (socketIdList[added_user_id] != null) {
                    for (var i = 0; i < socketIdList[added_user_id].length; i++) {
                        var added_usr_socket_id = socketIdList[added_user_id][i];
                        // include board info
                        // ...
                        //io.socket(added_usr_socket_id).emit('notifyAddedToBoard', board_id);
                        // should also create a notification, both in the database and emitting another message so that
                        // the user's interface is updated
                        // ...

                        added_usr_socket_ids.push(added_usr_socket_id);
                    }
                }

                // notify all the users of this board
                // should create a type of events log, and transmit the event object to the front
                // ...
                io.in(board_id).emit('broadcastAddedToBoard', {
                    id: added_user_id,
                    username: username,
                    email: added_user.email,
                    joined_at: joined_at
                }, board_id);

                // update list objects
                if (added_usr_socket_ids.length > 0) {
                    for (var i = 0; i < added_usr_socket_ids.length; i++) {
                        clientList[added_usr_socket_ids[i]]['board_ids'].push(board_id);

                        // connect the socket id to the room
                        //io.socket(added_usr_socket_ids[i]).join(board_id);
                    }
                }
            });
        }, function(err) {
            console.error('error running query', err);
        });
    });
    socket.on('removeUserFromBoard', function(removed_user_id, board_id) {
        // check if the current user has the proper permissions to remove user from this board
        var user_id = clientList[socket_id]['user_id'];
        // ...

        psql('DELETE FROM "board_user" WHERE board_id = $1::INT AND user_id = $2::INT;', [board_id, removed_user_id], function(err, result) {
            if (err) {
                return console.error('error running query', err);
            }

            // notify the admin who removed this user
            socket.emit('doneRemoveUserFromBoard', removed_user_id);

            // notify the added user that he has been removed from this board
            // get the added user's socket ids, if they exist
            var removed_usr_socket_ids = [];
            if (socketIdList[removed_user_id] != null) {
                for (var i = 0; i < socketIdList[removed_user_id].length; i++) {
                    var removed_usr_socket_id = socketIdList[removed_user_id][i];
                    //io.socket(removed_usr_socket_id).emit('notifyRemovedFromBoard', board_id);
                    // should also create a notification, both in the database and emitting another message so that
                    // the user's interface is updated
                    // ...

                    removed_usr_socket_ids.push(removed_usr_socket_id);
                }
            }

            // update list objects
            if (removed_usr_socket_ids.length > 0) {
                for (var i = 0; i < removed_usr_socket_ids.length; i++) {
                    clientList[removed_usr_socket_ids[i]]['board_ids'].push(board_id);

                    // remove the user from the room first, so that they do not receive the broadcast below
                    //io.socket(removed_usr_socket_ids[i]).leave(board_id);
                }
            }

            // notify all the users of this board
            // should create a type of events log, and transmit the event object to the front
            // ...
            io.in(board_id).emit('broadcastRemovedFromBoard', removed_user_id, board_id);
        });
    });
};

module.exports = listen;