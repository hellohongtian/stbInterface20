<?php

/**
 * Created by PhpStorm.
 * User: jason
 * Date: 17/4/11
 * Time: 下午5:40
 */
namespace v300\components\response;

use Yii;

class ResponseAction
{

    //静态变量保存全局实例
    private static $_instance = null;

    //私有构造函数，防止外界实例化对象
    private function __construct(){}

    //私有克隆函数，防止外办克隆对象
    private function __clone(){}

    //静态方法，单例统一访问入口
    static public function getInstance() {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self ();
        }
        return self::$_instance;
    }


    /**
     * 输出缓存中的数据
     */
    public function outPutCache($cacheData)
    {
        $response = Yii::$app->response;
        //$response->acceptParams = ['isCache' => true ];
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->headers->add('Data Cache','use cache');
        //$response->format = \yii\web\Response::FORMAT_RAW;
        $response->content = $cacheData;
        $response->send();
        exit();
    }

}