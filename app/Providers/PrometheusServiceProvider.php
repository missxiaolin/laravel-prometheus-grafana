<?php
/**
 * Created by PhpStorm.
 * User: gb
 * Date: 2019-07-02
 * Time: 10:24
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        dd(1);
    }
}