<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Categories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categories-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position')->textInput() ?>

    <div class="form-group py-3">
        <h6>Kategooria pilt</h6>
        <div class="custom-file-upload">
            <input type="file" id="imageFile" name="<?= Html::getInputName($model, 'imageFile') ?>" class="visually-hidden">
            <label for="imageFile" class="file-upload-button">Vali fail</label>
            <span class="file-upload-filename"></span>
        </div>
        <?php if ($model->hasErrors('imageFile')): ?>
            <div class="invalid-feedback"><?= Html::error($model, 'imageFile') ?></div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Salvesta', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    document.getElementById('imageFile').addEventListener('change', function() {
        var filename = this.value.split("\\").pop();
        document.querySelector('.file-upload-filename').textContent = filename.replace(/</g, "&lt;").replace(/>/g, "&gt;");
    });
</script>
