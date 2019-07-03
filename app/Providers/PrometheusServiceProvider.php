<?php
/**
 * Created by PhpStorm.
 * User: gb
 * Date: 2019-07-02
 * Time: 10:24
 */

namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\Redis;

class PrometheusServiceProvider extends ServiceProvider
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
        $this->app->singleton('prometheus', function ($app) {

            $config = $app['config']['prometheus'];

            Redis::setPrefix($config['prefix'] . ':' . config('system.mac') . '_');

            //php redis
            $options = Arr::get($app['config'], 'database.redis.' . $config['conn']);

            return new CollectorRegistry(new Redis($options));
        });
    }
}