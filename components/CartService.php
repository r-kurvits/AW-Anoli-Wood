<?php
    namespace app\components;

    use yii\base\Component;
    use Yii;
    
    class CartService extends Component
    {
        private $cartCollectionName = 'shopping_carts';
        private $offerCollectionName = 'offers';
        private $_cartCollection;
        private $_offerCollection;

        protected function getSessionId()
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
    
        protected function loadCartFromMongoDB()
        {
            $sessionId = $this->getSessionId();
            $cartData = $this->getCartCollection()->findOne(['_id' => $sessionId]);
            return $cartData;
        }
    
        public function getCartQuantity()
        {
            $cartQuantity = 0;
            $cartDocument = $this->loadCartFromMongoDB();
            
            if ($cartDocument && isset($cartDocument['items']) && is_array($cartDocument['items'])) {
                foreach ($cartDocument['items'] as $item) {
                    if (isset($item['quantity'])) {
                        $cartQuantity += $item['quantity'];
                    }
                }
            }
            return $cartQuantity;
        }
    }
?>