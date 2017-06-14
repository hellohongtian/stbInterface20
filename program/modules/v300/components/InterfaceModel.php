<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 17/4/13
 * Time: 下午4:32
 */

namespace v300\components;

use Yii;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

abstract class InterfaceModel extends \yii\mongodb\ActiveRecord
{
    /**
     * Returns the Mongo connection used by this AR class.
     * By default, the "mongodb" application component is used as the Mongo connection.
     * You may override this method if you want to use a different database connection.
     * @return Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return \Yii::$app->get('hx_mongo');
    }

    /**
     * Declares the name of the Mongo collection associated with this AR class.
     *
     * Collection name can be either a string or array:
     *  - if string considered as the name of the collection inside the default database.
     *  - if array - first element considered as the name of the database, second - as
     *    name of collection inside that database
     *
     * By default this method returns the class name as the collection name by calling [[Inflector::camel2id()]].
     * For example, 'Customer' becomes 'customer', and 'OrderItem' becomes
     * 'order_item'. You may override this method if the collection is not named after this convention.
     * @return string|array the collection name
     */
    public static function collectionName()
    {
        return 'hx_' . Inflector::camel2id(StringHelper::basename(get_called_class()), '_');
    }


    /**
     * 获取数据
     * @param $params
     * @return mixed
     */
    abstract function getData($params);


    /*
     * 获取需要返回的参数
     */
    public function getReturnDetail($needParams){
        $res = [];
        $arr = [];
        $returnDetail = [];
        $arrNeed =[];
        foreach ($needParams as $k=>$v){
            if(!is_array($v)){
                $res = array_merge($res,[$v => 1]);
            }else{
                if(count($v) == count($v,COUNT_RECURSIVE)){
                    foreach ($v as $key=>$value){
                        $arr = array_merge($arr,[$value=>1]);
                    }
                    $returnDetail = array_merge($returnDetail,[$k=>$arr]);
                }else{
                   $arrNeed = [$k=>$this->getReturnDetail($v)];

                }
            }
        }
        $result = array_merge($res,$returnDetail,$arrNeed);
        return $result;
    }

}