<?php

return [
    'adapter' => \Prometheus\Storage\Redis::class,
    'active_collectibles' => [
        //\App\Instrumentation\FPM::class,
        //\App\Instrumentation\Opcache::class,
    ],
    'namespace' => 'app',
    'namespace_http_server' => 'http',
    'histogram_buckets' => [1000, 5000],
    'redis' => [
        'host' => '127.0.0.1',
        'port' => 6379,
        'password' => null,
        'timeout' => 1,  // in seconds
        'read_timeout' => 5, // in seconds
        'persistent_connections' => false,
    ],
    'register_global_middleware' => true,
    'opcache_metrics_namespace' => 'opcache',
    'fpm_statistics_namespace' => 'fpm',
    'prometheus_prefix' => 'prometheus_xl_',
];