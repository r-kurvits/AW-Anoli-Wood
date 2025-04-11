<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
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
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'About Us', 'url' => ['/page/about-us']],

            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/default/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/default/logout'], 'post')
                . Html::submitButton(
                    '<i class="fas fa-sign-out-alt"></i>Logout (' . Yii::$app->user->identity->email . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
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
        <div class="footer-content-container">
            <div class="paragraph">
                <div>
                    <a target="_blank" href="/page/terms-and-conditions">Terms & Conditions</a>
                </div>
                <div>
                    <a target="_blank" href="/page/privacy-policy">Privacy Policy</a>
                </div>
            </div>
            
            <div class="paragraph"><?= Yii::powered() ?></div>
        </div>
    </div>
    <div class="copyright-container">&copy; My Company <?= date('Y') ?></div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
