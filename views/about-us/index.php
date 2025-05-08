<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'Meist - Anoli Wood';
?>

<div class="about-us py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Meist</h1>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <h1 class="mb-4">Kvaliteet ja kogemus puidutööstuses</h1>
                <p class="lead mb-4">Anoli Wood on teie usaldusväärne partner kvaliteetse saematerjali alal. Oleme pühendunud pakkuma esmaklassilist puitu, mis vastab ka kõige nõudlikumatele standarditele. Meie 15-aastane kogemus antud valdkonnas tagab teile asjatundliku teeninduse ja tooted, millele võite kindel olla.</p>

                <h2 class="mb-3">Meie lugu</h2>
                <p>Anoli Wood sai alguse 2010 visioonist tuua turule saematerjal, mis ühendab endas traditsioonilised väärtused ja kaasaegsed tootmisvõtted. Aastate jooksul oleme kasvanud ja arenenud, kuid meie põhimõtted on jäänud samaks: kompromissitu kvaliteet, jätkusuutlikkus ja klientide rahulolu.</p>
                <p>Oleme uhked oma juurte üle Eesti puidutööstuses ning panustame kohaliku majanduse arengusse. Meie meeskond koosneb kogenud spetsialistidest, kes jagavad kirge puidu vastu ja on pühendunud oma tööle.</p>

                <h2 class="mb-3">Meie väärtused</h2>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> **Kvaliteet:** Meie peamine prioriteet on pakkuda saematerjali, mis on vastupidav, esteetiline ja kõrgeima kvaliteediga.</li>
                    <li class="mb-2"><i class="bi bi-tree-fill text-success me-2"></i> **Jätkusuutlikkus:** Hoolime keskkonnast ja kasutame võimalikult säästlikke metsanduspraktikaid. Meie eesmärk on jätta endast maha positiivne jalajälg.</li>
                    <li class="mb-2"><i class="bi bi-people-fill text-success me-2"></i> **Kliendikesksus:** Teie vajadused on meie jaoks olulised. Oleme valmis teid aitama alates esimesest kontaktist kuni tellimuse täitmiseni.</li>
                    <li class="mb-2"><i class="bi bi-gear-fill text-success me-2"></i> **Kogemus:** Meie pikaajaline kogemus puidutööstuses annab meile teadmised ja oskused, et pakkuda teile parimaid lahendusi.</li>
                </ul>
            </div>
            <div class="col-lg-6">
                <img src="files/images/about-us-1.jpg" alt="Meist-1" class="img-fluid rounded shadow-lg mb-4">
                <img src="files/images/about-us-2.jpg" alt="Meist-2" class="img-fluid rounded shadow-lg">
            </div>
        </div>

        <hr class="my-5">

        <div class="row">
            <div class="col-md-4 text-center mb-4">
                <i class="bi bi-clock-history display-4 text-primary"></i>
                <h3 class="mt-2">15 aastat kogemust</h3>
                <p class="text-muted">Pikaajaline tegutsemine puiduturul.</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <i class="bi bi-award-fill display-4 text-warning"></i>
                <h3 class="mt-2">Kvaliteedigarantii</h3>
                <p class="text-muted">Oleme kindlad oma toodete kõrges kvaliteedis.</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <i class="bi bi-truck display-4 text-info"></i>
                <h3 class="mt-2">Kiire ja usaldusväärne tarne</h3>
                <p class="text-muted">Toimetame teie tellimuse kohale õigeaegselt.</p>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12 text-center">
                <p class="lead">Oleme valmis teid aitama teie puiduvajadustega. Võtke meiega ühendust juba täna!</p>
                <?= Html::a('Võta ühendust', ['/contact'], ['class' => 'btn button']) ?>
            </div>
        </div>
    </div>
</div>