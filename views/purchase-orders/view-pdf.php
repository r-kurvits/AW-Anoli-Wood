<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $purchaseOrder array */

function displayProductDetailsForPdf($items) {
    $output = '<table style="width: 100%; border-collapse: collapse;">';
    $output .= '<thead><tr><th style="border: 1px solid #000; padding: 8px;">Toode</th><th style="border: 1px solid #000; padding: 8px;">Kogus</th><th style="border: 1px solid #000; padding: 8px;">Hind</th><th style="border: 1px solid #000; padding: 8px;">Summa</th></tr></thead><tbody>';
    $totalPrice = 0;
    foreach ($items as $item) {
        $productName = ArrayHelper::getValue($item, 'name', 'N/A');
        $productWidth = ArrayHelper::getValue($item, 'width', '');
        $productLength = ArrayHelper::getValue($item, 'length', '');
        $productThickness = ArrayHelper::getValue($item, 'thickness', '');
        $productWoodType = ArrayHelper::getValue($item, 'woodType', '');
        $quantity = ArrayHelper::getValue($item, 'quantity', 0);
        $price = ArrayHelper::getValue($item, 'price', 0);
        $priceType = ArrayHelper::getValue($item, 'priceType', '');
        $linePrice = $quantity * $price;
        $totalPrice += $linePrice;

        $output .= '<tr>';
            $output .= '<td style="border: 1px solid #000; padding: 8px;"><p>' . Html::encode($productName) . '</p>';
                $output .= '<small style="color: #666; display: block;">';
                    $output .= 'Laius: '. Html::encode($productWidth);
                $output .= '</small>';
                $output .= '<small style="color: #666; display: block;"><br>';
                    $output .= 'Pikkus: ' . Html::encode($productLength);
                $output .= '</small>';
                $output .= '<small style="color: #666; display: block;"><br>';
                    $output .= 'Paksus: ' . Html::encode($productThickness);
                $output .= '</small>';
                $output .= '<small style="color: #666; display: block;"><br>';
                    $output .= 'Puu tüüp: '. Html::encode($productWoodType);
                $output .= '</small>';
            $output .= '</td>';
            $output .= '<td style="border: 1px solid #000; padding: 8px;">' . Html::encode($quantity) . '</td>';
            $output .= '<td style="border: 1px solid #000; padding: 8px;">' . Yii::$app->formatter->asCurrency($price, 'EUR') . '/' . Html::encode($priceType) . '</td>';
            $output .= '<td style="border: 1px solid #000; padding: 8px;">' . Yii::$app->formatter->asCurrency($linePrice, 'EUR') . '</td>';
        $output .= '</tr>';
    }
    $output .= '<tr><td colspan="3" style="border: 1px solid #000; padding: 8px; text-align: right; font-weight: bold;">Kokku:</td><td style="border: 1px solid #000; padding: 8px;">' . Yii::$app->formatter->asCurrency($totalPrice, 'EUR') . '</td></tr>';
    $output .= '</tbody></table>';
    return $output;
}
?>
<div style="text-align: left; margin-bottom: 20px;">
    <img src ="<?= Yii::getAlias('@webroot') ?>/files/images/aw-anoli-wood.png" alt="Anoli Wood" width="64" height="64" />
</div>
<h1>Arve</h1>

<p><strong><?= Html::encode($purchaseOrder['offerName']) ?></strong></p>
<p><strong>Tellimuse aeg:</strong> <?= date('d.m.Y H:i:s', substr($purchaseOrder['createdAt'], 0, 10)) ?></p>

<h2>Tooted</h2>
<?= displayProductDetailsForPdf($purchaseOrder['items']) ?>

<p><strong>Summa:</strong> <?= Yii::$app->formatter->asCurrency($purchaseOrder['totalPrice'], 'EUR') ?></p>