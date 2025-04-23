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
        $extension = $info['extension']; // get the extension of the file
        $extType = array('jpg','jpe','jpeg','png', 'webp');

        // extension checking
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

        // image type checking
        $check = getimagesize($photo->tempName);
        if($check !== false) {
            // NOTE (Caupo 10.01.2017): File on image.
        } else {
            Yii::trace(VarDumper::dumpAsString("File is not image"));
            return false;
        }

        // resolution checking
        if($width <= 200 || $height <= 200) {
            Yii::trace(VarDumper::dumpAsString("File size too small"));
            return false;
        }

        if($photo->error) {
            Yii::trace(VarDumper::dumpAsString("Upload tiggered the error: ".$photo->error));
            return false;
        }
        if($photo->size > (20000000)) //can't be larger than 20 MB
        {
            Yii::trace(VarDumper::dumpAsString("File cannot be bigger than 20MB"));
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

    public static function ImageSize($filename) {
        $size = getimagesize($filename);
        LogUtil::log("size");
        LogUtil::log($size);
        return [$size[0], $size[1]];
    }
}