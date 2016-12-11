<?php

use yii\db\Migration;

class m161211_075833_rbac_board extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        $authorRule = new \common\rules\AuthorRule;
        $memberRule = new \common\rules\MemberRule;
        $auth->add($authorRule);
        $auth->add($memberRule);

        // add regular user role
        $user_role = $auth->createRole('user');
        $user_role->description = "Regular user role.";
        $auth->add($user_role);

        // "manage board" permission
        $manageBoard = $auth->createPermission('manageBoard');
        $manageBoard->description = "Allows user to manage a board.";
        $manageBoard->ruleName = $authorRule->name;
        $auth->add($manageBoard);

        // "create card (post or task) within a board" permission
        $createCard = $auth->createPermission('createCard');
        $createCard->description = "Allows user to create a post or a task on a board.";
        $createCard->ruleName = $memberRule->name;
        $auth->add($createCard);

        // assign permissions
        $auth->addChild($user_role, $manageBoard);
        $auth->addChild($user_role, $createCard);
        $auth->addChild($auth->getRole('admin'), $user_role);
    }

    public function down()
    {
        $auth = Yii::$app->authManager;
        $auth->removeChildren($auth->getRole('admin'));
        $auth->remove($auth->getRole('user'));
        $auth->remove($auth->getPermission('manageBoard'));
        $auth->remove($auth->getPermission('createCard'));
        $auth->remove($auth->getRule('isAuthor'));
        $auth->remove($auth->getRule('isMember'));
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}