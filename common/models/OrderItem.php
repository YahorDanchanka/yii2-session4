<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "orderitems".
 *
 * @property int $ID
 * @property int $OrderID
 * @property int $PartID
 * @property string|null $BatchNumber
 * @property float $Amount
 *
 * @property Order $order
 * @property Part $part
 */
class OrderItem extends ActiveRecord
{
    public static function tableName()
    {
        return 'orderitems';
    }

    public function rules()
    {
        return [
            [['OrderID', 'PartID', 'Amount'], 'required'],
            [['OrderID', 'PartID'], 'integer'],
            [['Amount'], 'number'],
            [['BatchNumber'], 'string', 'max' => 50],
            [['OrderID'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['OrderID' => 'ID']],
            [['PartID'], 'exist', 'skipOnError' => true, 'targetClass' => Part::class, 'targetAttribute' => ['PartID' => 'ID']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'OrderID' => 'Order ID',
            'PartID' => 'Part ID',
            'BatchNumber' => 'Batch Number',
            'Amount' => 'Amount',
        ];
    }

    public function extraFields()
    {
        return ['order', 'part'];
    }

    public function getOrder(): ActiveQuery
    {
        return $this->hasOne(Order::class, ['ID' => 'OrderID']);
    }

    public function getPart(): ActiveQuery
    {
        return $this->hasOne(Part::class, ['ID' => 'PartID']);
    }
}
