<?php
/**
 * Created by PhpStorm.
 * User: gb
 * Date: 2019-03-14
 * Time: 14:01
 */


return [

    'sync' => [
        'redis' => false,
        'file' => true,
    ],

    'server' => env('APOLLO_HOST'),

    'query' => [
        'app_id' => 'CMS',
        'cluster' => 'default',
        'namespace' => 'application',
    ]

];
