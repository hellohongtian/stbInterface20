<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/4/20
 * Time: 11:10
 */
namespace v300\models;

use Yii;

class Information extends \v300\components\InterfaceModel
{
    public function getData($params)
    {
        $data = $this->getCollection()->aggregate([
            [ '$project' => [ 'banner_picture'=>'$banner_picture',"_id"=>0 ] ],
        ]);
        return [ 'result' => $data[0] ];
    }

    //搜索推荐列表
    public function getSearchInformation(){

        $data_main_list = $this->getCollection()->findOne([
            'main_list' => ['$exists' => true ]
        ],['main_list' => 1,'_id' => 0 ]);
        $data_word_list = $this->getCollection()->findOne([
            'word_list' => ['$exists' => true ]
        ],['word_list' => 1,'_id' => 0 ]);

        $data = array_merge($data_main_list,$data_word_list);

        return [ "result" => $data ];
    }

    //客服电话
    public function getServiceTelephone($params){

        $data = $this->getCollection()->aggregate([
            ['$match' => ['telephone' =>['$exists' => true ] ] ] ,
            [ '$project' => [ 'telephone'=>'$telephone.'.$params['market'],"_id"=>0 ] ],
        ]);

        return [ "result" => $data[0] ];
    }
}