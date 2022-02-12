<?php

namespace app\models;

use Yii;
use yii\base\Model;


class LoginForm extends Model
{
    public $password;
    public $email;
    public $rememberMe = true;

    private $_user = null;

    public function rules()
    {
        return [
            [['password', 'email'], 'required'],
            [['rememberMe'],'boolean'],
            [['email'], 'trim'],
            [['email'], 'email'],
            [['password'], 'validatePassword'],
        ];
    }


    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user ||  !password_verify($this->password, $user->password)) {
                $this->addError($attribute, 'Incorrect email or password.');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {

            $user = $this->getUser();
            if($user->status === User::STATUS_ACTIVE){
                return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
            }
            if($user->status === User::STATUS_WAIT){
                throw new \DomainException('To complete the registration, confirm your email. Check your email.');
            }

        } else {
            return false;
        }
    }

    public  function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;

//        return User::find()->where(['email'=>$this->email])->one();
    }
}
