<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class LoginForm extends Model {
    const LOGIN_DURATION = 3600 * 24 * 30;

    public $phone;
    public $password;

    private $_user = false;

    public function rules() {
        return [
            [['phone', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect phone or password.');
            }
        }
    }

    public function login() {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), self::LOGIN_DURATION);
        }
        return false;
    }

    public function getUser() {
        if ($this->_user === false) {
            $this->_user = User::getByPhone($this->phone);
        }

        return $this->_user;
    }
}