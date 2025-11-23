<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscription}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%author}}`
 * - `{{%user}}`
 */
class m251113_185902_create_subscription_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscription}}', [
            'author_id' => $this->integer(),
            'user_id' => $this->integer(),
            'PRIMARY KEY(author_id, user_id)',
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            '{{%idx-subscription-author_id}}',
            '{{%subscription}}',
            'author_id'
        );

        // add foreign key for table `{{%author}}`
        $this->addForeignKey(
            '{{%fk-subscription-author_id}}',
            '{{%subscription}}',
            'author_id',
            '{{%author}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-subscription-user_id}}',
            '{{%subscription}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-subscription-user_id}}',
            '{{%subscription}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%author}}`
        $this->dropForeignKey(
            '{{%fk-subscription-author_id}}',
            '{{%subscription}}'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            '{{%idx-subscription-author_id}}',
            '{{%subscription}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-subscription-user_id}}',
            '{{%subscription}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-subscription-user_id}}',
            '{{%subscription}}'
        );

        $this->dropTable('{{%subscription}}');
    }
}
