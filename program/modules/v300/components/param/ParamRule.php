<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 17/4/11
 * Time: 上午9:49
 */

namespace v300\components\param;

use yii\base\Model;

class ParamRule extends Model
{

    /**
     * 客户端可能上传的参数名称
     * @var
     */
    public $token;
    public $updatetime;
    public $root_id;
    public $category_id;
    public $topic_id;
    public $main_id;
    public $key_word;
    public $search_type;
    public $mac;
    public $ota_version;
    public $app_version;
    public $searchtext;


    //接口参数 对应的校验方法
    public static $RuleList = [

        #token参数
        'token' => [
            [['token'], 'required'],
            [['token'], 'string'],
        ],

        #updatetime参数
        'updatetime' => [
            [['updatetime'], 'required'],
            [['updatetime'], 'filter', 'filter' => 'intval'],
        ],

        #root_id参数
        'root_id' => [
            [['root_id'], 'required'],
            [['root_id'], 'filter', 'filter' => 'intval'],
        ],
        #category_id参数
        'category_id' => [
            [['category_id'], 'required'],
            [['category_id'], 'filter', 'filter' => 'intval'],
        ],
        #topic_id参数
        'topic_id' => [
            [['topic_id'], 'required'],
            [['topic_id'], 'filter', 'filter' => 'intval'],
        ],
        #main_id参数
        'main_id' => [
            [['main_id'], 'required'],
            [['main_id'] ,'filter', 'filter' => 'intval'],
        ],
        #key_word参数
        'key_word' => [
            [['key_word'], 'required'],
            [['key_word'], 'string'],
        ],
        #search_type参数
        'search_type' => [
            [['search_type'], 'required'],
            [['search_type'] ,'filter', 'filter' => 'intval'],
        ],
        #mac参数
        'mac' => [
            [['mac'], 'required'],
            [['mac'], 'string'],
        ],
        #ota_version参数
        'ota_version' => [
            [['ota_version'], 'required'],
            [['ota_version'], 'string','max'=>8,'min'=>8],
        ],
        #app_version参数
        'app_version' => [
            [['app_version'], 'required'],
            [['app_version'], 'string'],
        ],
        #searchtext参数
        'searchtext' => [
            [['searchtext'],'required'],
            [['searchtext'],'string'],
        ],
    ];
}