<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $UserId
 * @property string $Username
 * @property bool $UserStatus
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Username'], 'required'],
            [['UserStatus'], 'boolean'],
            [['Username'], 'string', 'max' => 20],
            [['Username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'UserId' => 'User ID',
            'Username' => 'Username',
            'UserStatus' => 'User Status',
        ];
    }
}
