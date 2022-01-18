<?php
include_once('config.php');
include_once('bd.php');
include_once('project.php');
include_once('tacheManager.php');
include_once('constants.php');
include_once('util/helper.php');

class ProjectManager
{

    public function __construct()
    {

    }

    public function getAllProjects()
    {
        $sql = Helper::transformQuery(Constants::$SQL_SELECT_PROJECTS, GlobalParams::$ENV);
        $bdMan = new BdManager();
        $entetes = Constants::$TABLE_PROJECT_COLOUMNS;
        $res = $bdMan->executeSelect($sql, $entetes);
        $projects = array();

        for ($i = 0; $i < count($res); $i++) {
            $id = $res[$i][Constants::$ID];
            $libelle = $res[$i][Constants::$LIBELLE];
            $etat = $res[$i][Constants::$ETAT];
            $dateDebut = $res[$i][Constants::$DATE_DEBUT];
            $dateFin = $res[$i][Constants::$DATE_FIN];
            $description = $res[$i][Constants::$DESCRIPTION];
            $taches = [];
            $tacheManager = new TacheManager();
            $taches = $tacheManager->getAllProjectsTache($id);
            $currentProject = new Project($id, $libelle, $etat, $dateDebut, $dateFin, $description, $taches);
            $projects[] = $currentProject;
        }

        return $projects;

    }

    public function getUserProjects($idUser) {
        $sql = Constants::$SQL_SELECT_USER_PROJECTS;
        $dico = array ("idUser" => $idUser);
        $bdMan = new BdManager();
        $entetes = array("id", "libelle", "etat", "dateDebut","dateFin","description");
        $res = $bdMan->executePreparedSelect($sql, $dico, $entetes);
        $projects = array();

        for ($i = 0; $i < count($res); $i++) {
            $id = $res[$i]["id"];
            $libelle = $res[$i]["libelle"];
            $etat = $res[$i]["etat"];
            $dateDebut = $res[$i]["dateDebut"];
            $dateFin = $res[$i]["dateFin"];
            $description = $res[$i]["description"];
            $taches = [];
            $tacheManager = new TacheManager();
            $taches = $tacheManager->getAllProjectsTache($id);
            $currentProject = new Project($id, $libelle, $etat, $dateDebut, $dateFin, $description, $taches);
            $projects[] = $currentProject;
        }

        return $projects;
    }

    public function getProjectById($id)
    {
        $sql = Helper::transformQuery(Constants::$SQL_SELECT_PROJECT, GlobalParams::$ENV);
        $dico = array (Constants::$ID_PROJET => $id);
        $bdMan = new BdManager();
        $entetes = Constants::$TABLE_PROJECT_COLOUMNS;
        $res = $bdMan->executePreparedSelect($sql,$dico,$entetes);
        $_project = null;

        if (count($res) > 0)
        {
            $_id = $res[0][Constants::$ID];
            $_libelle = $res[0][Constants::$LIBELLE];
            $_etat = $res[0][Constants::$ETAT];
            $_dateDebut = $res[0][Constants::$DATE_DEBUT];
            $_dateFin = $res[0][Constants::$DATE_FIN];
            $_description = $res[0][Constants::$DESCRIPTION];

            $tacheManager = new TacheManager();
            $taches = $tacheManager->getAllProjectsTache($_id);
            $_project = new Project($_id, $_libelle, $_etat, $_dateDebut, $_dateFin, $_description, $taches);
        }

        return $_project;
    }

    public function updateProject($idProjet, $newProjet)
    {
        $resultat = Helper::createResponseObject();
        $sql = Constants::$SQL_UPDATE_PROJECT;
        $dicoParam = array(
            "libelle" => $newProjet->libelle,
            "etat" => $newProjet->etat,
            "dateDebut" => $newProjet->dateDebut,
            "dateFin" => $newProjet->dateFin,
            "description" => $newProjet->description,
            "idProjet" => $idProjet
        );
        $bdMan = new BdManager();
        $bdMan->executePreparedQuery($sql, $dicoParam);
        $resultat["code"] = Constants::$SUCCES_CODE;
        return $resultat;
    }

    public function createProject($newProjet)
    {
        $resultat = Helper::createResponseObject();
        $sql = Constants::$SQL_INSERT_PROJECT;
        $dicoParam = array(
          "libelle" => $newProjet->libelle,
          "etat" => $newProjet->etat,
          "dateDebut" => $newProjet->dateDebut,
          "dateFin" => $newProjet->dateFin,
          "description" => $newProjet->description
        );
        $bdMan = new BdManager();
        $bdMan->executePreparedQuery($sql, $dicoParam);
        $resultat["code"] = Constants::$SUCCES_CODE;
        return $resultat;
    }

    public function deleteProject($id){
        $resultat = Helper::createResponseObject();
        $sql = Constants::$SQL_SELECT_TASK_BEFORE_DELETE_PROJECT;
        $bdMan = new BdManager();
        $dicoParam = array(
            "idProjet" => $id
        );
        $entete = array("id","libelle","estimation","description","etat","idProjet","idUser");
        $res = $bdMan->executePreparedSelect($sql, $dicoParam, $entete);
        if (count($res) == 0){
            $sql = Constants::$SQL_DELETE_PROJECT;
            $bdMan->executePreparedQuery($sql, $dicoParam);
            $resultat["code"] = Constants::$SUCCES_CODE;
        }else{
            $resultat["code"] = Constants::$WARNING_CODE;
            $resultat["message"] = "Suppression impossible. Il existe des taches associes au projet.";
        }
        return $resultat;
    }
}

 ?>
