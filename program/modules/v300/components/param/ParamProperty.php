<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 17/4/11
 * Time: 上午9:53
 */

namespace v300\components\param;


class ParamProperty
{
    public static $propertyList = [
        //接口Controller-Action名称 => 接口参数数组
        'list-root' =>  ['token','updatetime'],

        'list-category' =>  ['token','updatetime','root_id'],

        'list-online' => ['token','updatetime','root_id','category_id'],

        'content-topic' => ['token','updatetime','topic_id'],

        'content-color' => ['token','updatetime'],

        'content-main' => ['token','updatetime','main_id'],

        'content-filmbanner' => ['token','updatetime'],

        'search-information' => ['token','updatetime'],

        'service-telephone' => ['token','updatetime'],

        'collect-add' => ['token','updatetime','main_id'],

        'collect-delete' => ['token','updatetime','main_id'],

        'collect-list' => ['token','updatetime'],

        'search-search' => ['token','updatetime','key_word','search_type'],

        'user-login' => ['mac','ota_version','app_version'],

        'user-info' => ['token','updatetime'],

        'search-presearch' => ['token','searchtext'],
    ];
}