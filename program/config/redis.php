<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 17/4/11
 * Time: 下午4:39
 */

return [
    'redisCache' => [
        'class' => 'yii\redis\RedisClient',
        'cluster' => true,
        'seeds' => ['211.100.75.238:6379', '211.100.75.213:6379', '211.100.75.231:6379'],
        'prefix' => '',
    ],
];