<?php

namespace app\controllers;

use app\models\Categories;
use Yii;
use app\models\Products;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use app\models\ProductLines;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $categories = Categories::find()->orderBy('position')->all();
        $products = [];

        foreach ($categories as $category) {
            $prod = Products::find()->where(['category_id' => $category->id])->all();
            $products[$category->id] = $prod;
        }

        return $this->render('index', [
            'categories' => $categories,
            'products' => $products
        ]);
    }

    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $productLinesDataProvider = new ActiveDataProvider([
            "query" => ProductLines::find()->where(["=", 'product_id', $id])
        ]);
        return $this->render('view', [
            'model' => $model,
            'productLinesDataProvider' => $productLinesDataProvider
        ]);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Products();
        if ($model->load(Yii::$app->request->post()) && $model->SaveBundle()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load(Yii::$app->request->post()) && $model->SaveBundle()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $model->loadProductLines();
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionGetProductLinesForm($inputIndex) {
        $model = new Products();
        return $this->renderPartial('/product-lines/_form', [
            'model' => $model,
            'form' => ActiveForm::begin(),
            'index' => $inputIndex
        ]);
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = Products::find()
            ->where(['products.id' => $id])
            ->joinWith(["productLines"])
            ->one();

        if ($model !== null) {
            return $model;
        }
        /*if (($model = Products::findOne($id)) !== null) {
            return $model;
        }*/

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
