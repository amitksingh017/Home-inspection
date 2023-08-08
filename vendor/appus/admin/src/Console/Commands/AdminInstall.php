<?php

namespace Appus\Admin\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AdminInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installing of appus admin';

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
        Artisan::call('vendor:publish', [
            '--provider' => 'Appus\\Admin\\CoreServiceProvider',
            '--tag' => 'config'
        ]);
        Artisan::call('vendor:publish', [
            '--provider' => 'Appus\\Admin\\CoreServiceProvider',
            '--tag' => 'public'
        ]);
        Artisan::call('vendor:publish', [
            '--provider' => 'Appus\\Admin\\CoreServiceProvider',
            '--tag' => 'menu'
        ]);
        $this->info('Appus Admin successfully installed');
    }
}
