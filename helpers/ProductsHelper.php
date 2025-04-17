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

    /*public static function GetCategoriesDataset () {
        return [
            "birds" => ["label" => Yii::t("app","Birds")],
            "cats" => ["label" => Yii::t("app","Cats")],
            "chickens" => ["label" => Yii::t("app","Chickens")],
            "dogs" => ["label" => Yii::t("app","Dogs")],
            "ferrets" => ["label" => Yii::t("app","Ferrets")],
            "fishes" => ["label" => Yii::t("app","Fishes")],
            "guinea pigs" => ["label" => Yii::t("app","Guinea pigs")],
            "rabbits" => ["label" => Yii::t("app","Rabbits")],
            "reptiles" => ["label" => Yii::t("app","Reptiles")],
        ];
    }*/
}