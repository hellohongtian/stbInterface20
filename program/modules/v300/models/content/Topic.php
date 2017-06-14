<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2017/4/18
 * Time: 16:59
 */
namespace v300\models\content;

class Topic extends \v300\components\InterfaceModel
{

    public function getData($params)
    {
        $data = $this->getCollection()->findOne(['_id'=>$params['topic_id']],['metadata.name'=>1,'metadata.poster_background'=>1,'sub_data'=>1,'_id'=>0]);

        return [ 'result' => $data ];
    }
}