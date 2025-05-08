<?php

namespace app\helpers;

use app\models\LogUtil;
use Yii;
use Imagine\Image\Box;
use yii\helpers\VarDumper;
use yii\imagine\Image;

class ImageHelper {
    public static function CheckImage($photo, $width, $height) {

        $extensionCorrect = false;
        $info = pathinfo($photo->name);
        $extension = strtolower($info['extension']);
        $extType = array('jpg','jpe','jpeg','png', 'webp');
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp'];

        foreach ($extType as $key => $type) {
            if($type == $extension) {
                $extensionCorrect = true;
                break;
            }
        }
        if(!$extensionCorrect) {
            Yii::trace(VarDumper::dumpAsString("File extension invalid"));
            return false;
        }
        $check = getimagesize($photo->tempName);
        if($check !== false) {

        } else {
            Yii::trace(VarDumper::dumpAsString("File is not image"));
            return false;
        }
        if($width <= 200 || $height <= 200) {
            Yii::trace(VarDumper::dumpAsString("File size too small"));
            return false;
        }
        if($photo->error) {
            Yii::trace(VarDumper::dumpAsString("Upload tiggered the error: ".$photo->error));
            return false;
        }
        if($photo->size > (20000000))
        {
            Yii::trace(VarDumper::dumpAsString("File cannot be bigger than 20MB"));
            return false;
        }
        if (!in_array($photo->type, $allowedMimeTypes)) {
            Yii::trace(VarDumper::dumpAsString("Invalid MIME type: " . $photo->type));
            return false;
        }
        return true;
    }

    public static function Resize($width, $height, $path)
    {
        $maxWidth = 480;
        $maxHeight = 320;

        if($width > $maxWidth || $height > $maxHeight) {
            $imagine = Image::getImagine();
            $image = $imagine->open($path);
            $image = $image->thumbnail(new Box($maxWidth, $maxHeight));
            $image->save();
        }
    }

    public static function CreateThumb($width, $height, $sourcePath, $destinationPath)
    {
        $maxWidth = 480;
        $maxHeight = 320;

        if($width > $maxWidth || $height > $maxHeight) {
            $imagine = Image::getImagine();
            $image = $imagine->open($sourcePath);
            $image = $image->thumbnail(new Box($maxWidth, $maxHeight));
            $image->save($destinationPath);
        }
    }

    public static function ImageSize($filename) {
        $size = getimagesize($filename);
        return [$size[0], $size[1]];
    }
}