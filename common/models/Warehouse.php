<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "warehouses".
 *
 * @property int $ID
 * @property string $Name
 *
 * @property Order[] $sourceOrders
 * @property Order[] $destinationOrders
 */
class Warehouse extends ActiveRecord
{
    public static function tableName()
    {
        return 'warehouses';
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

    public function getSourceOrders(): ActiveQuery
    {
        return $this->hasMany(Order::class, ['SourceWarehouseID' => 'ID']);
    }

    public function getDestinationOrders(): ActiveQuery
    {
        return $this->hasMany(Order::class, ['DestinationWarehouseID' => 'ID']);
    }
}
