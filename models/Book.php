<?php

namespace app\models;

use app\services\NotificationCenter;
use yii\db\ActiveRecord;
use yii\helpers\Html;

/**
 * @property int $id
 * @property string $title
 * @property int $year
 * @property string $isbn
 * @property string $cover_link
 * 
 * @property Author[] $authors
 * @property int[] $authorIds
 * @property string[] $authorFios
 * @property string[] $authorLinks
 */
class Book extends ActiveRecord {
    const APOSTOL_YEAR = 1564;

    public $author_ids;

    public function rules() {
        return [
            [['title', 'year', 'isbn', 'cover_link', 'author_ids'], 'required'],
            ['year', 'validateYear'],
            ['author_ids', 'validateAuthors'],
        ];
    }

    public function validateYear($attribute, $params) {
        if (!$this->hasErrors()) {
            if ($this->year < self::APOSTOL_YEAR || $this->year > date('Y')) {
                $this->addError($attribute, 'Incorrect year.');
            }
        }
    }

    public function validateAuthors($attribute, $params) {
        if (!$this->hasErrors()) {
            $ids = explode(',', $this->author_ids);
            if (count($ids) !== (int)Author::find()->where(['id' => $ids])->count()) {
                $this->addError($attribute, 'Incorrect authors.');
            }
        }
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);

        $this->_linkAuthors();
        NotificationCenter::addNotifications($this);
    }

    private function _linkAuthors() {
        $this->_unlinkAuthors();

        $authorIds = explode(',', $this->author_ids);
        $authors = Author::findAll(['id' => $authorIds]);
        foreach($authors as $author) {
            $this->link('authors', $author);
        }
    }

    private function _unlinkAuthors() {
        foreach($this->authors as $author) {
            $this->unlink('authors', $author, true);
        }
    }

    public function getAuthors() {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('author_book', ['book_id' => 'id']);
    }

    public function getAuthorIds() {
        $authorIds = array_map(
            function ($author) {
                return $author->id;
            },
            $this->authors
        );
        return implode(', ', $authorIds);
    }

    public function getAuthorFios() {
        $authorFios = array_map(
            function ($author) {
                return $author->fio;
            },
            $this->authors
        );
        return implode(', ', $authorFios);
    }

    public function getAuthorLinks() {
        $authorLinks = array_map(
            function ($author) {
                return Html::a($author->fio, ['/author/view/' . $author->id], ['class' => 'btn']);
            },
            $this->authors
        );
        return implode(', ', $authorLinks);
    }
}