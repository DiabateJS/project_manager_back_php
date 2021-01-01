<?php
include_once('config.php');
include_once('bd.php');
include_once('tache.php');
include_once('constants.php');


class TacheManager
{

    public function __construct()
    {

    }

    public function getAllProjectsTache($idProjet)
    {
        $sql = "select * from tache where idProjet = :idProjet";
        $dicoParam = array(
            "idProjet" => $idProjet
        );
        $bdMan = new BdManager();
        $entetes = array("id", "libelle", "estimation", "description", "etat", "idProjet", "idUser");
        $res = $bdMan->executePreparedSelect($sql, $dicoParam, $entetes);
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
        $sql .= "from tache where idProjet = :idProjet and id = :idTache";
        $dicoParam = array(
          "idProjet" => $idProjet,
          "idTache" => $idTache
        );
        $bdMan = new BdManager();
        $entetes = array("id","libelle","estimation","description","etat","idProjet","user");
        $res = $bdMan->executePreparedSelect($sql, $dicoParam, $entetes);
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
        $resultat = Helper::createResponseObject();
        $sql = "update tache set libelle = :libelle , estimation = :estimation , description = :description , etat = :etat , idProjet = :idProjet , idUser = ";
        $sql .= "(select id from users where fullname = :user) where id = :idTache";
        $dicoParam = array(
            "libelle" => $newTache->libelle,
            "estimation" => $newTache->estimation,
            "description" => $newTache->description,
            "etat" => $newTache->etat,
            "idProjet" => $newTache->idProjet,
            "user" => $newTache->user,
            "idTache" => $idTache
        );
        $bdMan = new BdManager();
        $bdMan->executePreparedQuery($sql, $dicoParam);
        $resultat["code"] = Constants::$SUCCES_CODE;
        $resultat["message"] = "Projet mis a jour avec succes !";
        return $resultat;
    }

    public function createTache($newTache)
    {
        $resultat = Helper::createResponseObject();
        $sql = "insert into tache(libelle, estimation, description, etat, idProjet, idUser) values (:libelle, :estimation, :description, :etat, :idProjet";
        $sql .=" ,(select id from users where fullname = :user))";
        $dicoParam = array (
          "libelle" => $newTache->libelle,
          "estimation" => $newTache->estimation,
          "description" => $newTache->description,
          "etat" => $newTache->etat,
          "idProjet" => $newTache->idProjet,
          "user" => $newTache->user
        );
        $bdMan = new BdManager();
        $bdMan->executePreparedQuery($sql, $dicoParam);
        $resultat["code"] = Constants::$SUCCES_CODE;
        $resultat["message"] = "Projet mis a jour avec succes !";
        return $resultat;
    }

    public function deleteTache($id){
        $resultat = Helper::createResponseObject();
        $sql = "delete from tache where id = :idTache";
        $dicoParam = array(
            "idTache" => $id
        );
        $bdMan = new BdManager();
        $bdMan->executePreparedQuery($sql, $dicoParam);
        $resultat["code"] = Constants::$SUCCES_CODE;
        $resultat["message"] = "Tache supprimée avec succes !";
        return $resultat;
    }

}

 ?>
