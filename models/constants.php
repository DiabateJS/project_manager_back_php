<?php

class Constants {
    public static $EMPTY_STRING = "";

    public static $SUCCES_CODE = "SUCCES";
    public static $WARNING_CODE = "WARNING";
    public static $ERROR_CODE = "ERROR";

    //SQL STATISTIQUE
    public static $SQL_STATE_BY_USERS = "select u.fullname, t.etat, count(*) as tache from tache t, users u where t.idUser = u.id group by t.idUser, t.etat order by u.fullname";
    public static $SQL_TASKS_BY_PROJECT = "select p.libelle as projet, count(*) as tache from tache t, projet p where t.idProjet = p.id group by idProjet";
    public static $SQL_TASKS_BY_STATE = "select etat, count(*) as nbre from tache group by etat";
    public static $SQL_PROJECTS_BY_STATE = "select etat, count(*) as nbre from projet group by etat";
    public static $SQL_COUNT_TASKS = "select count(*) as nbre from tache";
    public static $SQL_COUNT_PROJECTS = "select count(*) as nbre from projet";
}

?>
