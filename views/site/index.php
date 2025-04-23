<?php

/* @var $this yii\web\View */

$this->title = 'Anoli Wood';
?>

<div class="hero-full-screen">
    <div class="hero-image hero-section">
        <div class="container hero-content text-center">
            <h1 class="display-1 mb-4 text-white">Kvaliteetne saematerjal</h1>
            <p class="lead mb-4 text-white">Meie põhitegevuseks on kvaliteetse saematerjali tootmine, omame 15 aastat kogemust antud valdkonnas</p>
            <a href="<?= \yii\helpers\Url::to(['/products']) ?>" class="btn btn-primary btn-lg">Vaata meie tooteid</a>
        </div>
    </div>
</div>

<section id="about" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>Meist</h2>
                <p>Anoli Wood on pühendunud kvaliteetse saematerjali tootmisele juba 15 aastat. Meie kogemus ja teadmised tagavad, et meie tooted vastavad ka kõige kõrgematele standarditele. Kasutame parimat toorainet ja kaasaegseid tehnoloogiaid, et pakkuda teile esmaklassilist saematerjali.</p>
                <p>Oleme uhked oma pikaajalise kogemuse üle puidutööstuses ning meie eesmärk on jätkuvalt pakkuda klientidele parimat võimalikku teenust ja tooteid.</p>
                <a href="<?= \yii\helpers\Url::to(['/about-us']) ?>" class="btn btn-outline-secondary">Loe rohkem meist</a>
            </div>
            <div class="col-md-6">
                <img src="files/images/about-us.jpg" alt="Meist" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</section>

<section id="products" class="py-5 bg-light">
    <div class="container text-center">
        <h2>Meie tootevalik</h2>
        <p class="lead mb-4">Tutvu meie laia valikuga kvaliteetset saematerjali erinevateks kasutusotstarveteks.</p>
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card shadow">
                    <img src="<?= Yii::$app->request->baseUrl ?>/images/product1.jpg" class="card-img-top" alt="Saematerjal 1">
                    <div class="card-body">
                        <h5 class="card-title">Impregneritud puit</h5>
                        <p class="card-text">Vastupidav ja ilmastikukindel saematerjal välitingimustesse.</p>
                        <a href="<?= \yii\helpers\Url::to(['/products']) ?>" class="btn btn-sm btn-primary">Vaata lähemalt</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card shadow">
                    <img src="<?= Yii::$app->request->baseUrl ?>/images/product2.jpg" class="card-img-top" alt="Saematerjal 2">
                    <div class="card-body">
                        <h5 class="card-title">Konstruktsioonipuit</h5>
                        <p class="card-text">Kvaliteetne ja tugev puit ehituskonstruktsioonide jaoks.</p>
                        <a href="<?= \yii\helpers\Url::to(['/products']) ?>" class="btn btn-sm btn-primary">Vaata lähemalt</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card shadow">
                    <img src="<?= Yii::$app->request->baseUrl ?>/images/product3.jpg" class="card-img-top" alt="Saematerjal 3">
                    <div class="card-body">
                        <h5 class="card-title">Voodrilaud</h5>
                        <p class="card-text">Kaunis ja vastupidav voodrilaud teie kodu või hoone jaoks.</p>
                        <a href="<?= \yii\helpers\Url::to(['/products']) ?>" class="btn btn-sm btn-primary">Vaata lähemalt</a>
                    </div>
                </div>
            </div>
        </div>
        <a href="<?= \yii\helpers\Url::to(['/products']) ?>" class="btn btn-outline-primary btn-lg mt-3">Kogu tootevalik</a>
    </div>
</section>