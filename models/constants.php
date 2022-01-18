<?php
include_once('config.php');

class Constants {
    public static $EMPTY_STRING = "";

    public static $SUCCES_CODE = "SUCCES";
    public static $WARNING_CODE = "WARNING";
    public static $ERROR_CODE = "ERROR";

    public static $LOCAL_ENV = "LOCAL";
    public static $METHOD_PARAM = "method";
    public static $TYPE_PARAM = "type";
    public static $METHOD_GET = "get";
    public static $TYPE_PROJETS = "projets";
    public static $TYPE_PROJET = "projet";

    public static $TABLE_PROJECT_COLOUMNS = array("id", "libelle", "etat", "dateDebut","dateFin","description");
    public static $TABLE_PROJECT_TASK_COLUMNS = array("id", "libelle", "estimation", "dateDebut","dateFin","description", "etat", "idProjet", "idUser");
    public static $ID = "id";
    public static $ID_PROJET = "idProjet";
    public static $ID_USER = "idUser";
    public static $LIBELLE = "libelle";
    public static $ETAT = "etat";
    public static $DATE_DEBUT = "dateDebut";
    public static $DATE_FIN = "dateFin";
    public static $ESTIMATION = "estimation";
    public static $DESCRIPTION = "description";

    //SQL PROJECTS
    public static $SQL_SELECT_PROJECTS = "select * from %Prefixe%projet";
    public static $SQL_SELECT_USER_PROJECTS = "select p.* from pm_projet p, pm_visibilite_projet vp where p.id = vp.idProjet and vp.idUser = :idUser";
    public static $SQL_SELECT_PROJECT = "select * from %Prefixe%projet where id = :idProjet";
    public static $SQL_UPDATE_PROJECT = "update pm_projet set libelle = :libelle , etat = :etat , dateDebut = :dateDebut, dateFin = :dateFin ,description = :description where id = :idProjet ";
    public static $SQL_INSERT_PROJECT = "insert into pm_projet (libelle, etat, dateDebut, dateFin, description) values (:libelle, :etat, :dateDebut, :dateFin, :description)";
    public static $SQL_SELECT_TASK_BEFORE_DELETE_PROJECT = "select * from pm_tache where idProjet =  :idProjet";
    public static $SQL_DELETE_PROJECT = "delete from pm_projet where id = :idProjet";

    //SQL TACHES
    public static $SQL_SELECT_TASKS = "select * from %Prefixe%tache where idProjet = :idProjet";
    public static $SQL_SELECT_TASK = "select id, libelle, estimation, dateDebut, dateFin, description, etat, idProjet, (select fullname from pm_users where id = pm_tache.idUser) as user from pm_tache where idProjet = :idProjet and id = :idTache";
    public static $SQL_UPDATE_TASK = "update pm_tache set libelle = :libelle , estimation = :estimation , dateDebut = :dateDebut, dateFin = :dateFin, description = :description , etat = :etat , idProjet = :idProjet , idUser = (select id from pm_users where fullname = :user) where id = :idTache";
    public static $SQL_CREATE_TASK = "insert into pm_tache(libelle, estimation, dateDebut, dateFin, description, etat, idProjet, idUser) values (:libelle, :estimation, :dateDebut, :dateFin, :description, :etat, :idProjet ,(select id from pm_users where fullname = :user))";
    public static $SQL_DELETE_TASK = "delete from pm_tache where id = :idTache";

    //SQL STATISTIQUE
    public static $SQL_STATE_BY_USERS = "select u.fullname, t.etat, count(*) as tache from pm_tache t, pm_users u where t.idUser = u.id group by t.idUser, t.etat order by u.fullname";
    public static $SQL_TASKS_BY_PROJECT = "select p.libelle as projet, count(*) as tache from pm_tache t, pm_projet p where t.idProjet = p.id group by idProjet";
    public static $SQL_TASKS_BY_STATE = "select etat, count(*) as nbre from pm_tache group by etat";
    public static $SQL_PROJECTS_BY_STATE = "select etat, count(*) as nbre from pm_projet group by etat";
    public static $SQL_COUNT_TASKS = "select count(*) as nbre from pm_tache";
    public static $SQL_COUNT_PROJECTS = "select count(*) as nbre from pm_projet";
}

?>
