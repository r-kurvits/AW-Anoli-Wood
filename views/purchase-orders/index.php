<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax; //For  AJAX-enabled GridView

/* @var $this yii\web\View */
/* @var $purchaseOrdersWithDetails array */ // Make sure your view knows about this variable

$this->title = 'Ostutellimused - Anoli Wood';
?>

<div class="purchase-orders-index py-5">
    <h1>Ostutellimused</h1>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider([
            'allModels' => $purchaseOrdersWithDetails,
            'pagination' => ['pageSize' => 10, ],
            'sort' => [ 'attributes' => ['offerName', 'email', 'totalPrice', 'orderComplete', 'createdAt', ] ],
        ]),
        'columns' => [
            [ 'attribute' => 'offerName', 'label' => 'Tellimus', ],
            [ 'attribute' => 'email', 'label' => 'Email', ],
            [ 'attribute' => 'totalPrice', 'label' => 'Maksumus', 'format' => ['currency', 'EUR'] ],
            [
                'attribute' => 'orderComplete',
                'label' => 'Tellimus lõpetatud',
                'format' => 'html',
                'value' => function ($model) {
                    return $model['orderComplete'] == 1 ? 'Jah' : 'Ei';
                } 
            ],
            [ 'attribute' => 'createdAt', 'label' => 'Tellimuse loomise kuupäev', 'format' => ['date', 'php:d.m.Y H:i:s'], ],
             [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<i class="bi bi-eye"></i>', $url, [
                            'title' => 'View Order',
                            'class' => 'text-primary',
                        ]);
                    },
                ],
            ],
        ],
        'pager' => ['class' => 'yii\bootstrap5\LinkPager', ],
        'emptyText' => 'No purchase orders found.', 
        'layout' => "{summary}\n{items}\n{pager}", 
    ]); ?>
    <?php Pjax::end(); ?>
</div>
