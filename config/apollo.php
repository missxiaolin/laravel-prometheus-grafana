<?php
/**
 * Created by PhpStorm.
 * User: gb
 * Date: 2019-03-14
 * Time: 14:01
 */


return [

    'sync' => [
        'redis' => true,
        'file' => true,
    ],

    'server' => env('APOLLO_HOST'),

    'query' => [
        'app_id' => 'wuc',
        'cluster' => 'default',
        'namespace' => 'application',
    ]

];
