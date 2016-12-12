(function(templateUrls) {
	var boardApp = angular.module('boardApp', []);

	boardApp.controller('ManageUsersController', function($scope) {
		$scope.userData = userData;
		$scope.selectedUser = {
			id: null, 
			name: null, 
			email: null,
			joined_at: null
		};

		$scope.addNewUser = function(username) {
			socket.emit('addNewUser', username, this_board_id);
		};
		$scope.removeUser = function() {
			socket.emit('removeUserFromBoard', $scope.selectedUser.id, this_board_id);
		};
	});
	boardApp.directive('userManager', function($timeout) {
		return {
			restrict: 'E',
			/*scope: {
				userData: '=',
				selectedUser: '=',
				addNewUser: '&',
			},*/
			template: '<ng-include src="getTemplateUrl()" />',
			link: function(scope, element, attrs) {
				scope.getTemplateUrl = function() {
					return templateUrls['userManager'];
				};

				// instance variables
				scope.directiveStarted = false;

				angular.element(document).ready(function() {
					setTimeout(function() {
						start();
						var load = setInterval(function() {
							start();
							if (scope.directiveStarted) {
								clearInterval(load);
							}
						}, 1000);
					}, 1000);
				});

				var start = function() {
					// if jQuery is not available, return and try again later
					if ($ === undefined || scope.directiveStarted === true) {
						return;
					}

					scope.directiveStarted = true;

					$(element).on('click', '.manage-user-item', function() {
						$(this).siblings('.manage-user-item').removeClass('selected');
						$(this).addClass('selected');
						var user_id = $(this).data('id');
						scope.selectedUser.id = user_id;
						scope.selectedUser.name = scope.userData[user_id].username;
						scope.selectedUser.email = scope.userData[user_id].email;
						scope.selectedUser.joined_at = scope.userData[user_id].joined_at;
						$timeout();
					});

					$(element).find('#addNewUserBtn').click(function() {
						var $nameInput = $(element).find('[name="new-user-name"]');
						$nameInput.closest('.input-group').next('.input-error-msg').detach().remove();
						$nameInput.removeClass('error');
						if ($nameInput.val().trim().match(/^[A-Za-z0-9]+$/) === null) {
							$nameInput.addClass('error');
							$newErrorMsg = $('<span class="input-error-msg">The username is invalid.</span>');
							$newErrorMsg.hide();
							$nameInput.closest('.input-group').after($newErrorMsg);
							$newErrorMsg.fadeIn(100);
							return;
						}

						if (confirm('Are you sure you want to add a user to this board?'))
							scope.addNewUser($nameInput.val().trim());
					});

					$(element).on('click', '#removeUserBtn', function() {
						if (confirm('Are you sure you want to remove this user from the board?'))
							scope.removeUser();
					});
				};

				// finished adding a new user
				socket.on('doneAddNewUser', function(newUserData) {
					scope.userData[newUserData.id] = {
						id: newUserData.id,
						username: newUserData.username,
						email: newUserData.email,
						isAdmin: false,
						joined_at: newUserData.joined_at
					};
					$timeout();

					alert('The new user has been successfully added!');
				});
				// finished removing user from this board
				socket.on('doneRemoveUserFromBoard', function(removedUserId) {
					delete scope.userData[removedUserId];
					scope.selectedUser = {
						id: null, 
						name: null, 
						email: null,
						joined_at: null
					};
					$timeout();

					alert('The user has been successfully removed from the board.');
				});
				// someone else added a new user
				socket.on('newUserAdded', function() {
					// ...
				});
			}
		};
	});
})(angularTemplates);