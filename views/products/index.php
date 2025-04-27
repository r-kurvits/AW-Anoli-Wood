<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $categories \app\models\Categories[] */
/* @var $productsByCategory array */

$this->title = 'Tooted - Anoli Wood';
?>
<div class="products-index py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Tooted</h1>
            <div>
                <?= !Yii::$app->user->isGuest ? Html::a('<i class="bi bi-plus-square me-2"></i> Lisa tooteid', ['create'], ['class' => 'btn btn-success btn-sm']): "" ?>
            </div>
        </div>

        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $category): ?>
                <section class="mb-5">
                    <?php if (isset($products[$category->id]) && !empty($products[$category->id])): ?>
                        <h2 class="mb-3"><?= Html::encode($category->name) ?></h2>
                        
                        <ul class="list-group shadow-sm rounded">
                            <?php foreach ($products[$category->id] as $product): ?>
                                <div class="list-group-item rounded-top mb-0 bg-light d-flex justify-content-between align-items-center">
                                    <h5 class="mb-1"><?= Html::encode($product->name) ?></h5>
                                    <div>
                                        <?= !Yii::$app->user->isGuest ?
                                            Html::a('<i class="bi bi-pencil-square"></i> Muuda', ['update', 'id' => $product->id], ['class' => 'btn btn-outline-secondary btn-sm'])
                                            : ''
                                        ?>
                                    </div>
                                </div>
                                <?php if (!empty($product->productLines)): ?>
                                    <?php foreach ($product->productLines as $line): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <?php if ($line->img_path): ?>
                                                    <?= Html::img(Url::to($line->img_path), ['alt' => $line->wood_type, 'width' => '64', 'height' => '64', 'class' => 'me-3 rounded']) ?>
                                                <?php else: ?>
                                                    <div class="me-3" style="width: 128px; height: 128px; background-color: #f0f0f0; border-radius: 5px;"></div>
                                                <?php endif; ?>
                                                <div>
                                                    <p class="mb-0 text-muted">
                                                        Laius: <?= Html::encode($line->width) ?>,
                                                        Paksus: <?= Html::encode($line->thickness) ?>,
                                                        Tüüp: <?= Html::encode($line->wood_type) ?>,
                                                        Hind: <?= Html::encode($line->price) ?>€/<?= Html::encode($line->price_type) ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <?= Html::button('<i class="bi bi-cart-plus me-2"></i> Lisa ostukorvi', ['class' => 'btn btn-outline-secondary btn-sm', 'data-line-id' => $line->id]) ?>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </section>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>