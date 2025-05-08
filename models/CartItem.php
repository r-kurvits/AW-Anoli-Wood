<?php

use yii\mongodb\ActiveRecord;

class CartItem extends ActiveRecord
{
    public static function collectionName()
    {
        return 'shopping_cart';
    }

    public function attributes()
    {
        return ['_id', 'line_id', 'quantity', 'added_at'];
    }
}
?>