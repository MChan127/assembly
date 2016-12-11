<?php

/* @var $this yii\web\View */

use frontend\widgets\Board as BoardCard;
use yii\helpers\Url;

$this->title = 'Assembly - A simple project management webapp';

$user = Yii::$app->user;
?>
<div class="site-index">
<?php 
    // if logged in, display the boards that the user is involved in
    // otherwise, display the welcome message informing that the user should log in or create an account
    if ($user->isGuest): 
?>
    <div class="jumbotron">
        <h1>Welcome</h1>

        <p class="lead">To start using Assembly, please log in or create a new account.</p>

        <p>
        <a class="btn btn-lg btn-success" href="<?= Url::to(['site/login']); ?>">Login</a>
        <a class="btn btn-lg btn-primary" href="<?= Url::to(['site/signup']); ?>">Sign Up</a>
        </p>
    </div>
<?php else: ?>
    
    <p>
        <a class="btn btn-medium btn-primary" href="<?= Url::to(['board/create']); ?>">Create New Board</a>
    </p>
    
    <div class="row">
        <?php foreach ($boards as $board): ?>
            <p><?= BoardCard::widget(['item' => $board]) ?></p>
        <?php endforeach; ?>
    </div>

<?php endif; ?>
    </div>
</div>