<?php

namespace app\models;

use Yii;
use caupohelvik\yii2rbac\models\User;

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
 * @property User $createdBy
 * @property ProductLines[] $productLines
 */
class Products extends \yii\db\ActiveRecord
{
    public $width = [];
    public $thickness = [];
    public $woodType = [];
    public $price = [];
    public $priceType = [];
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
            [['name', 'category_id'], 'required'],
            [['category_id', 'created_by'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
            [['name'], 'string', 'max' => 255],
            ['width', 'each', 'rule' => ['string']],
            ['thickness', 'each', 'rule' => ['string']],
            ['woodType', 'each', 'rule' => ['string']],
            ['price', 'each', 'rule' => ['number']],
            ['priceType', 'each', 'rule' => ['string']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Toote nimetus',
            'category_id' => 'Kategooria',
            'img_path' => 'Img Path',
            'img_extension' => 'Img Extension',
        ];
    }

    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    public function getProductLines()
    {
        return $this->hasMany(ProductLines::class, ['product_id' => 'id']);
    }

    public function beforeSave($insert) {
        if($this->isNewRecord) {
            $this->created_at = date('Y-m-d H:i:s');
            $this->created_by = Yii::$app->user->identity->id;
        }

        return parent::beforeSave($insert);
    }

    public function SaveBundle() {
        if ($this->save()) {
            $this->saveProductLines();

            return true;
        }
    }

    public function loadProductLines()
    {
        foreach($this->productLines as $key => $line) {
            $this->width[$key] = $line->width;
            $this->thickness[$key] = $line->thickness;
            $this->woodType[$key] = $line->wood_type;
            $this->price[$key] = $line->price;
            $this->priceType[$key] = $line->price_type;
        }
    }

    public function saveProductLines()
    {
        $existingProductLines = ProductLines::find()->where(['product_id' => $this->id])->all();
        $existingProductLinesByKey = array_values($existingProductLines);

        foreach ($this->width as $key => $productLine) {
            $width = $this->width[$key];
            $thickness = $this->thickness[$key];
            $woodType = $this->woodType[$key];
            $price = $this->price[$key];
            $priceType = $this->priceType[$key];

            if (isset($existingProductLinesByKey[$key])) {
                $productLines = $existingProductLinesByKey[$key];
                $productLines->width = $width;
                $productLines->thickness = $thickness;
                $productLines->wood_type = $woodType;
                $productLines->price = $price;
                $productLines->price_type = $priceType;

                if (!$productLines->save()) {
                    Yii::$app->session->setFlash('error', $times->errors[array_key_first($productLines->errors)] ?? 'Array is empty');
                }
            } else {
                $item = new ProductLines();
                $item->product_id = $this->id;
                $item->width = $width;
                $item->thickness = $thickness;
                $item->wood_type = $woodType;
                $item->price = $price;
                $item->price_type = $priceType;

                if (!$item->save()) {
                    Yii::$app->session->setFlash('error', $item->errors[array_key_first($item->errors)] ?? 'Array is empty');
                }
            }
        }
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
