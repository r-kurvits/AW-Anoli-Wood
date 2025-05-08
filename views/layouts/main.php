<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap5\Dropdown;

AppAsset::register($this);
$cartQuantity = Yii::$app->cartService->getCartQuantity();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script src="https://kit.fontawesome.com/6698cec26a.js" crossorigin="anonymous"></script>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
<?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar navbar-expand-lg navbar-light bg-light text-uppercase fw-bold text-dark fixed-top',
        ],
    ]);
?>
<div class="container-fluid">
    <div class="row justify-content-between align-items-center">
        <div class="col-auto">
            <a class="navbar-brand d-flex align-items-center justify-content-center justify-content-lg-start" href="<?= Html::encode(Yii::$app->homeUrl) ?>">
                <img src="/files/images/aw-anoli-wood.png" width="64" height="64" class="d-inline-block" alt="aw-anoli-wood">
                <span class="ms-2"><?= Html::encode(Yii::$app->name) ?></span>
            </a>
        </div>
        <div class="col">
            <div class="d-flex justify-content-start collapse navbar-collapse" id="navbarNav">
                <?php
                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav nav-pills'],
                    'items' => [
                        ['label' => 'Avaleht', 'url' => ['/']],
                        ['label' => 'Meist', 'url' => ['/about-us']],
                        ['label' => 'Tooted', 'url' => ['/products']],
                        ['label' => 'Kontakt', 'url' => ['/contact']],
                        ['label' => 'Galerii', 'url' => ['/gallery']],
                        Yii::$app->user->identity ?
                        [
                            'label' => 'Admin',
                            'items' => [
                                ['label' => 'Kasutajad', 'url' => ['/user']],
                                ['label' => 'Kategooriad', 'url' => ['/categories']],
                                ['label' => 'Ostutellimused', 'url' => ['/purchase-orders']],
                                [
                                    'label' => 'Logi välja',
                                    'url' => ['/management/logout'],
                                    'linkOptions' => [
                                        'data' => [
                                            'method' => 'post'
                                        ]
                                    ]
                                ],
                            ],
                            'options' => ['class' => 'nav-item dropdown'],
                            'linkOptions' => ['class' => 'nav-link dropdown-toggle', 'data-bs-toggle' => 'dropdown', 'aria-expanded' => 'false'],
                            'dropdownOptions' => ['class' => 'dropdown-menu'],
                        ] : ['label' => ''],
                    ],
                ]);
                ?>
            </div>
        </div>
        <div class="col-auto">
            <a class="nav-link" href="/cart/view-cart">
                <i class="bi bi-cart fa-lg"></i>
                <span id="shopping-cart-qty" class="badge bg-secondary rounded-pill"><?= Html::encode($cartQuantity) ?></span>
            </a>
        </div>
    </div>
</div>
<?php NavBar::end() ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
    <?php
        $this->registerJs(<<<JS
            $(document).ready(function() {
                var offerSuccessMessage = $('.alert-success:contains("Teie ostupäring on edastatud!")');
                if (offerSuccessMessage.length > 0) {
                    $('#offer-notification-area').prepend(offerSuccessMessage);
                }
            });
        JS);
    ?>
    <div id="offer-notification-area" style="position: absolute; top: 120px; left: 50%; transform: translateX(-50%); z-index: 1000;"></div>
</div>

<footer class="footer">
    <div class="container">
        <div class="footer-content-container justify-content-center">
            <div class="paragraph ">
                <p>Männi, Vilimeeste küla, 69718 Viljandi vald, Viljandi maakond</p>
            </div>
            
        </div>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
