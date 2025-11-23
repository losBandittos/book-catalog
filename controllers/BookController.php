<?php

namespace app\controllers;

use app\models\Book;
use app\models\Permissions;
use app\services\Explorer;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BookController extends Controller {
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['?', Permissions::BOOK_VIEW],
                    ],
                    [
                        'actions' => ['add', 'edit', 'delete'],
                        'allow' => true,
                        'roles' => [Permissions::BOOK_ADD_EDIT_DELETE],
                    ],
                ],
            ],
        ];
    }
    
    public function actionIndex() {
        return $this->render('index', [
            'dataProvider' => Explorer::getBooksProvider(),
            'canAddNew' => Yii::$app->user->can(Permissions::BOOK_ADD_EDIT_DELETE)
        ]);
    }

    public function actionView($id) {
        $book = $this->_findBook($id);

        return $this->render('view', [
            'book' => $book,
            'canViewAuthor' => Yii::$app->user->can(Permissions::AUTHOR_VIEW),
            'canEdit' => Yii::$app->user->can(Permissions::BOOK_ADD_EDIT_DELETE),
            'canDelete' => Yii::$app->user->can(Permissions::BOOK_ADD_EDIT_DELETE)
        ]);
    }

    public function actionAdd() {
        $book = new Book();
        if ($book->load(Yii::$app->request->post()) && $book->save()) {
            return $this->redirect(['book/view/' . $book->id]);
        }

        return $this->render('add', [
            'book' => $book,
            'authorsDataProvider' => Explorer::getAllAuthorsProvider(),
        ]);
    }

    public function actionEdit($id) {
        $book = $this->_findBook($id);
        if ($book->load(Yii::$app->request->post()) && $book->save()) {
            return $this->redirect(['book/view/' . $book->id]);
        }

        $book->author_ids = $book->authorIds;
        return $this->render('edit', [
            'book' => $book,
            'authorsDataProvider' => Explorer::getAllAuthorsProvider(),
            'canDelete' => Yii::$app->user->can(Permissions::BOOK_ADD_EDIT_DELETE)
        ]);
    }

    public function actionDelete($id) {
        $book = $this->_findBook($id);
        $isOk = $book->delete();
        if ($isOk) {
            return $this->redirect(['book/index']);
        } else {
            return $this->redirect(['book/edit/' . $book->id]);
        }
    }

    protected function _findBook($id) {
        if (($book = Book::findOne($id)) !== null) {
            return $book;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
