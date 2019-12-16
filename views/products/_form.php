<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="panel panel-default" style="padding: 20px;">
<div class="products-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ProductName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Price')->textInput() ?>

    <?= $form->field($model, 'Status')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
