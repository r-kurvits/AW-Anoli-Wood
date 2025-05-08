<?php

namespace app\controllers;

use Yii;
use app\models\ContactForm;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

/**
 * CategoriesController implements the CRUD actions for Categories model.
 */
class ContactController extends BaseController
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
     * Lists all Categories models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {
            $transportDsn = 'smtp://localhost:25';
            $transport = Transport::fromDsn($transportDsn);
            $mailer = new Mailer($transport);

            $email = (new Email())
                ->from($model->email)
                ->to(Yii::$app->params['adminEmail'])
                ->subject($model->subject)
                ->html(nl2br($model->body));
            try {
                $mailer->send($email);
                Yii::$app->session->setFlash('contactFormSubmitted');
            } catch (\Throwable $e) {
                Yii::error("Error sending email: " . $e->getMessage());
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
