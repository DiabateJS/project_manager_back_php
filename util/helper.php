<?php

class Helper {

    public static function createResponseObject(){
        return array (
          "code" => Constants::$ERROR_CODE,
          "message" => Constants::$EMPTY_STRING
        );
    }

}
