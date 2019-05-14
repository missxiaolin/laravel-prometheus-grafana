<?php

namespace App\Http\Middleware;

use Closure;
use Prometheus\CollectorRegistry;
use Prometheus\Histogram;

/**
 * Class PrometheusMiddleWare
 * @package App\Http\Middleware
 */
class PrometheusMiddleWare
{

    protected $config;

    /**
     * @var Request
     */
    protected $request;
    /**
     * @var CollectorRegistry
     */
    protected $registry;
    /**
     * @var Histogram
     */
    protected $histogram;

    public function __construct(CollectorRegistry $registry)
    {
        $this->registry = $registry;
        $this->initRouteMetrics();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (!extension_loaded('Redis')) {
            return $next($request);
        }

        $start = $_SERVER['REQUEST_TIME_FLOAT'];

        $this->request = $request;
        /** @var \Illuminate\Http\Response $response */
        $response = $next($request);
        $route_name = $this->getRouteName();
        $method = $request->getMethod();
        $status = $response->getStatusCode();
        $duration = microtime(true) - $start;
        $duration_milliseconds = $duration * 1000.0;
        $this->countRequest($route_name, $method, $status, $duration_milliseconds);
        return $response;

    }

    public function initRouteMetrics()
    {
        $namespace = config('prometheus.namespace_http_server');
        $buckets = config('prometheus.histogram_buckets');
        $labelNames = $this->getRequestCounterLabelNames();
        $name = 'server_requests_seconds';
        $help = 'http requests';
        $this->histogram = $this->registry->getOrRegisterHistogram(
            $namespace, $name, $help, $labelNames, $buckets
        );
    }

    /**
     * @return array
     */
    protected function getRequestCounterLabelNames()
    {
        return [
            'route', 'method', 'status_code',
        ];
    }

    /**
     * @param $route
     * @param $method
     * @param $statusCode
     * @param $duration_milliseconds
     */
    public function countRequest($route, $method, $statusCode, $duration_milliseconds)
    {
        $labelValues = [(string)$route, (string)$method, (string)$statusCode];
        $this->histogram->observe($duration_milliseconds, $labelValues);
    }

    /**
     * Get route name
     *
     * @return string
     */
    protected function getRouteName()
    {
        return \Route::currentRouteName() ?: 'unnamed';
    }
}
