<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\UserFeed;

class UpdateUserFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'userfeed:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update timeline';

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
        UserFeed::update();
    }
}
