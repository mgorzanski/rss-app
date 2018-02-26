<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Setting;
use App\Settings;
use App\User;

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
        $currentLang = User::select('lang')->where('id', '=', Auth::id())->first();
        $currentLang = $currentLang->lang;
        $userSettings = $request->all();

        if ($currentLang !== $lang) {
            User::where('id', '=', Auth::id())->update(['lang' => $lang]);
        }
        Settings::updateSettings($userSettings);
        return redirect('/settings');
    }
}
