<?php

use app\models\ProductLines;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = "Toote mõõdud";
?>
<div class="product-lines-index">
    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'width',
            'thickness',
            'wood_type',
            'price',
            'price_type'
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
