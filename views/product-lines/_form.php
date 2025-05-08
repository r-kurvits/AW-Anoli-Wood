<?php

/** @var yii\web\View $this */
/** @var int $index */
/** @var app\models\ProductLines $model */
/** @var yii\widgets\ActiveForm $form */
use yii\helpers\Html;
if (!isset($index)) {
    $index = "";
}
$inputIndex = $index + 1;
$index = Html::encode($index);
?>

<div class="product-lines-form bg-light p-3">
    <h5>Tootemõõt #<?= Html::encode($inputIndex) ?></h5>
    <?= $form->field($model, "width[$index]")->textInput() ?>
    <?= $form->field($model, "length[$index]")->textInput() ?>
    <?= $form->field($model, "thickness[$index]")->textInput() ?>
    <?= $form->field($model, "woodType[$index]")->textInput() ?>
    <?= $form->field($model, "price[$index]")->textInput() ?>
    <?= $form->field($model, "priceType[$index]")->textInput() ?>
    <div class="form-group py-3">
        <h6>Toote rea pilt</h6>
        <div class="custom-file-upload">
            <?= $form->field($model, "imageFile[{$index}]")->fileInput(["id" => "imageFile{$index}", "class" =>"visually-hidden", 'multiple' => true,])->label(false) ?>
            <label for="imageFile<?= $index ?>" class="file-upload-button">Vali fail</label>
            <span id="imageName<?= $index ?>" class="file-upload-filename"></span>
        </div>
        <?php if ($model->hasErrors('imageFile')): ?>
            <div class="invalid-feedback"><?= Html::error($model, 'imageFile') ?></div>
        <?php endif; ?>
    </div>
</div>