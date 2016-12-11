(function(userData, templateUrls) {
	var boardApp = angular.module('boardApp', []);

	boardApp.controller('ManageUsersController', function($scope) {
		$scope.userData = userData;
		$scope.selectedUser = {
			id: null, 
			name: null, 
			email: null,
			joined: null
		};

		$scope.resetSelectedUser = function() {
			console.log(1);
			$scope.selectedUser = {
				id: null, 
				name: null, 
				email: null,
				joined: null
			};
		};
	});
	boardApp.directive('userManager', function($timeout) {
		return {
			restrict: 'E',
			scope: {
				userData: '=',
				selectedUser: '=',
				resetSelectedUser: '&',
			},
			template: '<ng-include src="getTemplateUrl()" />',
			link: function(scope, element, attrs) {
				scope.getTemplateUrl = function() {
					return templateUrls['userManager'];
				};

				// instance variables
				scope.directiveStarted = false;

				angular.element(document).ready(function() {
					start();
					var load = setInterval(function() {
						start();
						if (scope.directiveStarted) {
							clearInterval(load);
						}
					}, 1000);
				});

				var start = function() {
					// if jQuery is not available, return and try again later
					if ($ === undefined || scope.directiveStarted === true) {
						return;
					}

					scope.directiveStarted = true;
					$(element).find('.manage-user-item').click(function() {
						$(this).siblings('.manage-user-item').removeClass('selected');
						$(this).addClass('selected');
						var user_id = $(this).data('id');
						scope.selectedUser.id = user_id;
						scope.selectedUser.name = scope.userData[user_id].username;
						scope.selectedUser.email = scope.userData[user_id].email;
						$timeout();
					});
				};
			}
		};
	});
})(userData, angularTemplates);