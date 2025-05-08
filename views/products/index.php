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
                <?= !Yii::$app->user->isGuest ? Html::a('<i class="bi bi-plus-square me-2"></i> Lisa tooteid', ['create'], ['class' => 'btn button-small btn-sm']): "" ?>
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
                                    <div class="d-flex gap-2">
                                        <?= !Yii::$app->user->isGuest ? Html::a('<i class="bi bi-pencil-square"></i> Muuda', ['update', 'id' => $product->id], ['class' => 'btn btn-outline-secondary btn-sm']): '' ?>
                                        <?= !Yii::$app->user->isGuest ? Html::a('<i class="bi bi-trash me-2"></i> Kustuta', ['delete', 'id' => $product->id], [
                                            'class' => 'btn btn-outline-danger btn-sm',
                                            'data' => [
                                                'confirm' => 'Oled sa kindel, et soovid selle toote kustutada?',
                                                'method' => 'post',
                                            ],
                                        ]) : '' ?>
                                    </div>
                                </div>
                                <?php if (!empty($product->productLines)): ?>
                                    <?php foreach ($product->productLines as $line): ?>
                                        <li class="list-group-item rounded-top mb-2 bg-light">
                                            <div class="row align-items-center">
                                                <div class="col-4 col-sm-3">
                                                    <?php if ($line->img_path != ""): ?>
                                                        <?= Html::img(Yii::getAlias('@web/files/products/' . Html::encode($product->id . '/' . $line->img_path . '.' . $line->img_extension)), ['alt' => Html::encode($line->img_path), 'class' => 'img-fluid rounded']) ?>
                                                    <?php else: ?>
                                                        <div style="background-color: #f0f0f0; border-radius: 5px; height: 80px; display: flex; justify-content: center; align-items: center;">
                                                            <i class="bi bi-image" style="font-size: 2rem; color: #ccc;"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="col-8 col-sm-6">
                                                    <p class="mb-1">
                                                        Laius: <?= Html::encode($line->width) ?><br>
                                                        Pikkus: <?= Html::encode($line->length) ?><br>
                                                        Paksus: <?= Html::encode($line->thickness) ?><br>
                                                        Tüüp: <?= Html::encode($line->wood_type) ?><br>
                                                        Hind: <?= Html::encode($line->price) ?>€/<?= Html::encode($line->price_type) ?>
                                                    </p>
                                                </div>
                                                <div class="col-12 col-sm-3 mt-2 mt-sm-0 d-flex flex-column align-items-start align-items-sm-end">
                                                    <?= Html::button('<i class="bi bi-cart-plus me-2"></i> Lisa ostukorvi', ['class' => 'btn btn-outline-secondary btn-sm mb-1 w-100', 'data-line-id' => Html::encode($line->id)]) ?>
                                                    <?= !Yii::$app->user->isGuest ? Html::a('<i class="bi bi-trash me-2"></i> Kustuta', ['delete-product-line', 'productLineId' => Html::encode($line->id)], [
                                                        'class' => 'btn btn-outline-danger btn-sm w-100',
                                                        'data' => [
                                                            'confirm' => 'Oled sa kindel, et soovid selle tooterea kustutada?',
                                                            'method' => 'post',
                                                        ],
                                                    ]) : '' ?>
                                                </div>
                                            </div>
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
<?php
    $this->registerJs(<<<JS
    $('.btn-outline-secondary[data-line-id]').on('click', function() {
        var lineId = $(this).data('line-id');

        $.ajax({
            url: '/cart/add-to-cart',
            type: 'POST',
            data: { line_id: lineId, _csrf: yii.getCsrfToken() },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    if (response.cartQuantity !== undefined) {
                        if (response.cartQuantity > 0) {
                            $("#shopping-cart-qty").text(response.cartQuantity);
                        }
                    }
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX error:", error);
                alert("Viga toote ostukorvi lisamisel.");
            }
        });
    });
    JS
    );
?>