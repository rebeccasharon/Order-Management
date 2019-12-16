<?php

namespace app\controllers;

use Yii;
use app\models\Orders;
use app\models\OrdersSearch;
use app\models\Products;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $startdate = '';
        $enddate = '';
        $selected = 0;
        $inputsearch = '';
        //print_r($_REQUEST); exit;
        if (isset($_REQUEST['Orders']['name']) &&  isset($_REQUEST['Orders']['InputSearch']))
        {
            $inputsearch = $_REQUEST['Orders']['InputSearch'];
            
            if ($_REQUEST['Orders']['name'] == 1)
            {
                $startdate = date('Y-m-d', strtotime('-7 days'));
                $enddate = date('Y-m-d');
                $selected = 1;
            }
            elseif($_REQUEST['Orders']['name'] == 2)
            {
                $startdate = date('Y-m-d');
                $enddate = date('Y-m-d');
                $selected = 2;
            }
            else
            {
                $startdate = '';
                $enddate = '';
                $selected = 0;
            }
        }
        $model = new Orders();
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'selected' => $selected,
            'input' => $inputsearch,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Orders model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //print_r($_REQUEST['Orders']);
        $model = new Orders();

        if(isset($_REQUEST['Orders']))
        {
            $ProductPrice = Products::find()
            ->where(['ProductId' => $_REQUEST['Orders']['ProductId']])
            ->one();
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) 
        {
            if ($_REQUEST['Orders']['Quantity'] >= 3)
            {
                $price = $_REQUEST['Orders']['Quantity'] * $ProductPrice['Price'];
                $DiscountPrice = ($price * 20 ) / 100;
                $model->Total = $price - $DiscountPrice;
            }
            else
            {
                $model->Total = $_REQUEST['Orders']['Quantity'] * $ProductPrice['Price'];
            }

            $model->save();
            Yii::$app->session->setFlash('Success',"Order Created successfully");
            return $this->redirect(['index']);
        }
        else
        {
            Yii::$app->session->setFlash('Failed',"Technical issue occurred. Please try again later");
        }
        $errors = $model->errors;
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if(isset($_REQUEST['Orders']))
        {
            $ProductPrice = Products::find()
            ->where(['ProductId' => $_REQUEST['Orders']['ProductId']])
            ->one();
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) 
        {
            if ($_REQUEST['Orders']['Quantity'] >= 3)
            {
                $price = $_REQUEST['Orders']['Quantity'] * $ProductPrice['Price'];
                $DiscountPrice = ($price * 20 ) / 100;
                $model->Total = $price - $DiscountPrice;
            }
            else
            {
                $model->Total = $_REQUEST['Orders']['Quantity'] * $ProductPrice['Price'];
            }
            $model->save();
            Yii::$app->session->setFlash('Success',"Order Details Updated successfully");
            $errors = $model->errors;
            //print_r($errors);exit;
            return $this->redirect(['index']);
        }
        else
        {
            Yii::$app->session->setFlash('Failed',"Technical issue occurred. Please try again later");
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Orders model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
