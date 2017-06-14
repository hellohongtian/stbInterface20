<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 17/4/7
 * Time: 下午1:43
 */

namespace app\modules\v300\controllers;

use v300\components\InterfaceController;
use v300\models\Information;

class ServiceController extends InterfaceController
{
    /**
     * 获取客服电话接口
     */
    public function actionTelephone()
    {
        $information = new Information();
        $data = $information-> getServiceTelephone($this->params);
        return $data;
    }
}