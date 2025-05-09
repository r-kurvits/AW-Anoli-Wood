<?php

namespace app\controllers;

use app\models\ProductLines;
use Yii;
use kartik\mpdf\Pdf;
use yii\web\Response;

class PurchaseOrdersController extends BaseController
{
    private $offerCollectionName = 'offers';
    private $_offerCollection;

    private function getMongoDB()
    {
        return Yii::$app->mongodb->getDatabase(Yii::$app->params['mongodb']['databaseName']);
    }

    private function getOfferCollection()
    {
        if ($this->_offerCollection === null) {
            $this->_offerCollection = $this->getMongoDB()->getCollection($this->offerCollectionName);
        }
        return $this->_offerCollection;
    }

    private function loadPurchaseOrdersFromMongoDB()
    {
        $cursor = $this->getOfferCollection()->find();
        $allOrders = $cursor->toArray();
        return $allOrders;
    }

    private function loadPurchaseOrderFromMongoDB($orderId)
    {
        $orderData = $this->getOfferCollection()->findOne(['_id' => $orderId]);
        return $orderData;
    }

    public function getProductLinesDetails($lineId)
    {
        return ProductLines::findOne($lineId);
    }

    public function actionIndex()
    {
        if(Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $purchaseOrders = $this->loadPurchaseOrdersFromMongoDB();
        $purchaseOrdersWithDetails = [];
        if (is_array($purchaseOrders)) {
            foreach ($purchaseOrders as $key => $order) {
                $purchaseOrdersWithDetails[(string)$order['_id']] = [
                    "offerName" => $order['offer_name'],
                    "email" => $order['email'],
                    "totalPrice" => $order['total_price'],
                    "orderComplete" => $order['order_complete'],
                    "createdAt" => $order['created_at']
                ];
            }
            
        }
        return $this->render('index', [
            'purchaseOrdersWithDetails' => $purchaseOrdersWithDetails,
        ]);
    }

    public function actionView($id)
    {
        if(Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $purchaseOrder = $this->loadPurchaseOrderFromMongoDB($id);
        $purchaseOrderWithDetails = [];
        if (is_array($purchaseOrder)) {
            $purchaseOrderWithDetails = [
                "id" => $purchaseOrder['_id'],
                "offerName" => $purchaseOrder['offer_name'],
                "email" => $purchaseOrder['email'],
                "totalPrice" => $purchaseOrder['total_price'],
                "orderComplete" => $purchaseOrder['order_complete'],
                "createdAt" => $purchaseOrder['created_at'],
                "items" => []
            ];
            foreach($purchaseOrder['items'] as $key => $order) {
                $productLines = $this->getProductLinesDetails($order['line_id']);
                $purchaseOrderWithDetails["items"][] = [
                    "name" => $order['name'],
                    "quantity" => $order["quantity"],
                    "price" => $order["price"],
                    "width" => $productLines["width"] ?? null,
                    "length" => $productLines["length"] ?? null,
                    "thickness" => $productLines["thickness"] ?? null,
                    "woodType" => $productLines["wood_type"] ?? null,
                    "priceType" => $productLines["price_type"] ?? null,
                ];
            }
        }
        
        return $this->render('view', [
            'purchaseOrder' => $purchaseOrderWithDetails
        ]);
    }

    public function actionGeneratePdf($id)
    {
        $purchaseOrder = $this->loadPurchaseOrderFromMongoDB($id);
        $purchaseOrderWithDetails = [];
        if (is_array($purchaseOrder)) {
            $purchaseOrderWithDetails = [
                "offerName" => $purchaseOrder['offer_name'],
                "totalPrice" => $purchaseOrder['total_price'],
                "createdAt" => $purchaseOrder['created_at'],
                "items" => []
            ];

            foreach($purchaseOrder['items'] as $key => $order) {
                $productLines = $this->getProductLinesDetails($order['line_id']);
                $purchaseOrderWithDetails["items"][] = [
                    "name" => $order['name'],
                    "quantity" => $order["quantity"],
                    "price" => $order["price"],
                    "width" => $productLines["width"] ?? null,
                    "length" => $productLines["length"] ?? null,
                    "thickness" => $productLines["thickness"] ?? null,
                    "woodType" => $productLines["wood_type"] ?? null,
                    "priceType" => $productLines["price_type"] ?? null,
                ];
            }
        }

        $content = $this->renderPartial('view-pdf', [
            'purchaseOrder' => $purchaseOrderWithDetails,
        ]);

        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $content,
            'filename' => 'Anoli Wood - '.$purchaseOrderWithDetails['offerName'].'.pdf',
            'options' => ['title' => 'Anoli Wood - ' . $purchaseOrderWithDetails['offerName'], 'debug' => true, 'throw_exception' => true],
            'methods' => [
                'SetHeader' => [],
            ]
        ]);
        try {
            return $pdf->render();
        } catch (\Throwable $e) {
            ob_end_clean();
            throw $e;
        }
    }

    public function actionFinishOrder() 
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $this->getOfferCollection()->update(
            ['_id' => $id],
            ['$set' => ['order_complete' => 1, 'updated_at' => time()]],
            ['upsert' => true]
        );
        return ['success' => true, 'message' => 'Ostutellimus lõpetatud'];
    }
}
