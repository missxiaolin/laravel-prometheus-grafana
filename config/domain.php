<?php

return [
    'request' => [
        'headers' => [
            'TOKEN',
        ],
    ],
    'rest' => env('DOMAIN_REST', 'http://www.xl-prometheus.com'),
    'healthy' => env('DOMAIN_REST', 'http://www.xl-prometheus.com'),
];
