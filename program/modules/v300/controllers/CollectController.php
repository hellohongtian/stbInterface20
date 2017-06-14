<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 17/4/7
 * Time: 下午1:51
 */

namespace app\modules\v300\controllers;

use v300\components\InterfaceController;
use v300\components\thriftClient\ThriftClient;
use v300\models\content\Main;
use yii\base\Exception;
use Thrift\Exception\TException;
use v300\components\error\ErrorAction;

class CollectController extends InterfaceController
{
    /**
     * 获取用户收藏列表
     */
    public function actionList()
    {
        try{
            $thriftClient = ThriftClient::instance('collect');
            $result = (array)$thriftClient->getCollectList('9013294');
            // $result = (array)$thriftClient->getCollectList($this->params['user_id']);
        }catch (TException $e){
            ErrorAction::getInstance()->throwError("default_error");
        }
        $arr = [];
        foreach ($result as $value){
            $data['name'] = $value->name;
            $data['root_id'] = $value->rootid;
            $data['main_id'] = $value->mainid;
            $data['poster_small'] = $value->pic;

            //当收藏为剧集时，增加子集更新至**集
            if($data['root_id'] == 3){
                $data['latest_mark'] = Main::getLatestMark($data['main_id']);
            }
            $data['collect_time'] = $value->collecttime;

            array_push($arr,$data);
        }

        return['result'=>$arr];
    }


    /**
     * 添加收藏记录
     */
    public function actionAdd()
    {

        $root_id = Main::getRootId($this->params['main_id']);
        $user_id = 9014984;
        $main_id = $this->params['main_id'];
        try{
            $thriftClient = ThriftClient::instance('collect');
            $result = $thriftClient->collectAdd($user_id,$root_id,$main_id);
        }catch (TException $e){
            ErrorAction::getInstance()->throwError("default_error");
        }

        return ['result'=>$result];
    }


    /**
     * 删除收藏记录
     */
    public function actionDelete()
    {
        $root_id = Main::getRootId($this->params['main_id']);
        $user_id = 9014984;
        $main_id = $this->params['main_id'];

        try{
            $thriftClient = ThriftClient::instance('collect');
            $result = $thriftClient->collectRemove($user_id,$root_id,$main_id);
        }catch (TException $e){
            ErrorAction::getInstance()->throwError("default_error");
        }

        return ['result'=>$result];
    }

}