<?php

namespace App\Console\Commands\Apollo;

use Illuminate\Console\Command;

class Value extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ue:apollo:value
    { name : 键名,支持使用.的形式 }
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '阿波罗测试';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $name = $this->argument('name');

        dd(app('apollo')->get($name));
    }
}
