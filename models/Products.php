<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property int $category_id
 * @property string|null $img_path
 * @property string|null $img_extension
 * @property string $width
 * @property string $thickness
 * @property string $wood_type
 * @property float $price
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'category_id', 'width', 'thickness', 'wood_type', 'price'], 'required'],
            [['category_id'], 'integer'],
            [['price'], 'number'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['name','img_path', 'width', 'thickness', 'wood_type'], 'string', 'max' => 255],
            [['img_extension'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'img_path' => 'Img Path',
            'img_extension' => 'Img Extension',
            'width' => 'Width',
            'thickness' => 'Thickness',
            'wood_type' => 'Wood Type',
            'price' => 'Price',
        ];
    }

    public function beforeSave($insert) {
        if($this->isNewRecord) {
            $this->created_at = date('Y-m-d H:i:s');
            $this->created_by = Yii::$app->user->identity->id;
        }

        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     * @return ProductsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductsQuery(get_called_class());
    }
}
