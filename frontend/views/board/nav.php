<?php
    use yii\helpers\Html;

    $user = Yii::$app->user;
?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand ng-cloak" href="#">{{boardName}}</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-left board-last-updated">
                <li><p class="navbar-text" style="text-indent: 15px;">Last Updated: <?= Html::encode(date('M j Y, G:iA', strtotime($board->updated_at))) ?></p></li>
            </ul>
            <?php if ($user->can('manageBoard', ['type' => 'board', 'item' => $board])): ?>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Actions <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a data-toggle="modal" href="#editBoardModal">Edit Board</a></li>
                            <li><a data-toggle="modal" href="#manageUsersModal">Manage Users</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Delete Board</a></li>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>
            <form class="navbar-form navbar-right">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>