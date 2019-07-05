<?php

return [
    'adapter' => \Prometheus\Storage\Redis::class,
    'active_collectibles' => [
//        \App\Instrumentation\FPM::class,
//        \App\Instrumentation\Opcache::class,
    ],
    'enable' => true,

    'namespace' => '',

    'client' => 'redis',

    'conn' => 'default',

    'name' => 'http_server_requests_seconds',

    'help' => 'duration of http_requests',

    'prefix' => 'prometheus',

    'namespace_http_server' => 'http',

    'histogram_buckets' => [1500, 3000],
];