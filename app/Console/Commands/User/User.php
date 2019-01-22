<?php

namespace App\Console\Commands\User;

use Illuminate\Console\Command;

class User extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:test {--model=} {--command=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $command = $this->option('command');
        $class = $this->option('model');
        if ($class) {
            $model = new $class;
            dump($model->getConnection());
        }


        if ($command) {
            $this->call($command);
        }
    }
}
