<?php
/**
 * @var $this \yii\web\View
 * @var $model \fgh151\media\models\MediaFolder
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="media-folder-create">
    <?php $form = ActiveForm::begin([]) ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= Html::submitButton('save', ['class' => 'btn btn-success']) ?>
    <?php ActiveForm::end() ?>
</div>
