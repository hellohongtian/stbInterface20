<?php

/**
 * Created by PhpStorm.
 * User: jason
 * Date: 17/4/12
 * Time: 下午3:02
 */
namespace v300\components\token;

use v300\components\error\ErrorAction;
use Yii;

class TokenAction
{
    /**
     * 本类中返回的的默认错误名称
     * @var
     */
    private $error_name = 'token_overdue';
    
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
     * 检查token是否存在
     * 并获取token数据
     * @param $tokenKey string
     */
    public function getToken($tokenKey)
    {
        $redisToken = Yii::$app->redisCache->hgetall($tokenKey);
        if( !$redisToken ){
            ErrorAction::getInstance()->throwError( $this->error_name );
        }
        return $redisToken;
    }


    /**
     * 格式化Redis中的token信息
     * @param $redisToken
     * @return array
     */
    private function formatRedisToken($redisToken)
    {
        $token = [];
        $count = count($redisToken);
        for($i=0 ; $i < $count ; $i+=2 ){
            $token[$redisToken[$i]] = $redisToken[$i+1];
        }
        return $token;
    }

}