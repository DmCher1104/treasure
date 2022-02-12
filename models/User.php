<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $password
 * @property int|null $isAdmin
 * @property string|null $photo
 * @property string|null $auth_key
 * @property string|null $email_confirm_token
 * @property string|null $status
 *
 * @property Comment[] $comments
 */
class User extends ActiveRecord implements IdentityInterface
{

    const STATUS_ACTIVE = 1;
    const STATUS_WAIT = 5;
    const STATUS_DELETED = 3;

    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['isAdmin'], 'integer'],
            [['name', 'email', 'password', 'photo'], 'string', 'max' => 255],
            ['status', 'in', 'range' => [self::STATUS_DELETED, self::STATUS_WAIT, self::STATUS_ACTIVE]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'isAdmin' => 'Is Admin',
            'photo' => 'Photo',
            'status' => 'Status',
        ];
    }

    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT,);
    }


    public function create()
    {
        return $this->save(false);
    }

    public function getComments()
    {
        return $this->hasMany(Comment::class, ['user_id' => 'id']);
    }

    public static function findIdentity($id)
    {
        return User::findOne($id);
    }

    public static function findByEmail($email)
    {
        return User::find()->where(['email' => $email])->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement validateAuthKey() method.
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Generates "remember me" authentication key
     * @throws \yii\base\Exception
     */

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

    public static function findByUsername($name)
    {
//        return static::findOne(['username' => $username]);
        return self::findOne(['name' => $name]);
    }
}
