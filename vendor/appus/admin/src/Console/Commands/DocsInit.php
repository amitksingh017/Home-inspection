<?php
/**
 * Created by Vitaliy Shabunin, Appus Studio LP on 17.03.2020
 */

namespace Appus\Admin\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Container\Container;

class DocsInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:docs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initializing of docs';

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
        $dauxPath = app_path('../vendor/bin/daux');
        $source = realpath(__DIR__ . '/../../../docs');
        $destination = public_path('appus_admin_docs');
        $themes = $source . '/themes';
        $str = "$dauxPath generate --source=$source --destination=$destination --themes=$themes";
        exec($str);
        $this->info('Docs initialized successfully!');
        $this->info('Go to ' . env('APP_URL') . '/appus_admin_docs/index.html');
    }

}
