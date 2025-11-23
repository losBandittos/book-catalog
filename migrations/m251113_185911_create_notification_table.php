<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%notification}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%book}}`
 */
class m251113_185911_create_notification_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%notification}}', [
            'user_id' => $this->integer(),
            'book_id' => $this->integer(),
            'was_sent' => $this->boolean(),
            'PRIMARY KEY(user_id, book_id)',
        ]);

        // creates index for column `book_id`
        $this->createIndex(
            '{{%idx-notification-book_id}}',
            '{{%notification}}',
            'book_id'
        );

        // add foreign key for table `{{%book}}`
        $this->addForeignKey(
            '{{%fk-notification-book_id}}',
            '{{%notification}}',
            'book_id',
            '{{%book}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-notification-user_id}}',
            '{{%notification}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-notification-user_id}}',
            '{{%notification}}',
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
        // drops foreign key for table `{{%book}}`
        $this->dropForeignKey(
            '{{%fk-notification-book_id}}',
            '{{%notification}}'
        );

        // drops index for column `book_id`
        $this->dropIndex(
            '{{%idx-notification-book_id}}',
            '{{%notification}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-notification-user_id}}',
            '{{%notification}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-notification-user_id}}',
            '{{%notification}}'
        );

        $this->dropTable('{{%notification}}');
    }
}
