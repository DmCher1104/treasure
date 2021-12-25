<?php

namespace app\controllers;

use app\models\SignupForm;
use Yii;
use yii\web\Controller;

class SignupController extends Controller
{
    public function actionSignup()
    {
        $model = new SignupForm();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->attributes = Yii::$app->request->post('SignupForm');

            if ($model->validate() && $model->signup()) {

                return $this->goHome();
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
}