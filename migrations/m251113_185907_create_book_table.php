<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 */
class m251113_185907_create_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'year' => $this->integer(),
            'isbn' => $this->string(),
            'cover_link' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%book}}');
    }
}
