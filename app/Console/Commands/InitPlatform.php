<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InitPlatform extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'platform:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize the platform';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // check database connection
        try {
            DB::connection()->getPdo();
            $this->info('Successfully connected to the DB.');
        } catch (\Exception $e) {
            $this->error('Could not connect to the DB. Please check your configuration. Error: ' . $e->getMessage());
            return;
        }

        // generate app key
        $this->call('key:generate');
        
        // generate jwt secret key
        $this->call('jwt:secret');

        // wipe the database
        $this->call('db:wipe');

        // migrate the database
        $this->call('migrate');

        // clear all caches
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('route:clear');

        



    }
}
