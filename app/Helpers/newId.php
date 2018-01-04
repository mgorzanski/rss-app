<?php
namespace App\Helpers;

class NewID {
  public static function get($length) {
    $characters = "0123456789";
    $charactersLength = strlen($characters);
    $randomId = "";
    for ($i = 0; $i < $length; $i++) {
      $randomId .= $characters[rand(0, $charactersLength -1 )];
    }
    return $randomId;
  }

  public static function getStringId($length) {
    $characters = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGJKLXCVBNM-_";
    $charactersLength = strlen($characters);
    $randomId = "";
    for ($i = 0; $i < $length; $i++) {
      $randomId .= $characters[rand(0, $charactersLength -1 )];
    }
    return $randomId;
  }
}

?>
