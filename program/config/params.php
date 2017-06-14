<?php

return [
    'adminEmail' => 'admin@example.com',
    'searchUrl' => 'lwq.manager40.com/my-solr/get-info',
    #等待本模块请求的thrift服务端的配置
    'thriftServer' => [
        #ucenter_20服务器
        'auth' => [
            'host' => 'hongtian.li.ucenter2.italktv.colnv.com',
            'port' => 80,
            'uri'=>'/thrift/auth',
            'client'=>'auth\AuthClient',
        ],
        'collect' => [
            'host' => 'hongtian.li.ucenter2.italktv.colnv.com',
            'port' => 80,
            'uri' => '/thrift/collect',
            'client'=>'collect\CollectClient',
        ],
        'play' => [
            'host' => 'hongtian.li.ucenter2.italktv.colnv.com',
            'port' => 80,
            'uri' => '/thrift/play',
            'client'=>'play\PlayClient',
        ],
    ],
];
