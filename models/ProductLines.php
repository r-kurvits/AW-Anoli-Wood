<?php

namespace app\models;

use Yii;
use app\models\Products;
use caupohelvik\yii2rbac\models\User;

/**
 * This is the model class for table "product_lines".
 *
 * @property int $id
 * @property int $product_id
 * @property string $width
 * @property string $length
 * @property string $thickness
 * @property string $wood_type
 * @property float $price
 * @property string $price_type
 * @property int $created_by
 * @property string $created_at
 * @property User $createdBy
 */
class ProductLines extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_lines';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'width', 'thickness', 'wood_type', 'price', 'price_type'], 'required'],
            [['product_id', 'created_by'], 'integer'],
            [['price'], 'number'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['created_at'], 'safe'],
            [['width', 'thickness', 'wood_type', 'length'], 'string', 'max' => 255],
            [['price_type'], 'string', 'max' => 32],
            [['img_path'], 'string', 'max' => 255],
            [['img_extension'], 'string', 'max' => 8],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Toode',
            'width' => 'Laius',
            'length' => 'Pikkus',
            'thickness' => 'Paksus',
            'woodType' => 'Materjali tüüp',
            'price' => 'Hind',
            'priceType' => 'Hinna tüüp',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Products::class, ['id' => 'product_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductLinesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductLinesQuery(get_called_class());
    }

    public function beforeSave($insert) {
        if($this->isNewRecord) {
            $this->created_at = date('Y-m-d H:i:s');
            $this->created_by = Yii::$app->user->identity->id;
        }

        return parent::beforeSave($insert);
    }
}
