<?php

namespace app\controllers;

use app\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class SiteController extends Controller {
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => [
                            'index',
                            'logout',
                            'upgrade-guest-to-user',
                            'downgrade-user-to-guest'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    public function actionIndex() {
        return $this->render('index', [
            'currentUser' => Yii::$app->user->identity
        ]);
    }

    public function actionUpgradeGuestToUser() {
        $currentUser = Yii::$app->user->identity;
        $currentUser->upgradeToUser();

        return $this->goHome();
    }

    public function actionDowngradeUserToGuest() {
        $currentUser = Yii::$app->user->identity;
        $currentUser->downgradeToGuest();

        return $this->goHome();
    }
}
