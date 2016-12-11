<?php
use yii\helpers\Html;
use frontend\assets\AngularAsset;

AngularAsset::register($this);

$this->title = 'Assembly - ' . Html::encode($model->name);
echo $this->render('nav', ['model' => $model]);
?>

<div class="row">
	<div class="col-md-8 board-tasks">
		<?php // use angular js to populate the list of tasks */ ?>
	</div>

	<div class="col-md-4 hidden-xs hidden-sm board-log">
		<?php // use angular js to populate the list of recent actions */ ?>
	</div>
</div>