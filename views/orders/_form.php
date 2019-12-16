<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Users;
use app\models\Products;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Orders */
/* @var $form yii\widgets\ActiveForm */
$Users=Users::find()->where(['UserStatus' => 1])->all();
$Products=Products::find()->where(['Status' => 1])->all();

$UserData=ArrayHelper::map($Users,'UserId','Username');
$ProductData=ArrayHelper::map($Products,'ProductId','ProductName');

?>
<div class="panel panel-default" style="padding: 20px;">
<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'UserId')->dropDownList( $UserData, ['prompt'=>'Select...'] ); ?>

    <?= $form->field($model, 'ProductId')->dropDownList( $ProductData, ['prompt'=>'Select...'] ); ?>

    <?= $form->field($model, 'Quantity')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    </div>    
</div>
