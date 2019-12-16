<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Orders;

/**
 * OrdersSearch represents the model behind the search form of `app\models\Orders`.
 */
class OrdersSearch extends Orders
{
    public  $startdate = '';
    public $enddate = '';
    public $inputsearch = '';
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['OrderId', 'UserId', 'ProductId', 'Quantity', 'Total'], 'integer'],
            [['dDate'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Orders::find();
        
        if (isset($_REQUEST['Orders']['name']) &&  isset($_REQUEST['Orders']['InputSearch']))
        {
            $inputsearch = $_REQUEST['Orders']['InputSearch'];

            if ($_REQUEST['Orders']['name'] == 1)
            {
                $startdate = date('Y-m-d', strtotime('-7 days'));
                $enddate = date('Y-m-d');
                $product_ids=Yii::$app->db->createCommand("select ProductId from products where ProductName like '%$inputsearch%'")->queryColumn();
                $user_ids=Yii::$app->db->createCommand("select UserId from users where Username like '%$inputsearch%'")->queryColumn();
                //$ids="(".implode(',' , $product_ids).")";
                $query = Orders::find()->andWhere(['between','dDate',$startdate." 00:00:00", $enddate." 23:59:59"])->andWhere(['in', 'ProductId', $product_ids])->orWhere(['in', 'UserId', $user_ids]);
            }
            elseif($_REQUEST['Orders']['name'] == 2)
            {
                $startdate = date('Y-m-d');
                $enddate = date('Y-m-d');
                $product_ids=Yii::$app->db->createCommand("select ProductId from products where ProductName like '%$inputsearch%'")->queryColumn();
                $user_ids=Yii::$app->db->createCommand("select UserId from users where Username like '%$inputsearch%'")->queryColumn();
                $query = Orders::find()->andWhere(['between','dDate',$startdate." 00:00:00", $enddate." 23:59:59"])->andWhere(['in', 'orders.ProductId',$product_ids])->orWhere(['in', 'UserId', $user_ids]);
            }
            elseif($_REQUEST['Orders']['name'] == 0)
            {
                $product_ids=Yii::$app->db->createCommand("select ProductId from products where ProductName like '%$inputsearch%'")->queryColumn();
                $user_ids=Yii::$app->db->createCommand("select UserId from users where Username like '%$inputsearch%'")->queryColumn();
                $query = Orders::find()->andWhere(['in', 'orders.ProductId',$product_ids])->orWhere(['in', 'UserId', $user_ids]);
            }
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        
        // grid filtering conditions
        $query->andFilterWhere([
            'OrderId' => $this->OrderId,
            'UserId' => $this->UserId,
            'ProductId' => $this->ProductId,
            'dDate' => $this->dDate,
            'Quantity' => $this->Quantity,
            'Total' => $this->Total,
        ]);

        return $dataProvider;
    }
}
