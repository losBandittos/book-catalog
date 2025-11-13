<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sms}}`.
 */
class m251113_185911_create_sms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sms}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sms}}');
    }
}
