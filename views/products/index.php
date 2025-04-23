<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $categories \app\models\Categories[] */
/* @var $productsByCategory array */

$this->title = 'Tooted';
?>
<div class="products-index py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><?= Html::encode($this->title) ?></h1>
            <div>
                <?= Html::a('<i class="bi bi-plus-square me-2"></i> Lisa tooteid', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
            </div>
        </div>

        <?php if (empty($categories)): ?>
            <p class="lead text-muted">Ühtegi tootekategooriat pole veel lisatud.</p>
        <?php else: ?>
            <?php foreach ($categories as $category): ?>
                <section class="mb-5">
                    <?php if (isset($products[$category->id]) && !empty($products[$category->id])): ?>
                        <h2 class="mb-3"><?= Html::encode($category->name) ?></h2>
                        
                        <ul class="list-group shadow-sm rounded">
                            <?php foreach ($products[$category->id] as $product): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1"><?= Html::encode($product->name) ?></h6>
                                        <p class="mb-0 small text-muted">
                                            Laius: <?= Html::encode($product->width) ?>,
                                            Paksus: <?= Html::encode($product->thickness) ?>,
                                            Tüüp: <?= Html::encode($product->wood_type) ?>,
                                            Hind: <?= Html::encode($product->price) ?>€
                                        </p>
                                    </div>
                                    <div>
                                        <?= !Yii::$app->user->isGuest ?
                                            Html::a('<i class="bi bi-pencil-square"></i> Muuda', ['update', 'id' => $product->id], ['class' => 'btn btn-outline-secondary btn-sm'])
                                            : ''
                                        ?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </section>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>