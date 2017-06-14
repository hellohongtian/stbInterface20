<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/4/19
 * Time: 17:32
 */
namespace v300\models\content;

class Main extends \v300\components\InterfaceModel
{
    #返回参数配置
    public $return_params = [
        #剧集
        'rootid3'=>[
            'root_id',
            'metadata'=>['name','director','actor','tag','intro','poster_big','latest_mark','ad_put_type'],
            'sub_data'=>['sub_id','program_id','mark'],
        ],
        #综艺
        'rootid4'=>[
            'root_id',
            'metadata'=>['name','presider','period','tag','intro','poster_big','ad_put_type'],
            'sub_data'=>['sub_id','program_id','name'],
        ],
        #直播
        'rootid5'=>[
            'root_id',
            'metadata'=>['name','program_id','no_review_msg','ad_put_type'],
            'sub_data'=>['sub_id','program_id','name','showtime'],
        ],
        #电影
        'rootid16'=>[
            'root_id',
            'metadata'=>['name','director','actor','release_date','tag','audience','intro','score','poster_big','stills','price','ad_put_type'],
            'sub_data'=>['sub_id','program_id'],
        ],
        #新闻
        'rootid21'=>[
            'root_id',
            'metadata'=>['name','period','intro','poster_big','channel','ad_put_type'],
            'sub_data'=>['sub_id','program_id','name'],
        ],
    ];

    public function getData($params)
    {
        $root_id = $this->getRootId($params['main_id']);
        $needKey = 'rootid'.$root_id;
        $needParams = $this->return_params[$needKey];
        $res = $this->getReturnDetail($needParams);
        $project =['$project'=> array_merge(['main_id' =>'$_id','_id' => 0],$res)];
        $data = $this->getCollection()->aggregate( [ ['$match' =>['_id' => $params['main_id'] ] ],$project ] );

        return [ 'result' => $data ];
    }
    public static function getRootId($main_id){
        $root_id = self::getCollection()->findOne(['_id' => $main_id],['root_id'=>1,'_id'=>0])['root_id'];

        return $root_id;
    }
    public static function getLatestMark($main_id){
        $latest_mark = self::getCollection()->findOne(['_id' => $main_id],['metadata.latest_mark'=>1,'_id'=>0])['metadata']['latest_mark'];
        return $latest_mark;
    }
}