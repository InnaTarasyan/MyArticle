<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GrabSite as GR;


class GrabSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grab:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Data from tert.am site';

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
        $sitedata = new GR();
        $sitedata->populate();
    }
}
