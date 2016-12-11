<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="card board-card panel panel-default col-xs-12" data-href="<?= Url::to(['board/index', 'id' => Html::encode($item->id)]) ?>">
	<h1><?= $item->name ?></h1>

	<div class="timestamps panel-footer">
		<div>Created: <?= Html::encode($item->created_at) ?></div>
		<div>Updated: <?= Html::encode($item->updated_at) ?></div>
	</div>
</div>