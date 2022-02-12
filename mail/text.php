<?php

/* @var $user app\models\User */

use yii\helpers\Html;

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['signup/signup-confirm', 'tkn' => $user->email_confirm_token]);
?>
<div class="password-reset">
    <span style="background-color: #0a73bb">Hello, <?= Html::encode($user->name); ?>!</span>
    <br>
    <span>Follow the link below to confirm your email: <?= Html::a(Html::encode($confirmLink), $confirmLink); ?></span>
</div>

