<?php

namespace app\controllers;


class AboutUsController extends BaseController
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
     * Displays about us page.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
