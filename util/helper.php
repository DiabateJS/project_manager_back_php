<?php
include_once('../models/config.php');

class Helper {

    public static function createResponseObject(){
        return array (
          "code" => Constants::$ERROR_CODE,
          "message" => Constants::$EMPTY_STRING
        );
    }

    public static function transformQuery($query, $env){
      $res = $query;
      $prefixe = $env == Constants::$LOCAL_ENV ? Constants::$EMPTY_STRING : GlobalParams::$PREFIXE;
      $res = str_replace("%Prefixe%",$prefixe,$query);
      return $res;
    }

}
