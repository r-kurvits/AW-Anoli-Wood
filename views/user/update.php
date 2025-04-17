<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\ActionList;

/* @var $this yii\web\View */
/* @var $model app\models\RolePermissionForm */
/* @var $form ActiveForm */
/* @var $roleIds array<int> */
/* @var $roles array */

$permissions = ActionList::getPermissions();
$labels = ActionList::getLabels();
?>
<div class="association-add-role">

    <h1><?= Yii::t('app', 'Update user roles') ?>:<br/> <?= $name ?></h1>
    <?php $form = ActiveForm::begin(); ?>
        <div class="f-wrap">
            <?php foreach($roles as $role): ?>
                <?= $form
                    ->field($model, "roles[$role->id]")
                    ->checkBox([
                        'checked' => in_array($role->id, $roleIds),
                        'value' => $role->id,
                        "label" => $role->name])
                ?>
            <?php endforeach; ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- association-add-role -->
