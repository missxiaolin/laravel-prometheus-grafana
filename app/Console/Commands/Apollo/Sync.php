<?php

namespace App\Console\Commands\Apollo;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Console\Command;
use Symfony\Component\Yaml\Yaml;

/**
 * Class Sync
 * @package App\Console\Commands\Apollo
 */
class Sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ue:apollo:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '阿波罗同步';

    /**
     * 地址
     * @var string
     */
    protected $url;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->url = config('apollo.server') . '/configs/' . implode('/', array_values(config('apollo.query')));
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return mixed
     */
    public function handle()
    {
        $this->doSync();

        sleep(10);
    }

    /**
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function doSync()
    {
        $client = new Client(['timeout' => 2.00]);

        try {
            $response = $client->request('GET', $this->url);
            $body = json_decode($response->getBody()->getContents(), true);
            $cfg = array_get($body, 'configurations', []);
            if (!$cfg) {
                return true;
            }
            $cfg = array_map(function ($value) {
                if ($row = json_decode($value, true)) {
                    return $row;
                }
                return $value;
            }, $cfg);

            $items = [];

            foreach ($cfg as $key => $value) {
                data_set($items, $key, $value);
            }

            foreach ($items as $k => $item) {
                $this->line('Saving [' . $k . ']');
                $this->save($k, $item);
            }
        } catch (RequestException $be) {
            $this->error($this->url);
            $this->error($be->getMessage());
        } catch (\Exception $ex) {
            $this->error($ex->getMessage());
        }
    }

    /**
     * @param $fileName
     * @param $item
     * @throws \Exception
     */
    protected function save($fileName, $item)
    {
        if (config('apollo.sync.redis', false)) {

            cache()->tags('apollo')->forever($fileName, $item);

            $this->line('Saving To Redis ' . $fileName);

        }
        if (config('apollo.sync.file', false)) {
            Storage::disk('custom')->put($fileName . '.yml', Yaml::dump($item));
            $this->line('Saving To File ' . $fileName);
        }
        $this->line('==================');
    }
}
