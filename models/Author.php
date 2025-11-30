<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $fio
 * 
 * @property Book[] $books
 * @property User[] $subscribers
 */
class Author extends ActiveRecord {
    public $book_count;

    public function rules() {
        return [
            ['fio', 'required'],
        ];
    }

    public function getSubscribers() {
        return $this->hasMany(User::class, ['id' => 'user_id'])
            ->viaTable('subscription', ['author_id' => 'id']);
    }

    public function getBooks() {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
            ->viaTable('author_book', ['author_id' => 'id']);
    }

    public function hasNoBooks(): bool {
        return ((int)AuthorBook::find()->where(['author_id' => $this->id])->count()) === 0;
    }
}