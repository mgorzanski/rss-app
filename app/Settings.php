<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use App\Setting;
use Lang;

class Settings
{
    public static function getArrayOfSettings() {
        $settings = Setting::select('*')
                            ->where('user_id', '=', Auth::id())
                            ->orderBy('id', 'desc')
                            ->get();
    
        $rows = [];
    
        foreach ($settings as $setting) {
            $row = new \stdClass();
            $data = [];

            $view = 'settings.' . $setting['type'] . 'template';

            $data['label'] = self::getNameTranslation($setting['name']);
            $data['name'] = $setting['name'];
            $data['description'] = self::getDescriptionTranslation($setting['name']);

            $row->view = $view;
            $row->data = $data;

            array_push($rows, $row);
        }
    
        return $rows;
    }

    private static function getNameTranslation($name) {
        $name = str_replace("_", "-", $name);
        $name = "settings.label-" . $name;
        return $name;
    }

    private static function getDescriptionTranslation($name) {
        $description = '';
        $translation = str_replace("_", "-", $name);
        $translation = "settings.label-" . $translation . "-description";

        if (Lang::has($translation)) {
            $description = $translation;
        }

        return $description;
    }

    public static function insertDefaultSettings($userId) {
        //Always open source of article
        Setting::insert(
            ['name' => 'always_open_source_of_article', 'value' =>  0, 'user_id' => $userId]
        );
    }
}

?>