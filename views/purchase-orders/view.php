<?php

use yii\bootstrap5\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $purchaseOrder array */

$this->title = 'Ostutellimus - Anoli Wood';

function displayProductDetails($items) {
    $output = '<table class="table table-sm table-bordered">';
    $output .= '<thead><tr><th>Toode</th><th>Kogus</th><th>Hind</th><th>Summa</th></tr></thead><tbody>';
    $totalPrice = 0;
    foreach ($items as $item) {
        $productName = ArrayHelper::getValue($item, 'name', 'N/A');
        $productWidth = ArrayHelper::getValue($item, 'width');
        $productLength = ArrayHelper::getValue($item, 'length');
        $productThickness = ArrayHelper::getValue($item, 'thickness');
        $productWoodType = ArrayHelper::getValue($item, 'woodType');
        $quantity = ArrayHelper::getValue($item, 'quantity', 0);
        $price = ArrayHelper::getValue($item, 'price', 0);
        $priceType = ArrayHelper::getValue($item, 'priceType', 0);
        $linePrice = $quantity * $price;
        $totalPrice += $linePrice;

        $output .= '<tr>';
            $output .= "<td>";
                $output .= "<p class='mb-0'>";
                    $output .= Html::encode($productName);
                $output .= "</p>";
                $output .= "<small class='text-muted d-block'>";
                    $output .= "Laius: ". Html::encode($productWidth);
                $output .= "</small>";
                $output .= "<small class='text-muted d-block'>";
                    $output .= "Pikkus: ". Html::encode($productLength);
                $output .= "</small>";
                $output .= "<small class='text-muted d-block'>";
                    $output .= "Paksus: ". Html::encode($productThickness);
                $output .= "</small>";
                $output .= "<small class='text-muted d-block'>";
                    $output .= "Puu tüüp: ". Html::encode($productWoodType);
                $output .= "</small>";
            $output .= "</td>";
            $output .= '<td>' . Html::encode($quantity) . '</td>';
            $output .= '<td>' . Yii::$app->formatter->asCurrency($price, 'EUR') .'/'.Html::encode($priceType) . '</td>';
            
            $output .= '<td>' . Yii::$app->formatter->asCurrency($linePrice, 'EUR') . '</td>';
        $output .= '</tr>';
    }
    $output .= '<tr><td colspan="3" class="text-end fw-bold">Kokku:</td><td>' . Yii::$app->formatter->asCurrency($totalPrice, 'EUR') . '</td></tr>';
    $output .= '</tbody></table>';
    return $output;
}
?>

<div class="purchase-orders-view py-5">
    <div class="container">
        <div class="d-md-flex justify-content-between align-items-center mb-4">
            <div>
                <h1><?= Html::a('<i class="bi bi-arrow-left"></i>', ['index'], ['class' => 'text-decoration-none text-dark']) ?> Ostutellimus - <?= Html::encode($purchaseOrder['offerName']) ?></h1>
            </div>
            <div class="mt-2 mt-md-0">
                <?= !Yii::$app->user->isGuest && $purchaseOrder['orderComplete']== 0 ? Html::button('<i class="bi bi-plus-square me-2"></i> Märgi lõpetatuks', ['id' => 'finishOrder', 'class' => 'btn button-small btn-sm']) : "" ?>
                <?= Html::a('<i class="bi bi-file-earmark-pdf me-2"></i> Laadi alla PDF', ['generate-pdf', 'id' => Html::encode($purchaseOrder['id'])], ['class' => 'btn btn-sm btn-primary']) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title">Tellimuse info</h2>
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Tellimuse nimi:</strong> <?= Html::encode($purchaseOrder['offerName']) ?></li>
                            <li class="list-group-item"><strong>E-mail:</strong> <?= Html::encode($purchaseOrder['email']) ?></li>
                            <li class="list-group-item"><strong>Tellimuse staatus:</strong> <?= $purchaseOrder['orderComplete'] == 1 ? '<span class="badge bg-success">Lõpetatud</span>' : '<span class="badge bg-warning">Pooleli</span>' ?></li>
                            <li class="list-group-item"><strong>Tellimuse aeg:</strong> <?= date('d.m.Y H:i:s', substr(Html::encode($purchaseOrder['createdAt']), 0, 10)) ?></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title">Tooted</h2>
                        <?= displayProductDetails($purchaseOrder['items']) ?>
                        <p class="card-text"><strong>Summa:</strong> <?= Yii::$app->formatter->asCurrency($purchaseOrder['totalPrice'], 'EUR') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$id = str_replace('\\', '\\\\', $purchaseOrder["id"]);
$this->registerJs(<<<JS
$('#finishOrder').on('click', function() {
    var offerId = "$id";
    $.ajax({
        url: '/purchase-orders/finish-order',
        type: 'POST',
        data: {_csrf: yii.getCsrfToken(), id: offerId },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                location.reload();
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX error:", error);
            alert("Viga ostukorvi tühjendamisel.");
        }
    })
})
JS
);
?>
