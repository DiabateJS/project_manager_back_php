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

        $sql = "select * from pm_projet";
        $bdMan = new BdManager();
        $entetes = array("id", "libelle", "etat", "description");
        $res = $bdMan->executeSelect($sql, $entetes);
        $projects = array();

        for ($i = 0; $i < count($res); $i++) {
            $id = $res[$i]["id"];
            $libelle = $res[$i]["libelle"];
            $etat = $res[$i]["etat"];
            $description = $res[$i]["description"];
            $taches = [];
            $tacheManager = new TacheManager();
            $taches = $tacheManager->getAllProjectsTache($id);
            $currentProject = new Project($id, $libelle, $etat, $description, $taches);
            $projects[] = $currentProject;
        }

        return $projects;

    }

    public function getProjectById($id)
    {
        $sql = "select * from pm_projet where id = :idProjet";
        $dico = array ("idProjet" => $id);
        $bdMan = new BdManager();
        $entetes = array("id","libelle","etat","description");
        $res = $bdMan->executePreparedSelect($sql,$dico,$entetes);
        $_project = null;

        if (count($res) > 0)
        {
            $_id = $res[0]["id"];
            $_libelle = $res[0]["libelle"];
            $_etat = $res[0]["etat"];
            $_description = $res[0]["description"];

            $tacheManager = new TacheManager();
            $taches = $tacheManager->getAllProjectsTache($_id);
            $_project = new Project($_id, $_libelle, $_etat, $_description, $taches);
        }

        return $_project;
    }

    public function updateProject($idProjet, $newProjet)
    {
        $resultat = Helper::createResponseObject();
        $sql = "update pm_projet set libelle = :libelle , etat = :etat , description = :description where id = :idProjet ";
        $dicoParam = array(
            "libelle" => $newProjet->libelle,
            "etat" => $newProjet->etat,
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
        $sql = "insert into pm_projet (libelle, etat, description) values (:libelle, :etat, :description)";
        $dicoParam = array(
          "libelle" => $newProjet->libelle,
          "etat" => $newProjet->etat,
          "description" => $newProjet->description
        );
        $bdMan = new BdManager();
        $bdMan->executePreparedQuery($sql, $dicoParam);
        $resultat["code"] = Constants::$SUCCES_CODE;
        return $resultat;
    }

    public function deleteProject($id){
        $resultat = Helper::createResponseObject();
        $sql = "select * from pm_tache where idProjet =  :idProjet";
        $bdMan = new BdManager();
        $dicoParam = array(
            "idProjet" => $id
        );
        $entete = array("id","libelle","estimation","description","etat","idProjet","idUser");
        $res = $bdMan->executePreparedSelect($sql, $dicoParam, $entete);
        if (count($res) == 0){
            $sql = "delete from pm_projet where id = :idProjet";
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
