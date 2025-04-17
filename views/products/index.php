<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tooted';
?>
<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Lisa kategooriaid', ['categories/create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Lisa tooteid', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php foreach($categories as $category): ?>
        <div><?= $category->name ?></div>
    <?php endforeach ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php /*
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'category_id',
            'img_path',
            'img_extension',
            'width',
            //'thickness',
            //'wood_type',
            //'price',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    */
    ?>
    <?php Pjax::end(); ?>

</div>
