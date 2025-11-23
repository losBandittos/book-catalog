<?php
namespace app\rbac;

use Yii;
use yii\rbac\Rule;

class UserRoleRule extends Rule
{
    public $name = 'UserRole';

    public function execute($user, $item, $params)
    {
        if (! Yii::$app->user->isGuest) {
            $role = Yii::$app->user->identity->type;
            return  $item->name === $role;
        }
        return false;
    }
}