<?php

namespace app\controllers;

use app\models\LoginForm;
use Yii;
use yii\web\Controller;

class AuthController extends Controller
{
    public bool $enableAutoLogin = false;


        public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            try{
                if($model->login()){
                    return $this->goBack();
                }
            } catch (\DomainException $e){
                Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->goHome();
            }
        }

        return $this->render('login', [
            'login_model' => $model,
        ]);
    }


    public function actionLogout()
    {
        Yii::$app->user->logout(false);

        return $this->goHome();
    }
}