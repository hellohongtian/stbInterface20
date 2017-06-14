<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 17/4/11
 * Time: 下午2:25
 */

namespace v300\components\cache;


class CachePattern
{
    //缓存的键中使用的项目头的信息
    public static $keysHeader = 'huanxin20:epg20cache';
    
    /**
     * 接口缓存机制
     * 如果接口不在这列表里,则说明接口不使用缓存机制
     * keysList 接口使用的缓存键值序列
     *
     */
    public static $PatternList = [

        /**
         * 接口Controller-Action名称 =>
         *      keysList => 接口参数数组(强调顺序)
         *      timeout  => 缓存存储时间(秒)
         *      expiretime => 客户端缓存存储时间(秒)
         */

        'list-root' => [
                'keysList' =>  ['market'] ,
                'timeout' => 10,
                'expiretime' => 600,
        ],

        'list-category' =>[
                'keysList' => ['root_id','market'] ,
                'timeout' => 10,
                'expiretime' => 600,
        ],

        'list-online' =>[
                'keysList' => ['root_id','category_id','market'],
                'timeout'  => 10,
                'expiretime' => 600,
        ],

        'content-topic' =>[
                'keysList' =>['topic_id'],
                'timeout' => 10,
                'expiretime' => 600,
        ],

        'content-color' =>[
                'keysList' =>['market'],
                'timeout' => 10,
                'expiretime' => 120,
        ],

        'content-main' =>[
                'keysList' =>['main_id'],
                'timeout' =>10,
                'expiretime' =>600,
        ],

        'content-filmbanner' =>[
                'keysList' => [],
                'timeout' => 10,
                'expiretime' => 600,
        ],

        'search-information' =>[
                'keysList' =>[],
                'timeout' => 10,
                'expiretime' => 600,
        ],

        'service-telephone' =>[
                'keysList' =>[],
                'timeout' => 10,
                'expiretime' => 600,
        ],
        'collect-list' => [
                'keysList' =>[],
                'timeout' => 0,
                'expiretime' => 600,
        ],
        'collect-add' => [
            'keysList' =>[],
            'timeout' => 0,
            'expiretime' => 600,
        ],
        'collect-delete' => [
            'keysList' =>[],
            'timeout' => 0,
            'expiretime' => 600,
        ],
        'search-search' =>[
                'keysList' =>[],
                'timeout' => 0,
                'expiretime' => 600,
        ],
        'user-login' =>[
            'keysList' =>[],
            'timeout' => 0,
            'expiretime' => 600,
        ],
        'user-info' =>[
            'keysList' =>[],
            'timeout' => 0,
            'expiretime' => 600,
        ],

    ];
}