<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use newerton\fancybox3\FancyBox;
use yii\web\JqueryAsset;

JqueryAsset::register($this);
$this->title = 'Galerii - Anoli Wood';

$this->registerJs('
    $(document).ready(function() {
        $(".thumbnails a:first-child").addClass("active");

        $("#mainCarousel").on("slide.bs.carousel", function(e) {
            var activeSlideIndex = $(e.relatedTarget).index();
            $(".thumbnails a").removeClass("active");
            $(".thumbnails a").eq(activeSlideIndex).addClass("active");
        });
    });
', \yii\web\View::POS_READY, 'gallery-init');
?>
<div class="gallery-index py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Galerii</h1>
            <div>
                <?= !Yii::$app->user->isGuest ? 
                Html::a('<i class="bi bi-plus-square me-2"></i> Lisa pilte', ['create'], ['class' => 'btn button-small btn-sm']):
                 "" ?>
            </div>
        </div>
        <?php if (count($images)>0): ?>
            <div id="mainCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach ($images as $index => $image): ?>
                        <div class="carousel-item<?= $index === 0 ? ' active' : '' ?>">
                            
                            <a href="<?= Yii::getAlias('@web/files/gallery/' . Html::encode( $image->img_path . '.' . $image->img_extension)) ?>" data-fancybox="gallery-carousel" data-thumb="<?= Yii::getAlias('@web/files/gallery/thumb/' . Html::encode( $image->img_path . '.' . $image->img_extension)) ?>">
                                <?= Html::img(Yii::getAlias('@web/files/gallery/' . Html::encode( $image->img_path . '.' . $image->img_extension)), ['class' => 'd-block w-100', 'alt' => 'Gallery Image ' . ($index + 1)]); ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if (count($images) > 1): ?>
                    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                <?php endif; ?>
            </div>
            <div class="thumbnails">
                <?php foreach ($images as $index => $image): ?>
                    <a href="<?= Yii::getAlias('@web/files/gallery/' . Html::encode( $image->img_path . '.' . $image->img_extension)) ?>" data-fancybox="gallery-carousel" data-thumb="<?= Yii::getAlias('@web/files/gallery/thumb/' . Html::encode( $image->img_path . '.' . $image->img_extension)) ?>">
                        <?= Html::img(Yii::getAlias('@web/files/gallery/thumb/' . Html::encode( $image->img_path . '.' . $image->img_extension)), ['class' => 'thumbnail-img']); ?>
                    </a>
                <?php endforeach; ?>
            </div>
            <?php
            echo FancyBox::widget([
                'target' => '[data-fancybox="gallery-carousel"]',
                'config' => [
                    'loop' => true,
                    'arrows' => true,
                    'margin' => [44, 0],
                    'thumbs' => [ 'autoStart' => false, 'hideOnClose' => false, ],
                    'slideShow' => [ 'autoStart' => false, 'pauseOnHover' => true ],
                    'buttons' => [ 'slideShow', 'fullScreen', 'thumbs', 'close' ],
                    'afterLoad' => 'function(instance, current) {
                        $(".thumbnails a").removeClass("active");
                        $(".thumbnails a[href=\'" + current.opts.thumb + "\']").addClass("active");
                    }',
                ],
            ]);
            ?>
        <?php endif; ?>
    </div>
</div>