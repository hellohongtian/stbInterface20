<?php

/**
 * Created by PhpStorm.
 * User: jason
 * Date: 17/4/10
 * Time: 下午1:48
 */
namespace v300\components\param;

use v300\components\error\ErrorAction;

class ParamAction
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
     * 检查和提取接口的参数,
     * 如果符合规定,将返回参数数组,
     * 如果不符合,将直接输出错误.
     */
    public function extractParam($controllerID,$actionID)
    {
        $interfaceName = $controllerID . '-' . $actionID ;
        $form = new ParamForm($interfaceName);
        //ab测试使用get方法
        //$form->attributes = $_GET;
        $form->attributes = $_POST;
        if(!$form->validate()){
            ErrorAction::getInstance()->throwError();
        }else{
            return $form->getParams();
        }
    }

}