<?php

/* @var $this yii\web\View */

$this->title = 'Anoli Wood';
?>

<section id="hero" class="py-5">
    <div class="hero-section">
        <div class="hero-content">
            <h1>Kvaliteetne saematerjal</h1>
            <p>Meie põhitegevuseks on kvaliteetse saematerjali tootmine, omame 15 aastat kogemust antud valdkonnas</p>
            <a href="<?= \yii\helpers\Url::to(['/products']) ?>" class="btn">Vaata meie tooteid</a>
        </div>
    </div>
</section>

<section id="about" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>Meist</h2>
                <p>Anoli Wood on pühendunud kvaliteetse saematerjali tootmisele juba 15 aastat. Meie kogemus ja teadmised tagavad, et meie tooted vastavad ka kõige kõrgematele standarditele. Kasutame parimat toorainet ja kaasaegseid tehnoloogiaid, et pakkuda teile esmaklassilist saematerjali.</p>
                <p>Oleme uhked oma pikaajalise kogemuse üle puidutööstuses ning meie eesmärk on jätkuvalt pakkuda klientidele parimat võimalikku teenust ja tooteid.</p>
                <a href="<?= \yii\helpers\Url::to(['/about-us']) ?>" class="btn">Loe rohkem meist</a>
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
            <?php foreach($categories as $category): ?>
                <div class="col-lg-3 mb-3">
                    <div class="card shadow">
                        <img src="<?= Yii::$app->request->baseUrl ?>/files/categories/<?= $category->id ?>/<?= $category->img_path ?>.<?= $category->img_extension ?>" class="card-img-top" alt="Saematerjal 1">
                        <div class="card-body">
                            <h5 class="card-title"><?= $category->name ?></h5>
                            <!--p class="card-text">Vastupidav ja ilmastikukindel saematerjal välitingimustesse.</p-->
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="<?= \yii\helpers\Url::to(['/products']) ?>" class="btn">Kogu tootevalik</a>
    </div>
</section>