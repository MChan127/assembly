<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Board */

$this->title = 'Assembly - ' . Yii::t('app', 'Create New Board');
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Boards'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Create New Board');
?>
<div class="board-create">

    <h1><?= Html::encode(Yii::t('app', 'Create New Board')) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name') ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>

	<?php ActiveForm::end(); ?>

</div>
