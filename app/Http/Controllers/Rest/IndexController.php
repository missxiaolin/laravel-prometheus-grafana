<?php
/**
 * Created by PhpStorm.
 * User: gb
 * Date: 2019-05-06
 * Time: 14:37
 */

namespace App\Http\Controllers\Rest;

use App\Instrumentation\Collectible;
use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Prometheus\Storage\InMemory;
use Prometheus\Storage\Redis;

/**
 * Class IndexController
 * @package App\Http\Controllers\Rest
 */
class IndexController extends BaseController
{
    public function index()
    {
    }

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