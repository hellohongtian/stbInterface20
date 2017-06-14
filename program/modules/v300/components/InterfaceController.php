<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 17/4/7
 * Time: 下午2:46
 */

namespace v300\components;

use v300\components\error\ErrorAction;
use v300\components\param\ParamAction;
use v300\components\cache\CacheAction;
use v300\components\response\ResponseAction;
use v300\components\token\TokenAction;


class InterfaceController extends \yii\rest\Controller
{
    /**
     * 放置客户端提交的参数
     * @array
     */
    public $post = [];

    /**
     * 放置获取缓存信息所需要的键和过期时间
     * @array
     *  key => 键值
     *  timeout => 过期时间
     */
    public $cacheKey;

    /**
     * 放置缓存层的缓存数据
     * @string
     */
    public $cache;

    /**
     * 放置用户的token数据
     * @array
     */
    public $token = [];
    /**
     * 放置用户的post参数和token参数，用于传入getData方法
     */
    public $params;


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        #删除xml类型的返回值
        unset($behaviors['contentNegotiator']['formats']['application/xml']);
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (false === parent::beforeAction($action) ) {
            return false;
        }

        /**
         * 组装几个过程中使用的模块ID,控制器ID,操作ID
         */
        $option_ids = ['module_id'=>$this->module->id,'controller_id'=>$this->id,'action_id'=>$this->action->id];

        /**
         * 接口参数的校验层
         * 1 校验接口参数
         * 2 返回接口参数
         */
        #获取接口参数
        $this->post = ParamAction::getInstance()->extractParam($this->id,$this->action->id);

        /**
         * 用户鉴权层
         * 1 校验用户的token是否存在
         * 2 提取用户的token中的信息
         */
        #如果接口数据中存在token参数,则必须验证token
        if( isset($this->post['token'] )){
            $this->token = TokenAction::getInstance()->getToken( $this->post['token'] );
        }

        $this->params = array_merge($this->post,$this->token);

        /**
         * 缓存层使用层
         * 1 检查是否存在缓存数据
         * 2 如果缓存了数据,则使用
         */
        #获取缓存键值
        $this->cacheKey = CacheAction::getInstance()->serializeCacheKeys(array_merge($option_ids, $this->token ,$this->post));
        #获取缓存数据
        $this->cache = CacheAction::getInstance()->getCache($this->cacheKey);
        #检查缓存是否存在
        if( false != $this->cache ){
            ResponseAction::getInstance()->outPutCache($this->cache);
        }

        return true;

    }







    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        /**
         * 缓存层设置层
         * 1 根据缓存策略,设置缓存信息
         */
        $cacheResult = CacheAction::getInstance()->setCache($this->cacheKey,$result);
        return parent::afterAction($action, $cacheResult);
    }


    /**
     * Serializes the specified data.
     * The default implementation will create a serializer based on the configuration given by [[serializer]].
     * It then uses the serializer to serialize the given data.
     * @param mixed $data the data to be serialized
     * @return mixed the serialized data.
     */
    protected function serializeData($data)
    {
       return $data;
    }


    
}