<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m251113_185831_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'password_hash' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
