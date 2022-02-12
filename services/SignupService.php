<?php

namespace app\services;

use Symfony\Component\Yaml\Exception\RuntimeException;
use Yii;
use app\models\SignupForm;
use app\models\User;

class SignupService
{

    public function signup(SignupForm $model)
    {
        $user = new User();
        $user->name = $model->name;
        $user->setPassword($model->password);
        $user->email = $model->email;
        $user->email_confirm_token = Yii::$app->security->generateRandomString();
        $user->status = User::STATUS_WAIT;

        if (!$user->save()) {
            throw new RuntimeException('Saving error.');
        }

        return $user;
    }


    public function sentEmailConfirm(User $user)
    {
        $email = $user->email;
        $sent = Yii::$app->mailer
            ->compose(
                '@app/mail/text',
                ['user' => $user,]
            )
            ->setTo($email)
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setSubject('Confirmation of registration')
            ->send();

        if (!$sent) {
            throw new RuntimeException('Sending error.');
        }
    }


    public function confirmation($tkn): void
    {
        if (empty($tkn)) {
            throw new \DomainException('Empty confirm token.');
        }

        $user = User::findOne(['email_confirm_token' => $tkn]);
        if (!$user) {
            throw new \DomainException('User is not found.');
        }

        $user->email_confirm_token = null;
        $user->status = User::STATUS_ACTIVE;
        if (!$user->save()) {
            throw new RuntimeException('Saving error.');
        }

        if (!Yii::$app->getUser()->login($user)) {
            throw new RuntimeException('Error authentication.');
        }
    }

}