<?php

namespace App\Console\Commands\Consul;

use Illuminate\Console\Command;

class Deamon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ue:consul:deamon
    { path : 路径 }
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'consul 守护进程';

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
    }
}
