<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="card board-card panel panel-default col-xs-12" data-href="<?= Url::to(['board/index', 'id' => Html::encode($item->id)]) ?>">
	<h1><?= $item->name ?></h1>

	<div class="row timestamps">
		<div class="col-md-3">Created: <?= Html::encode($item->created_at) ?></div>
		<div class="col-md-3">Updated: <?= Html::encode($item->updated_at) ?></div>
	</div>
</div>