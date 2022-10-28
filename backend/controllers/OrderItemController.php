<?php

namespace backend\controllers;

use common\models\OrderItem;
use yii\base\DynamicModel;
use yii\data\ActiveDataFilter;
use yii\data\Pagination;
use yii\db\Query;
use Yii;

class OrderItemController extends BaseController
{
    public $modelClass = OrderItem::class;

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['prepareSearchQuery'] = function (Query $query) {
            $query->leftJoin('orders', 'orders.ID = orderitems.OrderID');
            $query->orderBy('orders.Date ASC, orders.TransactionTypeID ASC');

            $hasGroup = Yii::$app->request->get('group', false);

            if ($hasGroup) {
                $query->select(['orderitems.*', 'COUNT(*) AS partCount']);
                $query->groupBy(['PartID', 'BatchNumber']);
            }

            return $query;
        };

        $actions['index']['dataFilter'] = [
            'class' => ActiveDataFilter::class,
            'attributeMap' => [
                'orderSourceWarehouseID' => '{{orders}}.[[SourceWarehouseID]]',
                'orderDestinationWarehouseID' => '{{orders}}.[[DestinationWarehouseID]]'
            ],
            'searchModel' => (new DynamicModel(['OrderID', 'orderSourceWarehouseID', 'orderDestinationWarehouseID']))
                ->addRule(['OrderID', 'orderSourceWarehouseID', 'orderDestinationWarehouseID'], 'safe'),
        ];

        $actions['index']['pagination'] = new Pagination(['pageSizeLimit' => [1, 1000]]);

        return $actions;
    }

    public function actionCurrentStockCount(int $warehouseID, int $partID, ?string $batchNumber = null): int
    {
        return OrderItem::find()
            ->leftJoin('orders', 'orders.ID = orderitems.OrderID')
            ->leftJoin('parts', 'parts.ID = orderitems.PartID')
            ->where(['parts.ID' => $partID, 'batchNumber' => $batchNumber])
            ->andWhere(['orders.DestinationWarehouseID' => $warehouseID])
            ->count();
    }

    public function actionReceivedStockCount(int $warehouseID, int $partID, ?string $batchNumber = null): int
    {
        return OrderItem::find()
            ->leftJoin('orders', 'orders.ID = orderitems.OrderID')
            ->leftJoin('parts', 'parts.ID = orderitems.PartID')
            ->where(['parts.ID' => $partID, 'batchNumber' => $batchNumber])
            ->andWhere(['orders.DestinationWarehouseID' => $warehouseID])
            ->orWhere(['orders.SourceWarehouseID' => $warehouseID])
            ->count();
    }
}
