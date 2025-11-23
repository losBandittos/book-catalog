<?php

namespace app\controllers;

use app\models\Author;
use app\models\Permissions;
use app\models\TopForm;
use app\services\Explorer;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AuthorController extends Controller {
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'top', 'view'],
                        'allow' => true,
                        'roles' => ['?', Permissions::AUTHOR_VIEW],
                    ],
                    [
                        'actions' => ['subscribe'],
                        'allow' => true,
                        'roles' => [Permissions::AUTHOR_SUBSCRIBE],
                    ],
                    [
                        'actions' => ['add', 'edit', 'delete'],
                        'allow' => true,
                        'roles' => [Permissions::AUTHOR_ADD_EDIT_DELETE],
                    ],
                ],
            ],
        ];
    }
    
    public function actionIndex() {
        return $this->render('index', [
            'dataProvider' => Explorer::getAuthorsProvider(),
            'canAddNew' => Yii::$app->user->can(Permissions::AUTHOR_ADD_EDIT_DELETE)
        ]);
    }

    public function actionTop() {
        $topForm = new TopForm();
        $topForm->load(Yii::$app->request->post());

        return $this->render('top', [
            'topForm' => $topForm,
            'dataProvider' => Explorer::getTopAuthorsProvider($topForm->year)
        ]);
    }

    public function actionView($id) {
        $author = $this->_findAuthor($id);

        return $this->render('view', [
            'author' => $author,
            'canEdit' => Yii::$app->user->can(Permissions::AUTHOR_ADD_EDIT_DELETE),
            'canDelete' =>
                Yii::$app->user->can(Permissions::AUTHOR_ADD_EDIT_DELETE)
                && $author->hasNoBooks(),
            'canSubscribe' =>
                Yii::$app->user->can(Permissions::AUTHOR_SUBSCRIBE)
                && (! Yii::$app->user->identity->hasSubscribed($author))
        ]);
    }

    public function actionSubscribe($id) {
        $author = $this->_findAuthor($id);
        $currentUser = Yii::$app->user->identity;
        if (! $currentUser->hasSubscribed($author)) {
            $author->link('subscribers', $currentUser);
        }
        return $this->redirect(['author/view/' . $author->id]);
    }

    public function actionAdd() {
        $author = new Author();
        if ($author->load(Yii::$app->request->post()) && $author->save()) {
            return $this->redirect(['author/view/' . $author->id]);
        }

        return $this->render('add', [
            'author' => $author,
        ]);
    }

    public function actionEdit($id) {
        $author = $this->_findAuthor($id);
        if ($author->load(Yii::$app->request->post()) && $author->save()) {
            return $this->redirect(['author/view/' . $author->id]);
        }

        return $this->render('edit', [
            'author' => $author,
            'canDelete' =>
                Yii::$app->user->can(Permissions::AUTHOR_ADD_EDIT_DELETE)
                && $author->hasNoBooks()
        ]);
    }

    public function actionDelete($id) {
        $author = $this->_findAuthor($id);
        if ($author->hasNoBooks()) {
            $isOk = $author->delete();
        } else {
            $isOk = false;
        }
        if ($isOk) {
            return $this->redirect(['author/index']);
        } else {
            return $this->redirect(['author/edit/' . $author->id]);
        }
    }

    protected function _findAuthor($id) {
        if (($author = Author::findOne($id)) !== null) {
            return $author;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
