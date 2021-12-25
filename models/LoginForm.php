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
//            [['email'], 'trim'],
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
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 : 0);
        }
        return false;
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
