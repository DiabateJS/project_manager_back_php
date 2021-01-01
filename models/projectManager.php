<?php
include_once('config.php');
include_once('bd.php');
include_once('project.php');
include_once('tacheManager.php');

class ProjectManager
{

    public function __construct()
    {

    }

    public function getAllProjects()
    {

        $sql = "select * from projet";
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
        $sql = "select * from pm_projet where id = ".$id;
        $bdMan = new BdManager();
        $entetes = array("id","libelle","etat","description");
        $res = $bdMan->executeSelect($sql,$entetes);
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
        $resultat = array (
          "code" => "ERROR",
          "message" => ""
        );
        $sql = "update pm_projet set libelle = '".$newProjet->libelle."' , etat = '".$newProjet->etat."'";
        $sql .= " , description = '".$newProjet->description."' where id = ".$idProjet;
        $bdMan = new BdManager();
        $bdMan->executeUpdate($sql);
        $resultat["code"] = "SUCCES";
        return $resultat;
    }

    public function createProject($newProjet)
    {
        $resultat = array (
            "code" => "ERROR",
            "message" => ""
        );
        $sql = "insert into pm_projet (libelle, etat, description) values ('".$newProjet->libelle."','".$newProjet->etat."','".$newProjet->description."')";
        $bdMan = new BdManager();
        $bdMan->executeInsert($sql);
        $resultat["code"] = "SUCCES";
        return $resultat;
    }

    public function deleteProject($id){
        $resultat = array (
            "code" => "ERROR",
            "message" => ""
        );
        $sql = "select * from pm_tache where idProjet = ".$id;
        $bdMan = new BdManager();
        $entete = array("id","libelle","estimation","description","etat","idProjet","idUser");
        $res = $bdMan->executeSelect($sql, $entete);
        if (count($res) == 0){
            $sql = "delete from pm_projet where id = ".$id;
            $bdMan->executeDelete($sql);
            $resultat["code"] = "SUCCES";
        }else{
            $resultat["code"] = "WARNING";
            $resultat["message"] = "Suppression impossible. Il existe des taches associes au projet.";
        }
        return $resultat;
    }
}

 ?>
