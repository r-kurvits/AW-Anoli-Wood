<?php

/** @var yii\web\View $this */
/** @var int $index */
/** @var app\models\Gallery $model */
/** @var yii\widgets\ActiveForm $form */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="gallery-form bg-light p-3">
    <div class="form-group py-3">
        <h6>Pildid</h6>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="custom-file-upload">
            <?= $form->field($model, "imageFile[]")->fileInput(["id" => "imageFile","class" =>"visually-hidden", 'multiple' => true])->label(false) ?>
            <label for="imageFile" class="file-upload-button">Vali pilte</label>
            <span id="imageName" class="file-upload-filename"></span>
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
    var filenames = [];
    if (this.files && this.files.length > 0) {
        for (var i = 0; i < this.files.length; i++) {
            filenames.push(this.files[i].name);
        }
        document.getElementById('imageName').textContent = filenames.join(', ');
    } else {
        document.getElementById('imageName').textContent = '';
    }
});
</script>