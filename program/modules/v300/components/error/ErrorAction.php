<?php

/**
 * Created by PhpStorm.
 * User: jason
 * Date: 17/4/8
 * Time: 上午12:43
 */

namespace v300\components\error;

class ErrorAction
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


    public function throwError($errorName=null)
    {
        if($errorName==null){
            $errorName = ErrorCode::$defaultErrorName;
        }
        $errorCodes = ErrorCode::getErrorCode($errorName);
        $this->outPutError($errorCodes['headerCode'],$errorCodes['errorCode']);
    }


    private function outPutError($header_code,$error_code)
    {
        $headerContent = "HTTP/1.0 ".$header_code." ERROR";
        header($headerContent);
        header('Content-type: application/json; charset=UTF-8');
        $response = array('result'=>$error_code);
        echo json_encode($response,320);
        exit();
    }
}