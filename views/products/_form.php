<?php

use app\helpers\ProductsHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="products-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(ProductsHelper::GetAllCategories()) ?>

    <h2 class="pt-5">Toote mõõdud</h2>
    <button class="btn btn-success add-product-lines-btn">Lisa toote mõõtusid</button>

    <div class="product-lines-container py-5">
        <?php foreach ($model->productLines as $key => $productLine): ?>
            <?= $this->render("/product-lines/_form", [
                "form" => $form,
                "model" => $model,
                'index' => $key
            ]) ?>
        <?php endforeach; ?>
        <hr/>
    </div>

    <div class="form-group pt-4">
        <?= Html::submitButton('Salvesta', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<script>
    const addProductLines = document.querySelector(".add-product-lines-btn")
    const productLinesContainer = document.querySelector(".product-lines-container")
    let inputIndex = <?= count($model->productLines) ?>

    if (addProductLines) {
        addProductLines.addEventListener("click", async function(event) {
            event.preventDefault()
            const response = await fetch(`get-product-lines-form?inputIndex=${inputIndex}`);
            if (!response.ok) {
                throw new Error(`Response status: ${response.status}`);
            }

            const text = await response.text();
            const formElement = document.createElement("div")
            formElement.innerHTML = text+"<hr/>";

            if (productLinesContainer) {
                productLinesContainer.appendChild(formElement);
            }
            inputIndex++;
        })
    }
</script>
