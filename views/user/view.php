<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $userPremiums app\models\UserPremiums[] */
/* @var $model caupohelvik\yii2rbac\models\User */
/* @var $modelForm app\models\UserPremiumForm */

$this->title = $model->email;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'email:email',
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <h2>Preemiumid</h2>

    <hr>
    <h3>Lisa uus</h3>
    <?php $form = ActiveForm::begin([
            "action" => "/user/create-premium?userId=".$model->id,
            "method" => "POST"
    ]); ?>

    <?= $form->field($modelForm, 'expiresAt')->textInput([
            "type" => "date"
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <hr>
    <ol>
        <?php foreach ($userPremiums as $premium): ?>
            <li>
                Makse ID: <?= $premium->payment_intent_id ?> <br>Aegub: <?= $premium->expires_at ?><br><br>
            </li>
        <?php endforeach; ?>
    </ol>

</div>
