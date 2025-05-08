<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $userPremiums app\models\UserPremiums[] */
/* @var $model caupohelvik\yii2rbac\models\User */
/* @var $modelForm app\models\UserPremiumForm */

$this->title = $model->email;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view py-5">

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
</div>
