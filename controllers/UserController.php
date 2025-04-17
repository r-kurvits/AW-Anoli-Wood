<?php

namespace app\controllers;

use app\models\UserUpdateForm;
use caupohelvik\yii2rbac\models\Role;
use caupohelvik\yii2rbac\models\User;
use caupohelvik\yii2rbac\models\UserRole;
use caupohelvik\yii2rbac\models\Users;
use caupohelvik\yii2rbac\models\UserSearch;
use Yii;
use app\models\ActionList;
use yii\db\Exception;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class UserController extends Controller
{
    public function actionIndex() {
        if(!Yii::$app->user->identity->hasPermissionTo(ActionList::ACTION_ADMIN_USER)) {
            return $this->goHome();
        }

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->andWhere('users.active = 1');
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        if(!Yii::$app->user->identity->hasPermissionTo(ActionList::ACTION_ADMIN_USER)) {
            return $this->goHome();
        }

        

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @throws Exception
     */
    public function actionUpdate($id) {
        if(!Yii::$app->user->identity->hasPermissionTo(ActionList::ACTION_ADMIN_USER)) {
            return $this->goHome();
        }

        $model = new UserUpdateForm();
        $userRoles = UserRole::find()->where(['=', 'user_id', $id])->all();
        $user = Users::find()->where(['=', 'id', $id])->one();
        $roleIds = ArrayHelper::getColumn($userRoles, 'role_id');
        $roles = Role::find()->all();

        if ($model->load(Yii::$app->request->post())) {
            $model->process($id, $userRoles);

            return $this->redirect(['view',
                'id' => $id
            ]);
        }

        return $this->render('update', [
            'name' => $user->email,
            'model' => $model,
            'roleIds' => $roleIds,
            'roles' => $roles
        ]);
    }

    public function actionDelete($id) {
        if(!Yii::$app->user->identity->hasPermissionTo(ActionList::ACTION_ADMIN_USER)) {
            return $this->goHome();
        }

        $user = Users::find()->where(['=', 'id', $id])->one();
        $user->active = 0;
        $user->save();

        return $this->redirect(Yii::$app->request->referrer);
    }
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
