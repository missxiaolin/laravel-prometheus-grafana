<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\Redis;

class PrometheusProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if(!extension_loaded('Redis')){
            return true;
        }

        $storageAdapter = $this->getConfigInstance('adapter');
        $this->app->bind('Prometheus\Storage\Adapter', $storageAdapter);
        $this->app->singleton(CollectorRegistry::class, function () use ($storageAdapter) {
            $prefix = config('prometheus.prometheus_prefix');
            Redis::setPrefix($prefix);
            return new CollectorRegistry($storageAdapter);
        });
    }

    /**
     * @param $key
     * @param null $default
     * @return \Illuminate\Config\Repository|mixed
     */
    public function config($key, $default = null)
    {
        return config('prometheus.' . $key, $default);
    }

    /**
     * @param $key
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getConfigInstance($key)
    {
        $instance = $this->config($key);
        if (is_string($instance)) {
            return $this->app->make($instance);
        }
        return $instance;
    }
}
