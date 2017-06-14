<?php

/**
 * Created by PhpStorm.
 * User: jason
 * Date: 17/4/11
 * Time: 下午1:46
 */

namespace v300\components\cache;

use Yii;
use v300\components\error\ErrorAction;
use v300\components\cache\CachePattern;

class CacheAction
{

    /**
     * 本类中返回的的默认错误名称
     * @var
     */
    private $error_name = 'param_error';

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
     * 获取接口的缓存数据
     * @param $cacheKeys string
     * @return $cacheData  string | null
     */
    public function getCache($cacheKey){
        //如果key是null,则说明没有使用缓存机制
        if( $cacheKey['timeout'] <= 0 || $cacheKey == false){
            return null;
        }
        //获取缓存数据
        $cacheData = Yii::$app->redisCache->get($cacheKey['key']);
        return $cacheData;
    }


    /**
     * 设置缓存信息
     * @param $cacheKey array
     *      key => redis中存储缓存数据的key值
     *      timeout => 服务器存储缓存数据的时间
     *      expiretime => 终端存储缓存数据的时间
     * @param $data array 数据
     * @return $cacheData array 加入缓存信息的数据
     */
    public function setCache($cacheKey,$data){
        #添加数据获取时间 和 数据在终端保存的时间
        $cacheData = array_merge([
            'updatetime' => time(),
            'expiretime' => $cacheKey['expiretime']
        ],$data);
        
        //如果key的超时时间为0,则说明没有使用缓存机制
        if($cacheKey['timeout'] <= 0){
            return $cacheData;
        }
        $content = json_encode($cacheData,320);
        $re = Yii::$app->redisCache->setex($cacheKey['key'],$cacheKey['timeout'],$content);
        return $cacheData;
    }







    /**
     * 获取缓存key的值
     * @param $keysArray
     * @return string
     */
    public function serializeCacheKeys($keysArray){

        //拼接名称
        $keyListName = $keysArray['controller_id'] . '-' . $keysArray['action_id'];

        //如果不存在缓存key的名称,则说明没有使用缓存机制
        if(!isset(CachePattern::$PatternList[$keyListName])){
            return null;
        }

        //拼接缓存key的结尾
        $key_foot = '';
        foreach(CachePattern::$PatternList[$keyListName]['keysList'] as $footKey){
            $key_foot .= ':' . $footKey . '_' . $keysArray[$footKey];
        }
        //缓存key的中间部分
        $key_body = $keysArray['module_id'] . ':' . $keysArray['controller_id'] . ':' . $keysArray['action_id'];

        //拼接缓存key
        $cacheKey['key'] = CachePattern::$keysHeader . ':' . $key_body . $key_foot;
        $cacheKey['timeout'] = CachePattern::$PatternList[$keyListName]['timeout'];
        $cacheKey['expiretime'] = CachePattern::$PatternList[$keyListName]['expiretime'];

        return $cacheKey;
    }



}