<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BoardUser */

$this->title = Yii::t('app', 'Create Board User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Board Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="board-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
