<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Setting;
use App\Settings;

class SettingsController extends Controller
{
    public function index (Request $request) {
        if(!Auth::check()) {
            return redirect('/login');
        }

        $lang = Auth::user()->lang;
        $settings = Settings::getArrayOfSettings();
        return view('settings', ['lang' => $lang, 'settings' => $settings]);
    }

    public function submit (Request $request) {
        $lang = $request->input('lang');
        $userSettings = $request->all();

        Settings::updateSettings($userSettings);
        return redirect('/settings');
    }
}
