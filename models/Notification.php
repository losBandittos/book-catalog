<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $user_id
 * @property int $book_id
 * @property int $was_sent
 *
 * @property User $user
 * @property Book $book
 */
class Notification extends ActiveRecord {
    public function getUser() {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getBook() {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }
}
