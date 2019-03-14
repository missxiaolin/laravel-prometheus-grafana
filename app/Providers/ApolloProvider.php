<?php
/**
 * Created by PhpStorm.
 * User: gb
 * Date: 2019-03-14
 * Time: 11:47
 */

namespace App\Providers;

use App\Support\Apollo;
use Illuminate\Support\ServiceProvider;

/**
 * Class ApolloProvider
 * @package App\Providers
 */
class ApolloProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('apollo', function () {
            return new Apollo();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}