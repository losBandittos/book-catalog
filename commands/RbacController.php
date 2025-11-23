<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\rbac\UserRoleRule;
use app\models\Permissions;
use app\models\User;

class RbacController extends Controller {

    private $_authManager;
    private $_permissions;
    private $_userRoleRule;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->_authManager = Yii::$app->authManager;
        $this->_permissions = [];
    }

    public function actionInit()
    {
        $this->_setUserRoleRule();
        $this->_createPermissions();
        $this->_addPermissions();

        $this->_setGuestPermissions();
        $this->_setUserPermissions();
    }

    private function _setGuestPermissions() : void {
        $role = $this->_authManager->createRole(User::TYPE_GUEST);
        $role->ruleName  = $this->_userRoleRule->name;
        $this->_authManager->add($role);
        $this->_authManager->addChild($role, $this->_permissions[Permissions::AUTHOR_VIEW]);
        $this->_authManager->addChild($role, $this->_permissions[Permissions::AUTHOR_SUBSCRIBE]);
        $this->_authManager->addChild($role, $this->_permissions[Permissions::BOOK_VIEW]);
    }

    private function _setUserPermissions() : void {
        $role = $this->_authManager->createRole(User::TYPE_USER);
        $role->ruleName  = $this->_userRoleRule->name;
        $this->_authManager->add($role);
        $this->_authManager->addChild($role, $this->_permissions[Permissions::AUTHOR_VIEW]);
        $this->_authManager->addChild($role, $this->_permissions[Permissions::AUTHOR_ADD_EDIT_DELETE]);
        $this->_authManager->addChild($role, $this->_permissions[Permissions::AUTHOR_SUBSCRIBE]);
        $this->_authManager->addChild($role, $this->_permissions[Permissions::BOOK_VIEW]);
        $this->_authManager->addChild($role, $this->_permissions[Permissions::BOOK_ADD_EDIT_DELETE]);
    }

    private function _createPermissions() : void {
        foreach (Permissions::getAllPermissions() as $permission) {
            $this->_permissions[$permission] = $this->_authManager->createPermission($permission);
        }
    }

    private function _addPermissions() : void {
        foreach ($this->_permissions as $permission) {
            $this->_authManager->add($permission);
        }
    }

    private function _setUserRoleRule() : void {
        $this->_userRoleRule = new UserRoleRule();
        $this->_authManager->add($this->_userRoleRule);
    }
}