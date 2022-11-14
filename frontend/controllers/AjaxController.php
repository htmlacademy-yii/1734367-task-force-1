<?php

namespace frontend\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;

class AjaxController extends Controller
{
    /**
     * AJAX
     */
    public function actionLocation() {
        if (!Yii::$app->request->getIsAjax()) {
            throw new \Exception('Должен быть Ajax-запрос');
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $value = Yii::$app->request->get('term');

        if (($addresses = Yii::$app->cache->get($value)) === false) {
            $yandexService = new YandexService();
            $addresses = $yandexService->getAddresses($value);
            Yii::$app->cache->set($value, $addresses, 86400);
        }

        return $this->asJson($addresses);
    }
}