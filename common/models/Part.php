<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "parts".
 *
 * @property int $ID
 * @property string $Name
 * @property int|null $EffectiveLife
 * @property int|null $BatchNumberHasRequired
 * @property int|null $MinimumAmount
 *
 * @property OrderItem[] $orderItems
 */
class Part extends ActiveRecord
{
    public static function tableName()
    {
        return 'parts';
    }

    public function rules()
    {
        return [
            [['Name'], 'required'],
            [['EffectiveLife', 'BatchNumberHasRequired', 'MinimumAmount'], 'integer'],
            [['Name'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Name' => 'Name',
            'EffectiveLife' => 'Effective Life',
            'BatchNumberHasRequired' => 'Batch Number Has Required',
            'MinimumAmount' => 'Minimum Amount',
        ];
    }

    public function extraFields()
    {
        return ['orderItems'];
    }

    public function getOrderItems(): ActiveQuery
    {
        return $this->hasMany(OrderItem::class, ['PartID' => 'ID']);
    }
}
