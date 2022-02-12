<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
mihaildev\elfinder\Assets::noConflict($this);

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <!--    --><? //= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

<!--    --><?//= $form->field($model, 'content')->widget(CKEditor::className(), [
//
//        'editorOptions' => [
//            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
//            'inline' => false, //по умолчанию false
//        ],
//
//    ]); ?>

    <?= $form->field($model, 'content')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions(['elfinder'],['options'=>['height'=>2000]]),
    ]); ?>

    <!--    --><? //= $form->field($model, 'description')->widget(CKEditor::className(), [
    //        'editorOptions' => ElFinder::ckeditorOptions('elfinder', []),
    //    ]);
    //    ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    <!--    --><? //= $form->field($model, 'description')->widget(CKEditor::className(), [
    //        'editorOptions' => [
    //            'preset' => 'basic', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
    //            'inline' => false, //по умолчанию false
    //        ],
    //    ]);
    //    ?>

    <!--    --><? //= $form->field($model, 'date')->textInput() ?>

    <!--    --><? //= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>
    <!---->
    <!--    --><? //= $form->field($model, 'viewed')->textInput() ?>
    <!---->
    <!--    --><? //= $form->field($model, 'user_id')->textInput() ?>
    <!---->
    <!--    --><? //= $form->field($model, 'status')->textInput() ?>
    <!---->
    <!--    --><? //= $form->field($model, 'category_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
