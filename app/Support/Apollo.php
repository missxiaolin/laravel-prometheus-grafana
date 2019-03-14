<?php
/**
 * Created by PhpStorm.
 * User: gb
 * Date: 2019-03-14
 * Time: 11:39
 */

namespace App\Support;

use Symfony\Component\Yaml\Yaml;

/**
 * Class Apollo
 * @package App\Support
 */
class Apollo
{
    protected $config = [];

    /**
     * @param $key
     * @param null $value
     * @return mixed|null
     */
    public function get($key, $value = null)
    {
        $pos = strpos($key, '.');
        $search = null;

        //支持.查找
        if ($pos) {
            $name = substr($key, 0, $pos);
            $search = ltrim(str_replace($name, '', $key), '.');
        } else {
            $name = $key;
        }

        $path = base_path('custom/' . $name . '.yml');

        //读取文件
        if (!isset($this->config[$name])) {
            try {
                $this->config[$name] = Yaml::parseFile($path);
            } catch (\Exception $ex) {
                return $value;
            }
        }


        //直接返回
        if (!$search) {
            return $this->config[$name];
        }

        //从数组查找
        return array_get($this->config[$name], $search, $value);
    }

}