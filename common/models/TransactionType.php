<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "transactiontypes".
 *
 * @property int $ID
 * @property string $Name
 *
 * @property Order[] $orders
 */
class TransactionType extends ActiveRecord
{
    public static function tableName()
    {
        return 'transactiontypes';
    }

    public function rules()
    {
        return [
            [['Name'], 'required'],
            [['Name'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Name' => 'Name',
        ];
    }

    public function getOrders(): ActiveQuery
    {
        return $this->hasMany(Order::class, ['TransactionTypeID' => 'ID']);
    }
}
