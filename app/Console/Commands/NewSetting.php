<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
//use App\User;
use App\Setting;
use Illuminate\Support\Facades\DB;

class NewSetting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:new {name} {value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add new setting available to all users';

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
        $users = DB::select('SELECT DISTINCT(user_id) AS user_id FROM settings ORDER BY user_id DESC');
        foreach($users as $user) {
            $name = $this->argument('name');
            $value = $this->argument('value');

            Setting::insert(
                ['name' => $name, 'value' => $value, 'user_id' => $user->user_id]
            );
        }
    }
}
