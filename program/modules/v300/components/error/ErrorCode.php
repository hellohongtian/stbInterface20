<?php

/**
 * Created by PhpStorm.
 * User: jason
 * Date: 17/4/8
 * Time: 上午12:37
 */

namespace v300\components\error;

class ErrorCode
{
    /**
     * 默认错误的名称
     * @var string
     */
    public static $defaultErrorName = 'default_error';


    /**
     * 错误编码
     * @var array
     */
    private static $ErrorCodeArray = [
        #默认错误
        'default_error' => [
            'headerCode' => 600,
            'errorCode' => 10003,
            'errorMsg' => '操作失败请重试',
        ],
        #参数错误
        'param_error' => [
            'headerCode' => 600,
            'errorCode' => 10000,
            'errorMsg' => '参数错误',
        ],
        #token过期
        'token_overdue' => [
            'headerCode' => 600,
            'errorCode' => 10001,
            'errorMsg' => '登录状态已过期',
        ],
        #该影片不存在或已下架
        'not_exist_source' => [
            'headerCode' => 600,
            'errorCode' => 20500,
            'errorMsg' => '该影片不存在或已下架',
        ],
        #该专题不存在或已下架
        'not_exist_topic' => [
            'headerCode' => 600,
            'errorCode' => 20501,
            'errorMsg' => '该专题不存在或已下架',
        ],
        #不存在的顶级分类
        'not_exist_root' => [
            'headerCode' => 600,
            'errorCode' => 20502,
            'errorMsg' => '不存在的顶级分类',
        ],
        #不存在的二级分类
        'not_exist_category' => [
            'headerCode' => 600,
            'errorCode' => 20503,
            'errorMsg' => '不存在的二级分类',
        ],
        #直播包中不存在直播台
        'no_exist_live' => [
            'headerCode' => 600,
            'errorCode' => 20504,
            'errorMsg' => '直播包中不存在直播台',
        ]
    ];



    /**
     * 通过错误名称获取错误码
     * @param $errorName
     * @return array
     */
    public static function getErrorCode($errorName)
    {
        if(isset(self::$ErrorCodeArray[$errorName])){
            return self::$ErrorCodeArray[$errorName];
        }else{
            return self::$ErrorCodeArray[self::$defaultErrorName];
        }
    }
}