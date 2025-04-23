<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kategooriad';
$url = Yii::$app->params['url'];
?>
<div class="categories-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Lisa kategooriaid', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($categories as $category): ?>
            <div class="col">
                <div class="card h-100">
                    <?= Html::img($url . 'files/categories/' . $category->id . "/" . $category->img_path . "." . $category->img_extension, ['alt' => $category->name]) ?>
                    <div class="card-body">
                        <div class="card-title">
                            <?= mb_strtoupper(Html::encode($category->name)) ?>
                        </div>
                        <?= Html::a('Muuda', ['update', 'id' => $category->id], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>
