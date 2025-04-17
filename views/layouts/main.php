<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
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
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-lg navbar-dark bg-dark',
        ],
    ]);
    $baseItems = [
        ['label' => 'Avaleht', 'url' => ['/']],
        ['label' => 'Ettevõttest', 'url' => ['/about-us']],
        ['label' => 'Tooted', 'url' => ['/products']],
        ['label' => 'Kontakt', 'url' => ['/contact']],
        ['label' => 'Galerii', 'url' => ['/gallery']],
    ];
    $userItems = Yii::$app->user->identity ? [
        ['label' => 'Kasutajad', 'url' => ['/users']],
        [
            'label' => 'Logi välja ('. Yii::$app->user->identity->email .')', 
            'url' => ['/management/logout'],
            'linkOptions' => [
                'data' => [
                    'method' => 'post'
                ]
            ]
        ]
    ] : [];

    $items = array_merge($baseItems, $userItems);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav nav-item'],
        'items' => $items
    ]);
    NavBar::end()
    /*echo Nav::widget([
        'options' => ['class' => 'navbar-nav nav-item'],
        'items' => [
            ['label' => 'Avaleht', 'url' => ['/']],
            ['label' => 'Ettevõttest', 'url' => ['/about-us']],
            ['label' => 'Tooted', 'url' => ['/products']],
            ['label' => 'Kontakt', 'url' => ['/contact']],
            ['label' => 'Galerii', 'url' => ['/gallery']],

            Yii::$app->user->isGuest ? (
                ''
            ) : (
                [
                ['label' => 'Kasutajad', 'url' => ['/users']],
                ['label' => 'Logi välja', 'url' => ['/management']]
                ]
            )
        ],
    ]);
    NavBar::end();*/
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
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
