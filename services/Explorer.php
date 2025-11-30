<?php
namespace app\services;

use app\models\Author;
use app\models\AuthorBook;
use app\models\Book;
use yii\data\ActiveDataProvider;

class Explorer {
    private const DEFAULT_PAGE_SIZE = 10;
    private const TOP_SIZE = 10;

    static function getAllAuthorsProvider(): ActiveDataProvider {
        return new ActiveDataProvider([
            'query' => Author::find(),
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'fio' => SORT_ASC,
                ]
            ],
        ]);
    }

    static function getTopAuthorsProvider(?int $year): ActiveDataProvider {
        $authorTable = Author::tableName();
        $authorBookTable = AuthorBook::tableName();
        $bookTable = Book::tableName();
        $query = Author::find()
            ->select(["$authorTable.fio", "COUNT($bookTable.id) AS book_count"])
            ->join('LEFT JOIN', $authorBookTable, "$authorTable.id=$authorBookTable.author_id")
            ->join('LEFT JOIN', $bookTable, "$bookTable.id=$authorBookTable.book_id");
        if ($year > 0) {
            $query->where(["$bookTable.year" => $year]);
        }
        $query->groupBy("$authorTable.fio")
            ->orderBy(['book_count' => SORT_DESC])
            ->limit(self::TOP_SIZE);
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' =>false
        ]);
    }

    static function getAuthorsProvider(): ActiveDataProvider {
        return new ActiveDataProvider([
            'query' => Author::find(),
            'pagination' => [
                'pageSize' => self::DEFAULT_PAGE_SIZE,
            ],
            'sort' => [
                'defaultOrder' => [
                    'fio' => SORT_ASC,
                ]
            ],
        ]);
    }

    static function getBooksProvider(): ActiveDataProvider {
        return new ActiveDataProvider([
            'query' => Book::find(),
            'pagination' => [
                'pageSize' => self::DEFAULT_PAGE_SIZE,
            ],
            'sort' => [
                'defaultOrder' => [
                    'year' => SORT_DESC,
                    'title' => SORT_ASC,
                ]
            ],
        ]);
    }
}
