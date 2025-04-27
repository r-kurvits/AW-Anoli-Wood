<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Kontakt - Anoli Wood';
?>
<div class="contact py-5" style="background-color: #f8f9fa; margin-top: 60px">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 bg-white rounded shadow p-5">
                <div class="text-center mb-5">
                    <h1>Kontakt</h1>
                    <p class="text-muted">Kui teil on äripäringuid või muid küsimusi, võtke meiega ühendust.</p>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <h5 class="mb-2">Kontaktinfo</h5>

                        <p class="mb-1">
                            <strong>ANOLI PUIT OÜ</strong>
                        </p>
                        <p class="mb-1 text-muted">
                            Reg. kood: 11705241
                        </p>

                        
                    </div>
                    <div class="col-md-8">
                        <p class="mb-1">
                            <i class="bi bi-telephone-fill me-2 contact-icon"></i> Telefon: <a class="text-decoration-none" href="tel:+37253480984">+372 5348 0984</a>
                        </p>
                        <p class="mb-1">
                            <i class="bi bi-envelope-fill me-2 contact-icon"></i> E-mail: <a class="text-decoration-none" href="mailto:anolipuit@gmail.com">anolipuit@gmail.com</a>
                        </p>
                        <p class="mb-1">
                            <i class="bi bi-geo-alt-fill me-2 contact-icon"></i> Männi, Vilimeeste küla, 69718 Viljandi vald, Viljandi maakond
                        </p>
                    </div>
                </div>

                <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

                    <div class="alert alert-success">
                        Aitäh ühenduse võtmise eest! Vastame teile esimesel võimalusel.
                    </div>

                <?php else: ?>

                    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                        <?= $form->field($model, 'name')->textInput() ?>

                        <?= $form->field($model, 'email') ?>

                        <?= $form->field($model, 'subject') ?>

                        <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Saada', ['class' => 'btn btn-primary btn-block', 'name' => 'contact-button']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>