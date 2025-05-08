<?php

namespace app\controllers;

use app\controllers\BaseController;
use app\models\Categories;


class SiteController extends BaseController
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $categories = Categories::find()->orderBy('position')->limit(4)->all();

        return $this->render('index', [
            'categories' => $categories
        ]);
    }
}
