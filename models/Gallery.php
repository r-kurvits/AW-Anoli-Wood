<?php

namespace app\models;

use Yii;
use app\helpers\ImageHelper;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "gallery".
 *
 * @property int $id
 * @property string $img_path
 * @property string $img_extension
 * @property int $created_by
 * @property string $created_at
 */
class Gallery extends \yii\db\ActiveRecord
{
    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gallery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_by'], 'integer'],
            [['created_at'], 'safe'],
            [['img_path'], 'string', 'max' => 255],
            [['img_extension'], 'string', 'max' => 8],
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
            'img_path' => 'Img Path',
            'img_extension' => 'Img Extension',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }

    private function getHash() {
        if($this->img_path) return $this->img_path;

        return Yii::$app->security->generateRandomString(16);
    }

    public function upload() {
        if(!$this->imageFile) {
            Yii::trace(VarDumper::dumpAsString("Image was not given"));
            return false;
        }
        foreach ($this->imageFile as $image) {
            $galleryItem = new Gallery();
            $galleryItem->img_path = $galleryItem->getHash();
            $extension = pathinfo($image->name, PATHINFO_EXTENSION);
            $galleryItem->img_extension = $extension;
            $galleryItem->created_by = Yii::$app->user->identity->id;
            $galleryItem->created_at = date('Y-m-d H:i:s');
    
            list($width, $height) = getimagesize($image->tempName);
            if (!ImageHelper::CheckImage($image, $width, $height)) {
                continue;
            }
    
            $imageFolder = $this->getImagesDirectory();
            $thumbFolder = $this->getThumbImagesDirectory();
    
            $path = $imageFolder . "/" . $galleryItem->img_path . "." . $extension;
            $thumbPath = $thumbFolder . "/" . $galleryItem->img_path . "." . $extension;
    
            if ($galleryItem->save()) {
                move_uploaded_file($image->tempName, $path);
                ImageHelper::CreateThumb($width, $height, $path, $thumbPath);
            } else {
                Yii::error("Failed to save gallery image: " . VarDumper::dumpAsString($galleryItem->errors));
            }
        }
        return true;
    }

    public function getImagesDirectory() {
        $dir = self::getImagesDir();
        return "$dir";
    }

    public static function getImagesDir() {
        $dir = Yii::getAlias('@webroot');
        if (!file_exists("$dir/files/gallery")) {
            mkdir("$dir/files/gallery", 0777, true);
        }
        return "$dir/files/gallery";
    }

    public function getThumbImagesDirectory() {
        $dir = self::getThumbDir();
        return "$dir";
    }

    public static function getThumbDir() {
        $dir = Yii::getAlias('@webroot');
        if (!file_exists("$dir/files/gallery/thumb")) {
            mkdir("$dir/files/gallery/thumb", 0777, true);
        }
        return "$dir/files/gallery/thumb";
    }

    public function deleteImage() {
        $dir = $this->getImagesDirectory();
        $file = "$dir/$this->img_path.$this->img_extension";
        if (!empty($this->img_path) && !empty($this->img_extension)) {
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

    public function beforeSave($insert) {
        if($this->isNewRecord) {
            $this->created_at = date('Y-m-d H:i:s');
            $this->created_by = Yii::$app->user->identity->id;
        }

        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     * @return GalleryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GalleryQuery(get_called_class());
    }
}
