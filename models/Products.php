<?php

namespace app\models;

use Yii;
use caupohelvik\yii2rbac\models\User;
use yii\helpers\VarDumper;
use app\helpers\ImageHelper;
/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property int $category_id
 * @property string|null $img_path
 * @property string|null $img_extension
 * @property string $width
 * @property string $length
 * @property string $thickness
 * @property string $wood_type
 * @property float $price
 * @property string $price_type
 * @property string $img_path
 * @property string $img_extension
 * @property User $createdBy
 * @property string $created_at
 * @property ProductLines[] $productLines
 */
class Products extends \yii\db\ActiveRecord
{
    public $width = [];
    public $length = [];
    public $thickness = [];
    public $woodType = [];
    public $price = [];
    public $priceType = [];

    public $img_path = [];

    public $img_extension = [];

    public $imageFile;
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
            ['length', 'each', 'rule' => ['string']],
            ['thickness', 'each', 'rule' => ['string']],
            ['woodType', 'each', 'rule' => ['string']],
            ['price', 'each', 'rule' => ['number']],
            ['priceType', 'each', 'rule' => ['string']],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'wrongExtension' => 'Lubatud failitüübid on: png, jpg, jpeg', 'maxFiles' => 20]
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
            'width' => 'Laius',
            'length' => 'Pikkus',
            'thickness' => 'Paksus',
            'woodType' => 'Materjali tüüp',
            'price' => 'Hind',
            'priceType' => 'Hinna tüüp',
            'img_path' => 'Img Path',
            'img_extension' => 'Img Extension',
        ];
    }

    private function getHash() {
        if($this->img_path) return $this->img_path;

        return Yii::$app->security->generateRandomString(16);
    }

    public function upload() {
        //print_r($this->imageFile); 
        if(!$this->imageFile) {
            Yii::trace(VarDumper::dumpAsString("Image was not given"));
            return false;
        }
        foreach ($this->imageFile as $formIndex => $image) {
            $productLines = $this->productLines[$formIndex];
            $hash = $this->getHash();
            $extension = pathinfo($image->name, PATHINFO_EXTENSION);

            list($width, $height) = getimagesize($image->tempName);
            if(!ImageHelper::CheckImage($image, $width, $height)) {
                return;
            }
            if ($productLines->img_path) {
                $oldFilename = "$productLines->img_path.$productLines->img_extension";
                $this->deleteImage($oldFilename);
            }
            if($productLines->img_path != $hash) {
                $productLines->img_path = $hash;
                Yii::$app->db->createCommand()->update('product_lines', ['img_path' => $hash], ["id" => $productLines->id])->execute();
            }
            Yii::$app->db->createCommand()->update('product_lines', ['img_extension' => $extension], ["id" => $productLines->id])->execute();
            $imageFolder = $this->getImagesDirectory();
            if(!file_exists($imageFolder)) {
                mkdir($imageFolder, 0777);
            }

            $path = $imageFolder."/".$hash."." .$extension;

            move_uploaded_file($image->tempName, $path);

            ImageHelper::Resize($width, $height, $path);

            
        }
        return true;
    }

    public function getImagesDirectory() {
        $dir = self::getImagesDir();
        return "$dir/$this->id";
    }

    public static function getImagesDir() {
        $dir = Yii::getAlias('@webroot');
        if (!file_exists("$dir/files/products")) {
            mkdir("$dir/files/products", 0777, true);
        }
        return "$dir/files/products";
    }

    public function deleteImage($filename) {
        $dir = $this->getImagesDirectory();
        $file = "$dir/$filename";
        if (!empty($filename)) {
            if (file_exists($file)) {
                if (unlink($file)) {
                    return true;
                } else {
                    Yii::error("Failed to unlink image");
                    return false;
                }
            } else {
                return true;
            }
        } else {
            return true;
        }
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

    public function afterSave($insert, $changedAttributes)
    {
        $this->upload();

        if (parent::afterSave($insert, $changedAttributes)) {
            return true;
        }
        return false;
    }

    public function loadProductLines()
    {
        foreach($this->productLines as $key => $line) {
            $this->width[$key] = $line->width;
            $this->length[$key] = $line->length;
            $this->thickness[$key] = $line->thickness;
            $this->woodType[$key] = $line->wood_type;
            $this->price[$key] = $line->price;
            $this->priceType[$key] = $line->price_type;
        }
    }

    public function SaveBundle() {
        if ($this->save()) {
            $this->saveProductLines();
            return true;
        }
        return false;
    }

    public function saveProductLines()
    {
        $existingProductLines = ProductLines::find()->where(['product_id' => $this->id])->all();
        $existingProductLinesByKey = array_values($existingProductLines);

        foreach ($this->width as $key => $productLine) {
            $width = $this->width[$key];
            $length = $this->length[$key];
            $thickness = $this->thickness[$key];
            $woodType = $this->woodType[$key];
            $price = $this->price[$key];
            $priceType = $this->priceType[$key];

            if (isset($existingProductLinesByKey[$key])) {
                $productLines = $existingProductLinesByKey[$key];
                $productLines->width = $width;
                $productLines->length = $length;
                $productLines->thickness = $thickness;
                $productLines->wood_type = $woodType;
                $productLines->price = $price;
                $productLines->price_type = $priceType;

                if (!$productLines->save()) {
                    Yii::$app->session->setFlash('error', 'Array is empty');
                }
            } else {
                $item = new ProductLines();
                $item->product_id = $this->id;
                $item->width = $width;
                $item->length = $length;
                $item->thickness = $thickness;
                $item->wood_type = $woodType;
                $item->price = $price;
                $item->price_type = $priceType;

                if (!$item->save()) {
                    Yii::$app->session->setFlash('error', 'Array is empty');
                }
            }
            //$this->upload();
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
