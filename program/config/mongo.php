<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 17/4/11
 * Time: 下午4:39
 */
return [
    
    'hx_mongo' => [
        'class' => '\yii\mongodb\Connection',
        'dsn' => 'mongodb://211.100.75.206:27017,211.100.75.213:27017,211.100.75.231:27017,211.100.75.221:27017,211.100.75.210:27017/hx_epg?replicaSet=hxSpock',
        //'dsn' => 'mongodb://localhost:27017/hx_epg',
        'options'=> [
            /*
             * 默认读取首选项
             * RP_PRIMARY 主节点
             * RP_PRIMARY_PREFERRED 主节点优先
             * RP_SECONDARY 副节点
             * RP_SECONDARY_PREFERRED 副节点优先
             * RP_NEAREST 最近节点
             */
            'readPreference' =>  \MongoDB\Driver\ReadPreference::RP_SECONDARY_PREFERRED,
            //'readPreference' => MongoClient::RP_PRIMARY_PREFERRED, //默认读取首选项
            //'readPreference' => 6,
        ],
    ],


];
