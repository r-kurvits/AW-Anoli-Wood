<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $categories \app\models\Categories[] */
/* @var $productsByCategory array */ // Assuming you're using the controller logic from our previous discussion

$this->title = 'Tooted';
?>
<div class="products-index">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1><?= Html::encode($this->title) ?></h1>
        <div>
            <?= Html::a('Lisa tooteid', ['create'], ['class' => 'btn btn-primary btn-sm']) ?>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($categories as $category): ?>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <?= mb_strtoupper(Html::encode($category->name)) ?>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-sm-2 g-3">
                            <?php if (isset($products[$category->id]) && !empty($products[$category->id])): ?>
                                <?php foreach ($products[$category->id] as $product): ?>
                                    <div class="col">
                                        <div class="product-item border rounded p-3">
                                            <h6 class="card-title"><?= Html::encode($product->name) ?></h6>
                                            <p class="card-text small text-muted">
                                                Kattev laius: <?= Html::encode($product->width) ?><br>
                                                Paksus: <?= Html::encode($product->thickness) ?><br>
                                                Puidu tüüp: <?= Html::encode($product->wood_type) ?><br>
                                                Hind: <?= Html::encode($product->price) ?>
                                            </p>
                                            <?= Html::a('Vaata', ['view', 'id' => $product->id], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                                            <?= Html::a('Muuda', ['update', 'id' => $product->id], ['class' => 'btn btn-outline-secondary btn-sm ms-1']) ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col">
                                    <p class="text-muted">Selles kategoorias pole tooteid.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</div>