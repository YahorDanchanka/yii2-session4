<?php

namespace backend\controllers;

use common\models\OrderItem;
use yii\rest\ActiveController;

class OrderItemController extends ActiveController
{
    public $modelClass = OrderItem::class;
}
