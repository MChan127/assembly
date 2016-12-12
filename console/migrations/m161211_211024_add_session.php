<?php

use yii\db\Migration;

class m161211_211024_add_session extends Migration
{
    public function up()
    {
        Yii::$app->db->createCommand('CREATE TABLE session (
            id CHAR(40) NOT NULL PRIMARY KEY,
            expire INTEGER,
            data BYTEA,
            socketid VARCHAR(255),
            user_id INTEGER
        );')->execute();
    }

    public function down()
    {
        $this->dropTable('{{%session}}');
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
