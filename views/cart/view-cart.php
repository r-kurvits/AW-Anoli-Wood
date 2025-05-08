<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $cartItems array */

$this->title = 'Ostukorv - Anoli Wood';
?>

<div class="cart-view py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Ostukorv</h1>
        <div>
            <?= !empty($cartItems) ? Html::button('<i class="bi bi-trash me-2"></i> Tühjenda ostukorv', ['id' => 'emptyShoppingCart', 'class' => 'btn button-small btn-sm']) : '' ?>
        </div>
    </div>
    <div class="cart">
        <?php if (!empty($cartItems)): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Toode</th>
                            <th>Hind</th>
                            <th>Kogus</th>
                            <th>Kokku</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; $totalPrice = 0; ?>
                        <?php foreach($cartItems as $lineId => $item): ?>
                            <?php if ($item['product']): ?>
                                <?php
                                    $itemTotalPrice = $item['product']->price * $item['quantity'];
                                    $totalPrice += $itemTotalPrice;
                                ?>
                                <tr>
                                    <td class="align-middle"><?= $i++ ?></td>
                                    <td class="align-middle">
                                        <p class="mb-0"><?= Html::encode($item['product']->product->name) ?></p>
                                        <small class="text-muted">
                                            <?= Html::encode($item['product']->product->name) ?>
                                            <?= Html::encode($item['product']->wood_type) ?>
                                            <?= Html::encode($item['product']->width) ?>x
                                            <?= Html::encode($item['product']->length) ?>x
                                            <?= Html::encode($item['product']->thickness) ?>
                                        </small>
                                    </td>
                                    <td class="align-middle"><?= Html::encode(Yii::$app->formatter->asCurrency($item['product']->price, 'EUR')) ?>
                                    /<?= Html::encode($item['product']->price_type) ?></td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <?= Html::button('<i class="bi bi-dash-lg"></i>', [
                                                'class' => 'btn btn-sm btn-outline-secondary me-2 cart-qty-change',
                                                'data-line-id' => (int)$lineId,
                                                'data-action' => 'decrease',
                                            ]) ?>
                                            <span class="cart-quantity"><?= Html::encode($item['quantity']) ?></span>
                                            <?= Html::button('<i class="bi bi-plus-lg"></i>', [
                                                'class' => 'btn btn-sm btn-outline-secondary ms-2 cart-qty-change',
                                                'data-line-id' => (int)$lineId,
                                                'data-action' => 'increase',
                                            ]) ?>
                                        </div>
                                    </td>
                                    <td class="align-middle"><?= Html::encode(Yii::$app->formatter->asCurrency($itemTotalPrice, 'EUR')) ?></td>
                                    <td class="align-middle">
                                        <?= Html::button('X', ['class' => 'cart-remove-item btn btn-link text-decoration-none link-dark', 'data-line-id' => $lineId,]) ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-end"><strong>Kokku:</strong></td>
                            <td><strong id="totalPrice"><?= Html::encode(Yii::$app->formatter->asCurrency($totalPrice, 'EUR')) ?></strong></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <?= Html::beginForm(['cart/send-offer'], 'post') ?>

            <div class="mb-3">
                <label for="offer-email" class="form-label">Teie E-posti Aadress</label>
                <?= Html::input('email', 'offer_email', '', ['class' => 'form-control', 'id' => 'offer-email', 'required' => true]) ?>
                <div class="form-text">Juhul, kui tekib küsimusi või tellimus on valmis võtame teiega ühendust.</div>
            </div>

            <?= Html::submitButton('<i class="bi bi-envelope me-2"></i> Saada Päring Ettevõttele', ['class' => 'btn btn-primary']) ?>

        <?= Html::endForm() ?>

            <p class="mt-3">
                <?= Html::a('<i class="bi bi-arrow-left me-2"></i> Jätka ostmist', Url::to(['/products']), ['class' => 'btn btn-outline-primary']) ?>
            </p>

        <?php else: ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i> Teie ostukorv on tühi.
                <?= Html::a('Alusta ostmist siit', Url::to(['/products']), ['class' => 'alert-link']) ?>.
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$this->registerJs(<<<JS
$('.cart-qty-change').on('click', function() {
    var lineId = $(this).data('line-id');
    var action = $(this).data('action');
    var quantitySpan = $(this).closest('.d-flex').find('.cart-quantity');
    var currentRow = $(this).closest('tr');

    $.ajax({
        url: '/cart/update-quantity',
        type: 'POST',
        data: { line_id: lineId, action: action, _csrf: yii.getCsrfToken() },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#shopping-cart-qty').text(response.totalQty);
                if (response.removed) {
                    currentRow.fadeOut('fast', function() {
                        $(this).remove();
                        if (response.totalPrice !== undefined) {
                            $('tfoot td:nth-child(5) strong').text(response.totalPrice);
                        }
                        if (response.cartEmpty) {
                            $('.cart-view').html('<div class="alert alert-info"><i class="bi bi-info-circle me-2"></i> Teie ostukorv on tühi.</div>');
                        }
                    });
                } else {
                    quantitySpan.text(response.quantity);
                    if (response.itemTotalPrice !== undefined) {
                        currentRow.find('td:nth-child(5)').text(response.itemTotalPrice);
                    }
                    if (response.totalPrice !== undefined) {
                        $('#totalPrice').text(response.totalPrice);
                    }
                }
            } else {
                alert("Viga ostukorvi koguse uuendamisel.");
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX error:", error);
            alert("Viga ostukorvi koguse muutmisel.");
        }
    });
});

$('.cart-remove-item').on('click', function() {
    var lineId = $(this).data('line-id');
    var currentRow = $(this).closest('tr');

    $.ajax({
        url: '/cart/remove-item-from-cart',
        type: 'POST',
        data: { line_id: lineId, _csrf: yii.getCsrfToken() },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                currentRow.fadeOut('fast', function() {
                    $(this).remove();
                    $('#shopping-cart-qty').text(response.itemQuantity);
                    if (response.totalPrice !== undefined) {
                        $('#totalPrice').text(response.totalPrice);
                    }
                    if (response.cartEmpty) {
                        $('.cart').html('<div class="alert alert-info"><i class="bi bi-info-circle me-2"></i> Teie ostukorv on tühi.</div>');
                    }
                });
            } else {
                alert("Viga toote ostukorvist eemaldamisel.");
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX error:", error);
            alert("Viga toote ostukorvist eemaldamisel.");
        }
    });

});

$('#emptyShoppingCart').on('click', function() {
    $.ajax({
        url: '/cart/empty-shopping-cart',
        type: 'POST',
        data: {_csrf: yii.getCsrfToken() },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#shopping-cart-table tbody').empty();
                $('#shopping-cart-qty').text(0);
                if (response.cartEmpty) {
                    $('.cart').html('<div class="alert alert-info"><i class="bi bi-info-circle me-2"></i> Teie ostukorv on tühi.</div>');
                }
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX error:", error);
            alert("Viga ostukorvi tühjendamisel.");
        }
    })
})
JS
);
?>