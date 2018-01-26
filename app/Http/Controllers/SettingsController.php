<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;

class SettingsController extends Controller
{
    public function index (Request $request) {
        return view('settings');
    }

    public static function insertDefaultSettings($userId) {
        //Always open source of article
        Setting::insert(
            ['name' => 'always_open_source_of_article', 'value' =>  0, 'user_id' => $userId]
        );
    }
}
