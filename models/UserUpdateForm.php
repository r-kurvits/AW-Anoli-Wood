<?php

namespace app\models;

use caupohelvik\yii2rbac\models\UserRole;
use Yii;
use yii\base\Model;
use yii\db\Exception;

class UserUpdateForm extends Model
{
    public $roles;

    public function rules()
    {
        return [
            ['roles', 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * @throws Exception
     */
    public function process($userId, array $userRoles) {
        foreach ($userRoles as $userRole) {
            $userRole->delete();
        }

        foreach ($this->roles as $roleId) {
            $role = new UserRole();
            $role->user_id = $userId;
            $role->role_id = $roleId;
            $role->created_by = Yii::$app->user->identity->id;
            $role->created_at = date('Y-m-d H:i:s');
            $role->save();
        }
    }
}
