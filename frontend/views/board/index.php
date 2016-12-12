<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AngularAsset;

AngularAsset::register($this);

$this->title = 'Assembly Board';
?>

<div class="board-app" ng-app="boardApp" ng-controller="BoardController">
	<?= $this->render('nav', ['board' => $board]); ?>

	<div class="row">
		<div class="col-md-12">
			<a class="btn btn-primary" id="createNewTask" data-toggle="modal" href="#createTaskModal">Create New Task</a>
		</div>

		<div class="col-md-8 board-tasks">
			<?php // use angular js to populate the list of tasks */ ?>
		</div>

		<div class="col-md-4 hidden-xs hidden-sm board-log">
			<?php // use angular js to populate the list of recent actions */ ?>
		</div>
	</div>

	<?= $this->render('modals', ['board' => $board]); ?>
</div>

<script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
<script type="text/javascript">
// initialize the socket which we'll use to communicate with the server
var socket = io('http://localhost:3000');
socket.on('connect', function () {
	setTimeout(function() {
	    $.ajax({
	    	'type': 'POST',
	    	'url': "<?= Url::to(['board/savesocketid']) ?>",
	    	'data': {
	    		'id': socket.id
	    	}
	    }).done(function(data) {
	    	socket.emit('joinBoards');
	    });
	}, 1000);
});

this_board_id = <?= $board->id ?>;
this_board_name  = "<?= Html::encode($board->name) ?>";
userData = <?= json_encode($userData) ?>;
<?php 
	$templateUrl = Yii::$app->getUrlManager()->getBaseUrl() . '/js/angularjs/templates/';
?>
angularTemplates = {
	'userManager': "<?= $templateUrl . 'user-manager.html' ?>",
	'editBoard': "<?= $templateUrl . 'edit-board.html' ?>",
};
</script>