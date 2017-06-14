<?php
/**
 * Created by PhpStorm.
 * User: hongtian.li
 * Date: 2017/4/17
 * Time: 15:54
 */

namespace v300\models\lists;


class Online extends \v300\components\InterfaceModel
{
    public $return_params =[
        'rootid3'=>[
            'metadata'=>['name','main_id','poster_small','latest_mark'],
        ],
        'rootid4'=>[
            'metadata'=>['name','main_id','poster_small'],
        ],
        'rootid5'=>[
            'metadata'=>['name','main_id','program_id'],
        ],
        'rootid7'=>[
            'metadata'=>['name','poster_small','topic_id','topic_template_id','poster_scroll'],
        ],
        'rootid16'=>[
            'metadata'=>['name','main_id','poster_small'],
        ],
        'rootid21'=>[
            'metadata'=>['name','main_id','poster_small'],
        ],
    ];
    public function getData($params)
    {
        $arr =[];
        if($params['category_id'] == 0){
            $match = [ '$match' => [ 'root_id' => $params['root_id'] ] ];
            $root_id = $params['root_id'];
        }else{
            $match = [ '$match' => [ 'category_id' => $params['category_id'] ] ];
            $root_id = self::getCollection()->findOne(['category_id' => $params['category_id']],['root_id'=>1,'_id'=>0])['root_id'];
        }

        $needKey = 'rootid'.$root_id;
        $project = ['$project'=>array_merge($this->getReturnDetail($this->return_params[$needKey]),['_id'=>0])];
        $data = $this->getCollection()->aggregate([$match,[ '$sort' => [ 'sequence' => 1 ] ],$project,]);

        foreach ($data as $value){
            $arr[] = $value['metadata'];
        }

        return [ 'result' => $arr ];
    }
}