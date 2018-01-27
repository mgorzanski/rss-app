<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Setting;
use App\Settings;

class SettingsController extends Controller
{
    public function index (Request $request) {
        $lang = Auth::user()->lang;
        $settings = Settings::getArrayOfSettings();
        return view('settings', ['lang' => $lang, 'settings' => $settings]);
    }

    public function submit (Request $request) {
        $lang = $request->input('lang');
    }

    public static function insertDefaultSettings($userId) {
        //Always open source of article
        Setting::insert(
            ['name' => 'always_open_source_of_article', 'value' =>  0, 'user_id' => $userId]
        );
    }

    /*private function getListOfSettings() {
        $settings = Setting::select('*')
                            ->where('user_id', '=', Auth::id())
                            ->orderBy('id', 'desc')
                            ->get();
    }*/
}
