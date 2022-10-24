<?php

namespace backend\controllers;

use yii\filters\Cors;
use yii\rest\ActiveController;

class BaseController extends ActiveController
{
    public function behaviors()
    {
        return self::injectBehaviors(parent::behaviors());
    }

    public static function injectBehaviors($behaviors)
    {
        /** Удаляем аутентификацию, чтобы применить CORS фильтр */
        $authBehavior = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        /** Активируем CORS фильтр */
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Expose-Headers' => ['*']
            ]
        ];

        /** Активируем аутентификацию */
        $behaviors['authenticator'] = $authBehavior;
        $behaviors['authenticator']['except'] = ['options'];

        return $behaviors;
    }
}