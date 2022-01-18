<?php

class GlobalParams
{
  public static $ENV = "LOCAL"; // PROD pour la production

  //public static $ENV = "PROD"; // LOCAL pour l'environnement local

  //public static $PREFIXE = "pm_"; // Pour la prod
  
  public static $PREFIXE = ""; // Pour l'environnement local 

  public static $PROD_BD_CONFIG = array(
      "host" => "185.98.131.90",
      "user" => "djste1070339",
      "password" => "da6ysjpqpp",
      "bdname" => "djste1070339"
  );

  public static $LOCAL_BD_CONFIG = array(
      "host" => "localhost",
      "user" => "root",
      "password" => "root",
      "bdname" => "project_manager"
  );
}


?>
