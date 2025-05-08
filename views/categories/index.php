<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kategooriad - Anoli Wood';
?>
<div class="categories-index py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Kategooriad</h1>
        <div>
            <?= Html::a('<i class="bi bi-plus-square me-2"></i> Lisa kategooriaid', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($categories as $category): ?>
            <div class="col">
                <div class="card h-100">
                    <?php
                        $imageMaxHeight = 300;

                        if (Html::encode($category->img_path) && Html::encode($category->img_extension)) {
                            echo Html::img(Yii::getAlias('@web/files/categories/' . Html::encode($category->id . '/' . $category->img_path . '.' . $category->img_extension)), ['alt' => $category->name, 'style' => 'max-height: ' . $imageMaxHeight . 'px; width: 100%; object-fit: cover;']);
                        } else {
                            echo '<div style="background-color: #ddd; height: ' . Html::encode($imageMaxHeight) . 'px;"></div>';
                        }
                    ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= mb_strtoupper(Html::encode($category->name)) ?></h5>
                    </div>
                    <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                        <?= Html::a('<i class="bi bi-pencil-square me-1"></i> Muuda', ['update', 'id' => Html::encode($category->id)], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                        <?= Html::a('<i class="bi bi-trash me-1"></i> Kustuta', ['delete', 'id' => Html::encode($category->id)], [
                            'class' => 'btn btn-outline-danger btn-sm',
                            'data' => [
                                'confirm' => 'Oled sa kindel, et soovid selle kategooria kustutada?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>