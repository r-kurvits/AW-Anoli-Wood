<?php

namespace app\controllers;

use app\models\ProductLines;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Html;
use MongoDB\BSON\ObjectID;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class CartController extends BaseController
{
    private $cartCollectionName = 'shopping_carts';
    private $offerCollectionName = 'offers';
    private $_cartCollection;
    private $_offerCollection;

    private function getSessionId()
    {
        return Yii::$app->session->getId();
    }

    private function getMongoDB()
    {
        return Yii::$app->mongodb->getDatabase(Yii::$app->params['mongodb']['databaseName']);
    }

    private function getCartCollection()
    {
        if ($this->_cartCollection === null) {
            $this->_cartCollection = $this->getMongoDB()->getCollection($this->cartCollectionName);
        }
        return $this->_cartCollection;
    }

    private function getOfferCollection()
    {
        if ($this->_offerCollection === null) {
            $this->_offerCollection = $this->getMongoDB()->getCollection($this->offerCollectionName);
        }
        return $this->_offerCollection;
    }

    private function loadCartFromMongoDB()
    {
        $sessionId = $this->getSessionId();
        $cartData = $this->getCartCollection()->findOne(['_id' => $sessionId]);
        return $cartData;
    }

    public function actionAddToCart()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $lineId = Yii::$app->request->post('line_id');

        if ($lineId === null) {
            return ['success' => false, 'message' => 'Toote ID on puudu.'];
        }

        if (Yii::$app->session->isActive === false) {
            Yii::$app->session->open();
        }

        $cartDocument = $this->loadCartFromMongoDB();
        $cartItems = isset($cartDocument['items']) && is_array($cartDocument['items']) ? $cartDocument['items'] : [];

        if (isset($cartItems[$lineId])) {
            $cartItems[$lineId]['quantity']++;
        } else {
            $cartItems[$lineId] = ['line_id' => $lineId, 'quantity' => 1, 'added_at' => time()];
        }

        $this->getCartCollection()->update(
            ['_id' => $this->getSessionId()],
            ['$set' => ['items' => $cartItems, 'updated_at' => time()]],
            ['upsert' => true]
        );

        $cartQuantity = 0;
        foreach ($cartItems as $item) {
            if (isset($item['quantity'])) {
                $cartQuantity += $item['quantity'];
            }
        }

        return ['success' => true, 'message' => 'Toode lisati ostukorvi.', 'cartQuantity' => $cartQuantity];
    }

    public function getProductDetails($lineId)
    {
        return ProductLines::findOne($lineId);
    }

    public function actionViewCart()
    {
        if (Yii::$app->session->isActive === false) {
            Yii::$app->session->open();
        }
        $cart = $this->loadCartFromMongoDB();
        $cartItems = isset($cart['items']) && is_array($cart['items']) ? $cart['items'] : [];
        $cartItemsWithDetails = [];
        if (is_array($cartItems)) {
            foreach ($cartItems as $lineId => $item) {
                if (is_array($item) && isset($item['quantity'])) {
                    $product = $this->getProductDetails($lineId);
                    $cartItemsWithDetails[$lineId] = $item + ['product' => $product];
                } else {
                    Yii::warning("Invalid item structure within cart for line ID: $lineId. Value: " . VarDumper::dumpAsString($item));
                }
            }
        } else {
            Yii::warning("Cart items data is not an array: " . VarDumper::dumpAsString($cartItems));
        }
        return $this->render('view-cart', ['cartItems' => $cartItemsWithDetails]);
    }

    public function actionUpdateQuantity()
{
    Yii::$app->response->format = Response::FORMAT_JSON;
    $lineId = Yii::$app->request->post('line_id');
    $action = Yii::$app->request->post('action');
    $cartDocument = $this->loadCartFromMongoDB();
    $itemQuantity = 0;
    $itemTotalPrice = 0;
    $totalPrice = 0;
    $removed = false;
    $totalQty = 0;
    $cartItems = isset($cartDocument['items']) && is_array($cartDocument['items']) ? $cartDocument['items'] : [];

    if (isset($cartItems[$lineId])) {
        if ($action == 'increase') {
            $cartItems[$lineId]['quantity']++;
        } elseif ($action == 'decrease') {
            $cartItems[$lineId]['quantity']--;
            if ($cartItems[$lineId]['quantity'] <= 0) {
                unset($cartItems[$lineId]);
                $removed = true;
            }
        }
        $this->getCartCollection()->update(
            ['_id' => $this->getSessionId()],
            ['$set' => ['items' => $cartItems, 'updated_at' => time()]],
            ['upsert' => true]
        );

        if (!$removed && isset($cartItems[$lineId])) {
            $itemQuantity = $cartItems[$lineId]['quantity'];
            $productLine = $this->getProductDetails($lineId);
            $itemPrice = $productLine->price;
            $itemTotalPrice = Yii::$app->formatter->asCurrency($itemPrice * $itemQuantity, 'EUR');
        }

        foreach ($cartItems as $cartLineId => $item) {
            if (is_array($item) && isset($item['quantity'])) {
                $currentProductLine = $this->getProductDetails($cartLineId);
                if ($currentProductLine && $currentProductLine->product) {
                    $totalPrice += $currentProductLine->price * $item['quantity'];
                    $totalQty += $item['quantity'];
                }
            }
        }
        $totalPrice = Yii::$app->formatter->asCurrency($totalPrice, 'EUR');

    } else {
        foreach ($cartItems as $cartLineId => $item) {
            if (is_array($item) && isset($item['quantity'])) {
                $totalQty += $item['quantity'];
            }
        }
    }
    return [
        'success' => true, 'message' => 'Kogus uuendatud.', 'cartEmpty' => empty($cartItems), 'quantity' => $itemQuantity, 
        'itemTotalPrice' => $itemTotalPrice, 'totalPrice' => $totalPrice, 'removed' => $removed, 'totalQty' => $totalQty, ];
}

    public function actionRemoveItemFromCart()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $lineId = Yii::$app->request->post('line_id');
        $cartDocument = $this->loadCartFromMongoDB();
        $totalPrice = 0;
        $itemQuantity = 0;
        $cartItems = isset($cartDocument['items']) && is_array($cartDocument['items']) ? $cartDocument['items'] : [];

        if (isset($cartItems[$lineId])) {
            unset($cartItems[$lineId]);
            $this->getCartCollection()->update(
                ['_id' => $this->getSessionId()],
                ['$set' => ['items' => $cartItems, 'updated_at' => time()]],
                ['upsert' => true]
            );

            foreach ($cartItems as $cartLineId => $item) {
                if (is_array($item) && isset($item['quantity'])) {
                    $productLine = $this->getProductDetails($cartLineId);
                    $itemQuantity += $item['quantity'];
                    if ($productLine && $productLine->product) {
                        $totalPrice += $productLine->price * $item['quantity'];
                    }
                }
            }
        }

        if (empty($cartItems)) {
            return ['success' => true, 'message' => 'Ostukorv on tühi', 'cartEmpty' => true, 'totalPrice' => Yii::$app->formatter->asCurrency($totalPrice, 'EUR'), 'itemQuantity' => Html::encode($itemQuantity)];
        } else {
            return ['success' => true, 'message' => 'Toode eemaldati ostukorvist.', 'cartEmpty' => false, 'totalPrice' => Yii::$app->formatter->asCurrency($totalPrice, 'EUR'), 'itemQuantity' => Html::encode($itemQuantity)];
        }
    }

    public function actionSendOffer()
    {
        $cartDocument = $this->loadCartFromMongoDB();
        $offerEmail = Yii::$app->request->post('offer_email');
        if (empty($cartDocument)) {
            Yii::$app->session->setFlash('error', 'Ostukorv on tühi.');
            return $this->redirect(['/']);
        }
        if (!filter_var($offerEmail, FILTER_VALIDATE_EMAIL)) {
            Yii::$app->session->setFlash('error', 'Palun sisestage korrektne e-posti aadress.');
            return $this->redirect(['cart/view-cart']);
        }
        $cartItems = isset($cartDocument['items']) && is_array($cartDocument['items']) ? $cartDocument['items'] : [];
        $cartItemsWithDetails = [];
        $totalPrice = 0;
        foreach ($cartItems as $lineId => $item) {
            $product = $this->getProductDetails($lineId);
            if ($product) {
                $cartItemsWithDetails[] = [
                    'product_id' => $product->id,
                    'line_id' => $lineId,
                    'name' => $product->product->name,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ];
                $totalPrice += $product->price * $item['quantity'];
            }
        }
        $offerNumber = $this->getOfferCollection()->count() + 1;
        $offerName = 'Tellimus ' . $offerNumber;
        $offerData = [
            'offer_name' => $offerName,
            'session_id' => $this->getSessionId(),
            'email' => $offerEmail,
            'items' => $cartItemsWithDetails,
            'total_price' => $totalPrice,
            'order_complete' => 0,
            'created_at' => time(),
        ];
        $this->getOfferCollection()->insert($offerData);
        $transportDsn = 'smtp://localhost:25';
        $transport = Transport::fromDsn($transportDsn);
        $mailer = new Mailer($transport);
        $email = (new Email())
            ->from($offerEmail)
            ->to(Yii::$app->params['adminEmail'])
            ->subject("Uus ostupäring")
            ->html("Tehtud on uus ostupäring:". $offerName);
        try {
            $mailer->send($email);
        } catch (\Throwable $e) {
            Yii::error("Error sending email: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'There was an error sending your message.');
        }
        Yii::$app->session->setFlash('success', 'Teie ostupäring on edastatud!');
        $this->actionEmptyShoppingCart();

        return $this->redirect(['/']);
    }

    public function actionEmptyShoppingCart()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $this->getCartCollection()->remove(['_id' => $this->getSessionId()]);
        return ['success' => true, 'message' => 'Ostukorv on tühi', 'cartEmpty' => true];
    }
}