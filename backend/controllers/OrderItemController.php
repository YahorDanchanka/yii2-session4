<?php

namespace backend\controllers;

use common\models\OrderItem;
use yii\db\Query;

class OrderItemController extends BaseController
{
    public $modelClass = OrderItem::class;

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['prepareSearchQuery'] = function (Query $query) {
            $query->leftJoin('orders', 'orders.ID = orderitems.OrderID');
            $query->orderBy('orders.Date ASC, orders.TransactionTypeID ASC');
            return $query;
        };

        return $actions;
    }
}
