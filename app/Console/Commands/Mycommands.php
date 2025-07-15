<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Mycommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mycommands';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Deleted expired report sellers.');

        return 0; 
    }
}
