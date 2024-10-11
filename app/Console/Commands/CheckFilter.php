<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use DB;
use Log;

class CheckFilter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:filter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comprobar si existen colas para filtrados';

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
        $queue = DB::select('select * from jobs where queue = "filter"');

        if ($queue != null || !empty($queue)) {
            Artisan::call('queue:work --queue=filter');
            Log::debug('Se ha ejecutado el comando queue:filter');
        }
    }
}
