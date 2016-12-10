<?php

use yii\db\Migration;

class m161210_210857_rbac_init extends Migration
{
    public function up()
    {
        $auth = Yii::$app->authManager;

        // add admin role
        $admin_role = $auth->createRole("admin");
        $admin_role->description = "Administrator role. Can perform all actions.";
        $auth->add($admin_role);
    }

    public function down()
    {
        Yii::$app->authManager->removeAll();

        /*echo "m161210_210857_rbac_init cannot be reverted.\n";

        return false;*/
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
