<?php

use yii\db\Migration;

class m161210_193608_board_tables extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // create board table
        $this->createTable('{{%board}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'admin_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
        ], $tableOptions);
        $this->addForeignKey('fk_admin_id', '{{%board}}', 'admin_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        // create board user table
        $this->createTable('{{%board_user}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'board_id' => $this->integer()->notNull()
        ], $tableOptions);
        $this->addForeignKey('fk_user_id', '{{%board_user}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_board_id', '{{%board_user}}', 'board_id', '{{%board}}', 'id', 'CASCADE', 'CASCADE');

        // create task table
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'author_id' => $this->integer()->notNull(),
            'board_id' => $this->integer()->notNull(),
            'position' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
        ], $tableOptions);
        $this->addForeignKey('fk_author_id', '{{%task}}', 'author_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_board_id', '{{%task}}', 'board_id', '{{%board}}', 'id', 'CASCADE', 'CASCADE');

        // create post table
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'detail' => $this->text()->notNull(),
            'author_id' => $this->integer()->notNull(),
            'board_id' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
        ], $tableOptions);
        $this->addForeignKey('fk_author_id', '{{%post}}', 'author_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_board_id', '{{%post}}', 'board_id', '{{%board}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_task_id', '{{%post}}', 'task_id', '{{%task}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk_admin_id', '{{%board}}');
        $this->dropForeignKey('fk_user_id', '{{%board_user}}');
        $this->dropForeignKey('fk_board_id', '{{%board_user}}');
        $this->dropForeignKey('fk_author_id', '{{%task}}');
        $this->dropForeignKey('fk_board_id', '{{%task}}');
        $this->dropForeignKey('fk_author_id', '{{%post}}');
        $this->dropForeignKey('fk_board_id', '{{%post}}');
        $this->dropForeignKey('fk_task_id', '{{%post}}');

        $this->dropTable('{{%board}}');
        $this->dropTable('{{%board_user}}');
        $this->dropTable('{{%task}}');
        $this->dropTable('{{%post}}');
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
