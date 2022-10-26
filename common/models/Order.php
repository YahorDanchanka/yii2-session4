<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "orders".
 *
 * @property int $ID
 * @property int $TransactionTypeID
 * @property int|null $SupplierID
 * @property int|null $SourceWarehouseID
 * @property int|null $DestinationWarehouseID
 * @property string $Date
 *
 * @property Warehouse $destinationWarehouse
 * @property OrderItem[] $orderItems
 * @property Warehouse $sourceWarehouse
 * @property Supplier $supplier
 * @property TransactionType $transactionType
 */
class Order extends ActiveRecord
{
    public static function tableName()
    {
        return 'orders';
    }

    public function rules()
    {
        return [
            [['TransactionTypeID', 'Date'], 'required'],
            [['TransactionTypeID', 'SupplierID', 'SourceWarehouseID', 'DestinationWarehouseID'], 'integer'],
            [['Date'], 'safe'],
            [['SourceWarehouseID'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouse::class, 'targetAttribute' => ['SourceWarehouseID' => 'ID']],
            [['DestinationWarehouseID'], 'exist', 'skipOnError' => true, 'targetClass' => Warehouse::class, 'targetAttribute' => ['DestinationWarehouseID' => 'ID']],
            [['SupplierID'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::class, 'targetAttribute' => ['SupplierID' => 'ID']],
            [['TransactionTypeID'], 'exist', 'skipOnError' => true, 'targetClass' => TransactionType::class, 'targetAttribute' => ['TransactionTypeID' => 'ID']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'TransactionTypeID' => 'Transaction Type ID',
            'SupplierID' => 'Supplier ID',
            'SourceWarehouseID' => 'Source Warehouse ID',
            'DestinationWarehouseID' => 'Destination Warehouse ID',
            'Date' => 'Date',
        ];
    }

    public function extraFields()
    {
        return ['transactionType', 'sourceWarehouse', 'destinationWarehouse', 'orderItems'];
    }

    public function getDestinationWarehouse(): ActiveQuery
    {
        return $this->hasOne(Warehouse::class, ['ID' => 'DestinationWarehouseID']);
    }

    public function getOrderItems(): ActiveQuery
    {
        return $this->hasMany(OrderItem::class, ['OrderID' => 'ID']);
    }

    public function getSourceWarehouse(): ActiveQuery
    {
        return $this->hasOne(Warehouse::class, ['ID' => 'SourceWarehouseID']);
    }

    public function getSupplier(): ActiveQuery
    {
        return $this->hasOne(Supplier::class, ['ID' => 'SupplierID']);
    }

    public function getTransactionType(): ActiveQuery
    {
        return $this->hasOne(TransactionType::class, ['ID' => 'TransactionTypeID']);
    }
}
