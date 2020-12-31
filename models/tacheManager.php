<?php
include_once('config.php');
include_once('bd.php');
include_once('tache.php');

class TacheManager
{

    public function __construct()
    {

    }

    public function getAllProjectsTache($idProjet)
    {
        $sql = "select * from tache where idProjet = " . $idProjet;
        $bdMan = new BdManager();
        $entetes = array("id", "libelle", "estimation", "description", "etat", "idProjet", "idUser");
        $res = $bdMan->executeSelect($sql, $entetes);
        $taches = array();

        for ($i = 0; $i < count($res); $i++) {
            $id = $res[$i]["id"];
            $libelle = $res[$i]["libelle"];
            $estimation = $res[$i]["estimation"];
            $description = $res[$i]["description"];
            $etat = $res[$i]["etat"];
            $idProjet = $res[$i]["idProjet"];
            $idUser = $res[$i]["idUser"];

            $currentTache = new Tache($id, $libelle, $estimation, $description, $etat, $idProjet, $idUser);

            $taches[] = $currentTache;

        }


        return $taches;
    }

    public function getTacheWithIds($idProjet, $idTache)
    {

        $sql = "select id, libelle, estimation, description, etat, idProjet, (select fullname from users where id = tache.idUser) as user ";
        $sql .= "from tache where idProjet = ".$idProjet." and id = ".$idTache;
        $bdMan = new BdManager();
        $entetes = array("id","libelle","estimation","description","etat","idProjet","user");
        $res = $bdMan->executeSelect($sql,$entetes);
        $tache = null;

        if (count($res) > 0)
        {
            $_id = $res[0]["id"];
            $_libelle = $res[0]["libelle"];
            $_estimation = $res[0]["estimation"];
            $_description = $res[0]["description"];
            $_etat = $res[0]["etat"];
            $_idprojet = $res[0]["idProjet"];
            $user = $res[0]["user"];
            $tache = new Tache($_id, $_libelle, $_estimation, $_description, $_etat, $_idprojet, $user);
        }

        return $tache;

    }

    public function updateTache($idTache, $newTache)
    {
        $resultat = array (
            "code" => "ERROR",
            "message" => ""
        );
        $sql = "update tache set libelle = '".$newTache->libelle."' , estimation = '".$newTache->estimation."'";
        $sql .= " , description = '".$newTache->description."', etat = '".$newTache->etat."' , idProjet = ".$newTache->idProjet." , idUser = ";
        $sql .= "(select id from users where fullname = '".$newTache->user."') where id = ".$idTache;
        $bdMan = new BdManager();
        $bdMan->executeUpdate($sql);
        $resultat["code"] = "SUCCES";
        $resultat["message"] = "Projet mis a jour avec succes !";
        return $resultat;
    }

    public function createTache($newTache)
    {
        $resultat = array (
            "code" => "ERROR",
            "message" => ""
        );
        $sql = "insert into tache(libelle, estimation, description, etat, idProjet, idUser) values (";
        $sql .= "'".$newTache->libelle."',".$newTache->estimation.",'".$newTache->description."','".$newTache->etat."'";
        $sql .=",".$newTache->idProjet.",(select id from users where fullname = '".$newTache->user."'))";
        $bdMan = new BdManager();
        $bdMan->executeInsert($sql);
        $resultat["code"] = "SUCCES";
        $resultat["message"] = "Projet mis a jour avec succes !";
        return $resultat;
    }

    public function deleteTache($id){
        $resultat = array (
            "code" => "ERROR",
            "message" => ""
        );
        $sql = "delete from tache where id = ".$id;
        $bdMan = new BdManager();
        $bdMan->executeDelete($sql);
        $resultat["code"] = "SUCCES";
        $resultat["message"] = "Tache supprimée avec succes !";
        return $resultat;
    }

}

 ?>
