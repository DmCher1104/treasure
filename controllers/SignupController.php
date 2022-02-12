<?php

namespace app\controllers;

use app\models\SignupForm;
use app\services\SignupService;
use PHPUnit\Util\Exception;
use Symfony\Component\Yaml\Exception\RuntimeException;
use Yii;
use yii\web\Controller;

class SignupController extends Controller
{
    public function actionSignup()
    {
        $model = new SignupForm();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $signupService = new SignupService();

            try{
                $user = $signupService->signup($model);
                Yii::$app->session->setFlash('success', 'Check your email to confirm the registration.');
                $signupService->sentEmailConfirm($user);
                return $this->goHome();
            } catch (RuntimeException $e){
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionSignupConfirm($tkn)
    {

        $signupService = new SignupService();

        try{
            $signupService->confirmation($tkn);
            Yii::$app->session->setFlash('success', 'You have successfully confirmed your registration.');
        } catch (Exception $e){
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->goHome();
    }
}