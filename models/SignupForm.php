<?php

namespace app\models;

use yii\base\Model;

class SignupForm extends Model
{
    public $name;
    public $password;
    public $email;

    public function rules()
    {
        return [
            [['name','password', 'email'], 'required'],
            [['email','name'], 'trim'],
            [['email'], 'email'],
            [['name','email'],'unique', 'targetClass'=>'app\models\User'],
            [['password'],'string', 'min'=>3, 'max'=>255],
            [['name'], 'string', 'min' => 2, 'max' => 255],
            [['email'], 'string', 'max' => 255],
        ];
    }

    public function signup(){
        $user = new User();

        $user->email =$this->email;
        $user->name = $this->name;
        $user->setPassword($this->password);

       return $user->create();
    }

}