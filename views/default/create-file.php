<?php
/**
 * @var $this \yii\web\View
 * @var $model \fgh151\media\models\MediaFile
 */
?>

<div class="">
    <?php $form = \yii\widgets\ActiveForm::begin([])?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'upload')->fileInput() ?>

    <?= \yii\helpers\Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    <?php \yii\widgets\ActiveForm::end() ?>
</div>
