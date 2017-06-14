<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 17/4/7
 * Time: 下午2:20
 */

namespace app\modules\v300\controllers;

use v300\components\error\ErrorAction;
use v300\components\InterfaceController;
use v300\models\Information;
use v300\components\RequestCurl;
use v300\models\lists\Root;

class SearchController extends InterfaceController
{
    /**
     * 获取搜索页面信息
     */
    public function actionInformation()
    {
        $searchInformation = new Information();
        $data = $searchInformation->getSearchInformation([]);
        if(empty($data['result'])){
            ErrorAction::getInstance()->throwError();
        }
        return $data;
    }


    /**
     * 搜索
     */
    public function actionSearch()
    {
        $url = \Yii::$app->params['searchUrl'];
        $post_data['query'] = $this->params['key_word'];
        $post_data['country'] = "us";
        $post_data['queryFieldType'] = $this->params['search_type'];
        $result = json_decode(RequestCurl::request_post($url,false,$post_data),true);
        $arr_list = [];
        $data = [];
        $res_need = $result['response']['docs'];

        foreach ($res_need as $key=>$value){
            $root_name = Root::getRootName($value['root_id']);
            $arr = [
                'name' => $value['name'],
                'main_id' => $value['id'],
            ];
            $arr_list[$root_name."_".$value['root_id']][] = $arr;
        }
        foreach ($arr_list as $k=>$v){
            $params = explode("_",$k);
            list($root_name,$root_id) = $params;
            if($k == "专题"){
                $res['root_name'] = "其他";
                $res['root_id'] = $root_id;
                $res['main_list'] = $v;
            }else{
                $res['root_name'] = $root_name;
                $res['root_id'] = $root_id;
                $res['main_list'] = $v;
            }
            array_push($data,$res);
        }
        $exists_key = array_keys($arr_list);
        foreach (Root::getRootIdContrast() as $key=>$value){
            if(!in_array($value,$exists_key) && $value !="首页" && $value !="直播"){
                if($value == '专题'){
                    $res3['root_name'] = "其他";
                    $res3['root_id'] = $key;
                    $res3['main_list'] = [];
                }else{
                    $res3['root_name'] = $value;
                    $res3['root_id'] = $key;
                    $res3['main_list'] = [];
                }
                array_push($data,$res3);
            }
        }
        return ['result' => $data];
    }

    public function actionPresearch(){

        $url = \Yii::$app->params['searchUrl'];
        $post_data['query'] = $this->params['searchtext'];
        $post_data['country'] = "us";
        $post_data['queryFieldType'] = 2;  //搜明星
        $result = json_decode(RequestCurl::request_post($url,false,$post_data),true);
        $res_need = $result['response']['docs'];
        $arrs = [];
        foreach ($res_need as $key=>$value){
            $arr =[
                'rootid' => $value['root_id'],
                'mainid' => $value['id'],
                'name' => $value['name'],
                'direct' => $value['director'],
                'act' => $value['actor'],
                'starlevel' => $value['score'],
                'smallpic' => $value['poster_small'],
            ];
            $arrs['list'][] = $arr;
        }
        return $arrs;
    }
}