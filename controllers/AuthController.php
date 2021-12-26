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
        if (!Yii::$app->user->isGuest){
            return $this->goHome();
        }

        $login_model = new LoginForm();

        if (Yii::$app->request->isPost) {
            if ($login_model->load(Yii::$app->request->post()) && $login_model->login()){
                return $this->goHome();
            }
        }

        return $this->render('login', [
            'login_model' => $login_model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}