<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 17/4/13
 * Time: 下午4:38
 */

namespace v300\models\lists;

use Yii;

class Root extends \v300\components\InterfaceModel
{

    public function getData($params)
    {
        $data = $this->getCollection()->aggregate([
            [ '$match' => [ 'display' => 1,"property.market.".$params['market'] => 1 ] ],
            [ '$sort' => [ 'sequence' => 1 ] ],
            [ '$project' => [ 'root_id'=>'$_id', 'name' => '$property.name' , '_id'=> 0 ] ],
        ]);

        return [ 'result' => $data ];
    }

    public static function getRootName($root_id){
        $root_name = self::getCollection()->findOne(['_id'=>$root_id],['property.name' => 1,'_id'=>0])['property']['name'];
        return $root_name;
    }
    public static function getRootIdContrast(){
        $root_id_contrast = self::getCollection()->aggregate([['$project'=>['_id'=> 0,'root_id'=>'$_id','root_name' => '$property.name']]]);
        $arr =[];
        foreach ($root_id_contrast as $value){
            $arr = $arr+[$value['root_id'] => $value['root_name']];
        }
        return $arr;
    }
}