<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 17/4/7
 * Time: 下午1:39
 */

namespace app\modules\v300\controllers;

use v300\components\InterfaceController;
use v300\components\error\ErrorAction;
use v300\models\content\Topic;
use v300\models\content\Color;
use v300\models\content\Main;
use v300\models\Information;

class ContentController extends InterfaceController
{
    /**
     * 获取色块信息
     */
    public function actionColor()
    {
        $color  = new Color();
        $data = $color->getData([]);
        if(empty($data['result'])){
            ErrorAction::getInstance()->throwError();
        }
        return $data;
    }


    /**
     * 获取专题详情信息
     */
    public function actionTopic()
    {
        $topic = new Topic();
        $data = $topic->getData($this->params);
        if(empty($data['result'])){
            ErrorAction::getInstance()->throwError('not_exist_topic');
        }
        return $data;
    }


    /**
     * 获取影视详情及子集信息
     */
    public function actionMain()
    {
        $main = new Main();
        $root_id = Main::getRootId($this->params['main_id']);
        $data = $main->getData($this->params);
        if(empty($data['result']) && $root_id == 5){
            ErrorAction::getInstance()->throwError('no_exist_live');
        }
        if(empty($data['result'])){
            ErrorAction::getInstance()->throwError('not_exist_source');
        }
        return $data;
    }


    /**
     * 获取电影(原高清电影)Banner图片地址
     */
    public function actionFilmbanner()
    {
        $information = new Information();
        $data = $information->getData([]);
        if(empty($data['result'])){
            ErrorAction::getInstance()->throwError();
        }
        return $data;
    }

}