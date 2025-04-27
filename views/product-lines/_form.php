<?php

/** @var yii\web\View $this */
/** @var int $index */
/** @var app\models\ProductLines $model */
/** @var yii\widgets\ActiveForm $form */

if (!isset($index)) {
    $index = "";
}
?>

<div class="product-lines-form">
    <?= $form->field($model, "width[$index]")->textInput() ?>
    <?= $form->field($model, "thickness[$index]")->textInput() ?>
    <?= $form->field($model, "woodType[$index]")->textInput() ?>
    <?= $form->field($model, "price[$index]")->textInput() ?>
    <?= $form->field($model, "priceType[$index]")->textInput() ?>
</div>