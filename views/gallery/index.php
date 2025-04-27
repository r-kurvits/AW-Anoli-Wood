<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use nemocoder\lightgallery\LightgalleryWidget;

$this->title = 'Galerii - Anoli Wood';
?>

<div class="gallery py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Galerii</h1>
        </div>

        <?php if (!empty($images)): ?>
            <?= LightgalleryWidget::widget([
                'items' => $images, // Your array of image URLs
                'clientOptions' => [
                    'selector' => '.gallery-item',
                    'download' => false, // Disable download button (optional)
                    // Add other Lightgallery.js options here if needed
                ],
                'itemConfig' => [
                    'tag' => 'a',
                    'class' => 'gallery-item',
                    'data-sub-html' => false, // You can add captions here if needed
                ],
            ]) ?>
        <?php else: ?>
            <p>Galerii on hetkel tühi.</p>
        <?php endif; ?>
    </div>
</div>