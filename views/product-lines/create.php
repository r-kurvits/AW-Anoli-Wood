<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ProductLines $model */

$this->title = "Lisa toote mõõtusid";
?>
<div class="product-lines-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
