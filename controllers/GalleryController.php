<?php

namespace app\controllers;

use app\models\Gallery;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\UploadedFile;

class GalleryController extends BaseController
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
        $images = Gallery::find()->all();

        return $this->render('index', [
            'images' => $images
        ]);
    }

    public function actionCreate()
    {
        if(Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new Gallery();
        if ($this->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->imageFile = UploadedFile::getInstances($model, 'imageFile');
                if ($model->upload()) {
                    return $this->redirect(['index']);
                }
            }
        } else {
            $model->loadDefaultValues();
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
}
