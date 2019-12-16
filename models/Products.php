<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $ProductId
 * @property string $ProductName
 * @property int $Price
 * @property bool $Status
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ProductName', 'Price'], 'required'],
            [['Price'], 'integer'],
            [['Status'], 'boolean'],
            [['ProductName'], 'string', 'max' => 20],
            [['ProductName'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ProductId' => 'Product ID',
            'ProductName' => 'Product Name',
            'Price' => 'Price',
            'Status' => 'Status',
        ];
    }
}
