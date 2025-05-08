<?php

use app\helpers\ProductsHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(ProductsHelper::GetAllCategories()) ?>

    <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
        <h2>Toote mõõdud</h2>
        <div>
            <?= !Yii::$app->user->isGuest ? 
            Html::button(
                '<i class="bi bi-plus-square me-2"></i> Lisa toote mõõtusid', 
                ['class' => 'btn button-small btn-sm add-product-lines-btn'])
            : "" ?>
        </div>
    </div>

    <div class="product-lines-container py-2">
        <?php
            foreach ($model->productLines as $key => $productLine): ?>
                <?= $this->render("/product-lines/_form", [
                    "form" => $form,
                    "model" => $model,
                    'index' => $key,
                ]) ?>
        <?php
            endforeach;
        ?>
    </div>

    <div class="form-group pt-4">
        <?= Html::submitButton('Salvesta', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<script>
    const addProductLines = document.querySelector(".add-product-lines-btn");
    const productLinesContainer = document.querySelector(".product-lines-container");
    let inputIndex = <?= count($model->productLines) ?>;
    
    if (addProductLines) {
        addProductLines.addEventListener("click", async function(event) {
            event.preventDefault()
            const response = await fetch(`get-product-lines-form?id=<?= Html::encode($model->id) ?>&inputIndex=${inputIndex}`);
            if (!response.ok) {
                throw new Error(`Response status: ${response.status}`);
            }

            const text = await response.text();
            const formElement = document.createElement("div")
            formElement.innerHTML = text+"<hr/>";

            if (productLinesContainer) {
                productLinesContainer.appendChild(formElement);
                fileInputs();
                inputIndex++;
            }
        })
    }

    function changeListener(event) {
        handleInput(event.target);
    }

    function handleInput(eventTarget) {
        const inputId = eventTarget.id;
        const index = inputId.replace('imageFile', '');
        const filename = eventTarget.value.split("\\").pop();
        const filenameDisplay = document.getElementById(`imageName${index}`);

        if (filenameDisplay) {
            filenameDisplay.textContent = filename;
        } else {
            console.error(`Could not find filename display element with ID: imageName${index}`);
        }
    }

    function fileInputs() {
        const imageFiles = document.querySelectorAll('[id^="imageFile"]');
        imageFiles.forEach(imageFile => {
            imageFile.removeEventListener('change', changeListener)
            imageFile.addEventListener('change', changeListener);
        });
    }

    function domLoaded() {
        fileInputs()
    }
    document.addEventListener('DOMContentLoaded', domLoaded);
    
</script>
