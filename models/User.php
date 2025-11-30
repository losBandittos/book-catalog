<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * @property int $id
 * @property string $type
 * @property string $phone
 * @property string $password_hash
 *
 * @property Book[] $bookNotifications
 */
class User extends ActiveRecord implements IdentityInterface {
    const TYPE_GUEST = 'guest';
    const TYPE_USER = 'user';

    public static function findIdentity($id): ?self {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        return null;
    }

    public function getId() {
        return $this->getPrimaryKey();
    }

    public function getAuthKey() {
        //return $this->auth_key;
    }

    public function validateAuthKey($authKey) {
        //return $this->getAuthKey() === $authKey;
    }
    
    public function generateAuthKey() {
        //$this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function getUsername() {
        return $this->phone;
    }

    public static function getByPhone(string $phone): self {
        $existUser = static::findOne(['phone' => $phone]);
        if ($existUser === null) {
            $existUser = new static();
            $existUser->type = self::TYPE_GUEST;
            $existUser->phone = $phone;
            $existUser->password_hash = Yii::$app->security->generatePasswordHash($phone);
            $existUser->save();
        }

        return $existUser;
    }

    public function validatePassword($password): bool {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function upgradeToUser() {
        if ($this->isGuest()) {
            $this->type = self::TYPE_USER;
            $this->save();
        }
    }

    public function downgradeToGuest() {
        if ($this->isUser()) {
            $this->type = self::TYPE_GUEST;
            $this->save();
        }
    }

    public function isGuest(): bool {
        return $this->type === self::TYPE_GUEST;
    }

    public function isUser(): bool {
        return $this->type === self::TYPE_USER;
    }

    public function hasSubscribed(Author $author): bool {
        return Subscription::find()->where(['author_id' => $author->id, 'user_id' => $this->id])->count() > 0;
    }

    public function getBookNotifications() {
        return $this->hasMany(Book::class, ['id' => 'book_id'])
            ->viaTable('notification', ['user_id' => 'id']);
    }
}
