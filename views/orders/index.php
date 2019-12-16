<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
//use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
$listData = ['All Time', 'Last 7 days', 'Today'];
$model->name = $selected;

?>

<?php if (Yii::$app->session->hasFlash('Success')): ?>
    <div class="alert alert-success alert-dismissable">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <h4><i class="icon fa fa-check"></i>Saved!</h4>
         <?= Yii::$app->session->getFlash('Success') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('Failed')): ?>
    <div class="alert alert-danger alert-dismissable">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <h4><i class="icon fa fa-check"></i>Error!</h4>
         <?= Yii::$app->session->getFlash('Failed') ?>
    </div>
<?php endif; ?>

<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Orders', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="orders-form" >
    <div class="panel panel-default">
        <table width=100% style="margin: 10px;">
            <?php $form = ActiveForm::begin(
            ['layout' => 'horizontal']
            ); ?>
                <tr>
                    <td>
                        <?= $form->field($model, 'name')->dropDownList(  $listData,  ['prompt'=>'Select Duration..']); ?> </td>

                        <td><?= $form->field($model, 'InputSearch')->textInput(['placeholder' => 'enter search term....', 'value' => $input]) ?> </td>

                        <td><div class="form-group">
                            <?= Html::submitButton('Search', ['class' => 'btn btn-success']) ?>
                        </div> </td>
                </tr>

            <?php ActiveForm::end(); ?>
        </table>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'showFooter'=>true,
    
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'OrderId',
             ['attribute' => 'UserId',
             'value'     => function ($data) {
              return $data->relation_tableUsers->Username;
            },
             ],
            ['attribute' => 'ProductId',
             'value'     => function ($data) {
              return $data->relation_tableProduct->ProductName;
            },
             ],
             ['label' => 'Price',
             'value'     => function ($data) {
                return $data->relation_tableProduct->Price . " EUR";
            },
             ],
            'Quantity',
            ['attribute' => 'Total',
             'value'     => function ($data) {
              return $data->Total . " EUR" ;
            },
             ],
            'dDate',
            
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Action', 
                'headerOptions' => ['width' => '80'],
                'template' => '{update} {delete}{link}',
            ],
        ],
    ]); ?>


</div>
