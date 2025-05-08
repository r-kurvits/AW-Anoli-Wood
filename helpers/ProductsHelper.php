<?php
namespace app\helpers;

use app\models\Categories;
use yii\base\Model;
use Yii;

class ProductsHelper extends Model {

    public static function GetAllCategories () {
        $dataset = Categories::find()->all();
        $categories = [];

        foreach ($dataset as $key => $category) {
            $categories[$category->id] = $category->name;
        }
        return $categories;
    }
}