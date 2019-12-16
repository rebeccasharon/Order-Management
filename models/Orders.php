<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $OrderId
 * @property int $UserId
 * @property int $ProductId
 * @property string $dDate
 * @property int $Quantity
 * @property int $Total
 */
class Orders extends \yii\db\ActiveRecord
{
    public $name, $InputSearch;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['UserId', 'ProductId', 'Quantity'], 'required'],
            [['UserId', 'ProductId', 'Quantity'], 'integer'],
            [['Total'], 'double'],
            [['dDate'], 'safe'],
        ];
    }

    public function getRelation_tableUsers()
    {
        return $this->hasOne(Users::className(), ['UserId' => 'UserId']);
    }

    public function getrelation_tableProduct()
    {
        return $this->hasOne(Products::className(), ['ProductId' => 'ProductId']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'OrderId' => 'Order ID',
            'UserId' => 'User',
            'ProductId' => 'Product',
            'dDate' => 'D Date',
            'Quantity' => 'Quantity',
            'Total' => 'Total',
            'name' => 'Select',
        ];
    }
}
