<?php
use yii\helpers\Html;
use frontend\assets\AngularAsset;

AngularAsset::register($this);

$this->title = 'Assembly - ' . Html::encode($board->name);
?>

<div class="board-app" ng-app="boardApp">
	<?= $this->render('nav', ['board' => $board]); ?>

	<div class="row">
		<div class="col-md-8 board-tasks">
			<?php // use angular js to populate the list of tasks */ ?>
		</div>

		<div class="col-md-4 hidden-xs hidden-sm board-log">
			<?php // use angular js to populate the list of recent actions */ ?>
		</div>
	</div>

	<?= $this->render('modals', ['board' => $board]); ?>
</div>

<script type="text/javascript">
userData = <?php echo json_encode($userData) ?>;
<?php 
	$templateUrl = Yii::$app->getUrlManager()->getBaseUrl() . '/js/angularjs/templates/';
?>
angularTemplates = {
	'userManager': "<?= $templateUrl . 'user-manager.html' ?>",
	'editBoard': "<?= $templateUrl . 'edit-board.html' ?>",
};
</script>