<?php

namespace App\Instrumentation;


use Prometheus\CollectorRegistry;

interface Collectible
{
    public function __construct(CollectorRegistry $registry);

    public function collect();
}