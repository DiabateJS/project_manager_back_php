<?php
include_once('config.php');
include_once('bd.php');
include_once('tache.php');
include_once('user.php');
include_once('constants.php');

class UserManager
{

    public function __construct()
    {

    }

    public function getAllUsers()
    {
        $sql = "select * from users ";
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
        $resultat = Helper::createResponseObject();
        $sql = "select * from users where login = :login and password = :password";
        $dicoParam = array(
          "login" => $login,
          "password" => $pwd
        );
        $bdMan = new BdManager();
        $entetes = array("id","fullname","login","password","email","profile");
        $res = $bdMan->executePreparedSelect($sql, $dicoParam, $entetes);
        if (count($res) > 0){
            $resultat["code"] = Constants::$SUCCES_CODE;
            $resultat["message"] = "";
            $resultat["fullname"] = $res[0]["fullname"];
            $resultat["id"] = $res[0]["id"];
        }
        return $resultat;
    }

    public function getUserById($idUser){
        $sql = "select * from users where id = :idUser";
        $dicoParam = array(
            "idUser" => $idUser
        );
        $bdMan = new BdManager();
        $entetes = array("id","fullname","login","password","email","profile");
        $res = $bdMan->executePreparedSelect($sql, $dicoParam, $entetes);
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
        $resultat = Helper::createResponseObject();;
        $sql = "update users set fullname = :fullname , login = :login , password = :password , email = :email , profile = :profile where id = :id";
        $dicoParam = array(
            "fullname" => $newUser->fullname,
            "login" => $newUser->login,
            "password" => $newUser->password,
            "email" => $newUser->email,
            "profile" => $newUser->profile,
            "id" => $id
        );
        $bdMan = new BdManager();
        $bdMan->executePreparedQuery($sql, $dicoParam);
        $resultat["code"] = Constants::$SUCCES_CODE;
        return $resultat;
    }

    public function createUser($newUser)
    {
        $resultat = Helper::createResponseObject();;
        $sql = "insert into users (fullname, login, password, email, profile) values (:fullname, :login, :password, :email, :profile)";
        $dicoParam = array(
            "fullname" => $newUser->fullname,
            "login" => $newUser->login,
            "password" => $newUser->password,
            "email" => $newUser->email,
            "profile" => $newUser->profile
        );
        $bdMan = new BdManager();
        $bdMan->executePreparedQuery($sql, $dicoParam);
        $resultat["code"] = Constants::$SUCCES_CODE;
        return $resultat;
    }

    public function addUserToProject($idUser, $idProjet){
        $resultat = Helper::createResponseObject();
        $dicoParam = array(
            "idProjet" => $idProjet,
            "idUser" => $idUser
        );
        $bdMan = new BdManager();
        $sql_exist = "select idProjet, idUser from visibilite_projet where idProjet = :idProjet and idUser = :idUser";
        $entete = array("idProjet","idUser");
        $res = $bdMan->executePreparedSelect($sql_exist, $dicoParam, $entete);
        if (count($res) == 0){
            $sql = "insert into visibilite_projet (idProjet, idUser) values (:idProjet, :idUser)";
            $bdMan->executePreparedQuery($sql, $dicoParam);
            $resultat["code"] = Constants::$SUCCES_CODE;
        }else{
            $resultat["code"] = Constants::$WARNING_CODE;
            $resultat["message"] = "Utilisateur déjà affecté au projet";
        }
        return $resultat;
    }

    public function deleteUser($id){
        $resultat = Helper::createResponseObject();
        $sql = "select * from tache where idUser = :idUser";
        $dicoParam = array(
            "idUser" => $id
        );
        $bdMan = new BdManager();
        $entete = array("id","libelle","estimation","description","etat","idProjet","idUser");
        $res = $bdMan->executePreparedSelect($sql, $dicoParam, $entete);
        if (count($res) == 0){
            $sql = "delete from users where id = :idUser";
            $bdMan->executePreparedQuery($sql, $dicoParam);
            $resultat["code"] = Constants::$SUCCES_CODE;
        }else{
            $resultat["code"] = Constants::$WARNING_CODE;
            $resultat["message"] = "Suppression impossible. Utilisateur affecté à une ou plusieurs taches.";
        }
        return $resultat;
    }
}

 ?>
