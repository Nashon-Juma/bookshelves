<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pest:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute test from Pest framework';

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
     * @return int
     */
    public function handle()
    {
        $this->info('Run tests');

        // $result = shell_exec('./vendor/bin/pest  --colors');
        // echo $result;

        $process = new Process(['./vendor/bin/pest', '--colors=always']);
        $process->setTimeout(0);
        $process->start();
        $iterator = $process->getIterator($process::ITER_SKIP_ERR | $process::ITER_KEEP_OUTPUT);
        foreach ($iterator as $data) {
            echo $data;
        }
    }
}
