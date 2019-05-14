<?php
/**
 * Created by PhpStorm.
 * User: gb
 * Date: 2019-05-14
 * Time: 09:53
 */

namespace App\Http\Controllers\Monitor;

use App\Instrumentation\Collectible;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\InMemory;
use Prometheus\Storage\Redis;

/**
 * Class PrometheusController
 * @package App\Http\Controllers\Monitor
 */
class PrometheusController extends BaseController
{
    /**
     * @return mixed
     */
    public function doMetrics()
    {
        $renderer = new RenderTextFormat();
        $registry = app(CollectorRegistry::class);

        $prefix = config('prometheus.prometheus_prefix');
        Redis::setPrefix($prefix);

        $metricFamilySamples = $registry->getMetricFamilySamples();
        $volatileRegistry = new CollectorRegistry(new InMemory());
        /** @var Collectible $collectible */
        foreach (config('prometheus.active_collectibles') as $collectible_class) {
            $collectible = new $collectible_class($volatileRegistry);
            if (!$collectible instanceof Collectible) {
                throw new \RuntimeException("$collectible_class does not implement Collectible");
            }
            $collectible->collect();
        }
        $volatileMetricSamples = $volatileRegistry->getMetricFamilySamples();
        return response($renderer->render(array_merge($metricFamilySamples, $volatileMetricSamples)))
            ->header('Content-Type', $renderer::MIME_TYPE);
    }
}