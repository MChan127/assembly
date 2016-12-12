var psql = require('../node_server/db_connect').dbquery;
var Promise = require('promise');

exports.getUserFromUsername = function(username) {
	return new Promise(function(fulfill, reject) {
		psql('SELECT id, email FROM "user" WHERE username = $1::VARCHAR;', [username], function(err, result) {
			if (err) {
	            return reject(err);
	        }

	        if (!result) {
	        	return fulfill(null);
	        }
	        if (result.rows.length < 1) {
	            return fulfill(null);
	        }

	        return fulfill(result.rows[0]);
		});
	});
};