<?php
include_once('config.php');
include_once('bd.php');
include_once('tache.php');
include_once('user.php');

class UserManager
{

    public function __construct()
    {

    }

    public function getAllUsers()
    {
        $sql = "select * from pm_users ";
        $bdMan = new BdManager();
        $entetes = array("id","fullname","login","password","email","profile");
        $res = $bdMan->executeSelect($sql,$entetes);
        $users = array();

        for ($i = 0 ; $i < count($res) ; $i++)
        {
            $id = $res[$i]["id"];
            $fullname = $res[$i]["fullname"];
            $login = $res[$i]["login"];
            $password = $res[$i]["password"];
            $email = $res[$i]["email"];
            $profile = $res[$i]["profile"];

            $currentUser = new User($id,$fullname,$login,$password,$email,$profile);

            $users[] = $currentUser;

        }

        return $users;
    }

    function isAuth($login, $pwd){
        $resultat = array(
          "code" => "ERROR",
          "message" => ""
        );
        $sql = "select * from pm_users where login = '".$login."' and password = '".$pwd."'";
        $bdMan = new BdManager();
        $entetes = array("id","fullname","login","password","email","profile");
        $res = $bdMan->executeSelect($sql,$entetes);
        if (count($res) > 0){
            $resultat["code"] = "SUCCES";
            $resultat["message"] = $res[0]["fullname"];
        }
        return $resultat;
    }

    public function getUserById($idUser){
        $sql = "select * from pm_users where id = ".$idUser;
        $bdMan = new BdManager();
        $entetes = array("id","fullname","login","password","email","profile");
        $res = $bdMan->executeSelect($sql, $entetes);
        $_user = null;
        if (count($res) > 0)
        {
            $_id = $res[0]["id"];
            $_fullname = $res[0]["fullname"];
            $_login = $res[0]["login"];
            $_password = $res[0]["password"];
            $_email = $res[0]["email"];
            $_profile = $res[0]["profile"];
            $_user = new User($_id,$_fullname,$_login,$_password,$_email,$_profile);
        }
        return $_user;
    }

    public function updateUser($id, $newUser)
    {
        $resultat = array (
            "code" => "ERROR",
            "message" => ""
        );
        $sql = "update pm_users set fullname = '".$newUser->fullname."' , login = '".$newUser->login."'";
        $sql .= " , password = '".$newUser->password."', email = '".$newUser->email."' , profile = '".$newUser->profile."'";
        $sql .= " where id = ".$id;
        $bdMan = new BdManager();
        $bdMan->executeUpdate($sql);
        $resultat["code"] = "SUCCES";
        return $resultat;
    }

    public function createUser($newUser)
    {
        $resultat = array (
            "code" => "ERROR",
            "message" => ""
        );
        $sql = "insert into pm_users (fullname, login, password, email, profile) values (";
        $sql .= "'".$newUser->fullname."','".$newUser->login."','".$newUser->password."','".$newUser->email."','".$newUser->profile."')";
        $bdMan = new BdManager();
        $bdMan->executeInsert($sql);
        $resultat["code"] = "SUCCES";
        return $resultat;
    }

    public function deleteUser($id){
        $resultat = array (
            "code" => "ERROR",
            "message" => ""
        );
        $sql = "select * from pm_tache where idUser = ".$id;
        $bdMan = new BdManager();
        $entete = array("id","libelle","estimation","description","etat","idProjet","idUser");
        $res = $bdMan->executeSelect($sql, $entete);
        if (count($res) == 0){
            $sql = "delete from pm_users where id = ".$id;
            $bdMan->executeDelete($sql);
            $resultat["code"] = "SUCCES";
        }else{
            $resultat["code"] = "WARNING";
            $resultat["message"] = "Suppression impossible. Utilisateur affecté à une ou plusieurs taches.";
        }
        return $resultat;
    }
}

 ?>
