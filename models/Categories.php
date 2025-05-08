<?php

namespace app\models;

use Yii;
use yii\helpers\VarDumper;
use app\helpers\ImageHelper;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name
 * @property int $position
 * @property string|null $img_path
 * @property string|null $img_extension
 * @property int $created_by
 * @property string $created_at
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */

    public $imageFile;

    public function rules()
    {
        return [
            [['name', 'position'], 'required'],
            [['position'], 'integer'],
            [['name', 'img_path'], 'string', 'max' => 255],
            [['img_extension'], 'string', 'max' => 8],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'wrongExtension' => 'Lubatud failitüübid on: png, jpg, jpeg']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nimetus',
            'position' => 'Järjekord',
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
        $hash = $this->getHash();
        $extension = pathinfo($this->imageFile->name, PATHINFO_EXTENSION);

        list($width, $height) = getimagesize($this->imageFile->tempName);
        if(!ImageHelper::CheckImage($this->imageFile, $width, $height)) {
            return;
        }
        if ($this->img_path) {
            $this->deleteImage();
        }
        if($this->img_path != $hash) {
            $this->img_path = $hash;
            Yii::$app->db->createCommand()->update('categories', ['img_path' => $hash], ["id" => $this->id])->execute();
        }
        Yii::$app->db->createCommand()->update('categories', ['img_extension' => $extension], ["id" => $this->id])->execute();
        $imageFolder = $this->getImagesDirectory();
        if(!file_exists($imageFolder)) {
            mkdir($imageFolder, 0755);
        }

        $path = $imageFolder."/".$hash."." .$extension;

        move_uploaded_file($this->imageFile->tempName, $path);

        ImageHelper::Resize($width, $height, $path);

        return true;
    }

    public function getImagesDirectory() {
        $dir = self::getImagesDir();
        return "$dir/$this->id";
    }

    public static function getImagesDir() {
        $dir = Yii::getAlias('@webroot');
        if (!file_exists("$dir/files/categories")) {
            mkdir("$dir/files/categories", 0755, true);
        }
        return "$dir/files/categories";
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

    public function afterSave($insert, $changedAttributes)
    {
        $this->upload();

        if (parent::afterSave($insert, $changedAttributes)) {
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     * @return CategoriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoriesQuery(get_called_class());
    }
}
