<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Gallery */

$this->title = 'Lisa pilte - Anoli Wood';
?>
<div class="gallery-create py-5">

    <h1>Lisa pilte</h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
