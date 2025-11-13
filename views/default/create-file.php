<?php
/**
 * @var $this \yii\web\View
 * @var $model \fgh151\media\models\MediaFile
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Залить файл';
?>

<div class="">
    <?php $form = ActiveForm::begin()?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'upload')->fileInput() ?>

    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end() ?>
</div>
