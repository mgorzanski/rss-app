<?php

namespace App\Helpers;

class DatabaseHelper {
    public static function summarizeText($summary, $length) {
        $summary = strip_tags($summary);
        if(strlen($summary) > $length)
            $summary = substr($summary, 0, $length) . '...';
    
        return $summary;
    }
}

?>