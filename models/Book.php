<?php

namespace app\models;

use app\services\NotificationCenter;
use app\services\Redis;
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

    private const DELIMITER_AUTHORS = ', ';
    private const DELIMITER_AUTHORS_RAW = ',';

    public $author_ids;

    public function rules() {
        return [
            [['title', 'year', 'isbn', 'cover_link', 'author_ids'], 'required'],
            [['year'], 'integer'],
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

        $isTopAlreadyDeleted = false;
        if ($insert) {
            Redis::deleteAuthorTop($this->year);
            Redis::deleteAuthorTop(null);
            $isTopAlreadyDeleted = true;
        } elseif (array_key_exists('year', $changedAttributes)) {
            if ($changedAttributes['year'] !== (int)$this->year) {
                Redis::deleteAuthorTop($this->year);
                Redis::deleteAuthorTop(null);
                Redis::deleteAuthorTop($changedAttributes['year']);
                $isTopAlreadyDeleted = true;
            }
        }

        if ($this->_isAuthorsChanged()) {
            $this->_linkAuthors();
            if (! $isTopAlreadyDeleted) {
                Redis::deleteAuthorTop($this->year);
                Redis::deleteAuthorTop(null);
            }
        }
        NotificationCenter::addNotifications($this);
    }

    public function beforeDelete() {
        Redis::deleteAuthorTop($this->year);
        Redis::deleteAuthorTop(null);
        return parent::beforeDelete();
    }

    private function _isAuthorsChanged() {
        $rawNewAuthorIds = explode(self::DELIMITER_AUTHORS_RAW, $this->author_ids);
        $newAuthors = Author::findAll(['id' => $rawNewAuthorIds]);
        $newAuthorIds = array_map(
            function ($author) {
                return $author->id;
            },
            $newAuthors
        );
        return $this->authorIds !== implode(self::DELIMITER_AUTHORS, $newAuthorIds);
    }

    private function _linkAuthors() {
        $this->_unlinkAuthors();

        $authorIds = explode(self::DELIMITER_AUTHORS_RAW, $this->author_ids);
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

    public function getAuthorIds(): string {
        $authorIds = array_map(
            function ($author) {
                return $author->id;
            },
            $this->authors
        );
        return implode(self::DELIMITER_AUTHORS, $authorIds);
    }

    public function getAuthorFios(): string {
        $authorFios = array_map(
            function ($author) {
                return $author->fio;
            },
            $this->authors
        );
        return implode(self::DELIMITER_AUTHORS, $authorFios);
    }

    public function getAuthorLinks(): string {
        $authorLinks = array_map(
            function ($author) {
                return Html::a($author->fio, ['/author/view/' . $author->id], ['class' => 'btn']);
            },
            $this->authors
        );
        return implode(self::DELIMITER_AUTHORS, $authorLinks);
    }
}