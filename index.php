<?php
  include_once('models/config.php');
  include_once('models/constants.php');
  include_once('apiauthent.php');
  include_once('models/projectManager.php');
  include_once('models/userManager.php');
  include_once('models/statistiqueManager.php');
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  $method = strtolower(isset($_GET[Constants::$METHOD_PARAM]) ? $_GET[Constants::$METHOD_PARAM] : Constants::$EMPTY_STRING);
  $type = strtolower(isset($_GET[Constants::$TYPE_PARAM]) ? $_GET[Constants::$TYPE_PARAM] : Constants::$EMPTY_STRING);

  $data = json_decode(file_get_contents("php://input"));
  $userManager = new UserManager();
  $projetManager = new ProjectManager();
  $tacheManager = new TacheManager();
  $userManager = new UserManager();
  $statManager = new statistiqueManager();

  if ($method == Constants::$METHOD_GET){
      if ($type == Constants::$TYPE_PROJETS){
          echo json_encode($projetManager->getAllProjects());
      }
      if ($type == "user_projects"){
          $idUser = $_GET["idUser"] ?? "";
          echo json_encode($projetManager->getUserProjects($idUser));
      }
      if ($type == Constants::$TYPE_PROJET){
          $idProjet = isset($_GET[Constants::$ID_PROJET]) ? $_GET[Constants::$ID_PROJET] : Constants::$EMPTY_STRING;
          echo json_encode($projetManager->getProjectById($idProjet));
      }
      if ($type == "projet_taches"){
          $idProjet = isset($_GET["idProjet"]) ? $_GET["idProjet"] : "";
          echo json_encode($tacheManager->getAllProjectsTache($idProjet));
      }
      if ($type == "projet_tache"){
          $idProjet = isset($_GET["idProjet"]) ? $_GET["idProjet"] : "";
          $idTache = isset($_GET["idTache"]) ? $_GET["idTache"] : "";
          echo json_encode($tacheManager->getTacheWithIds($idProjet, $idTache));
      }
      if ($type == "users"){
          echo json_encode($userManager->getAllUsers());
      }
      if ($type == "user"){
          $id = isset($_GET["id"]) ? $_GET["id"] : "";
          echo json_encode($userManager->getUserById($id));
      }
  }
    if ($method == "update"){
        if ($type == "projet"){
            $idProjet = $data->idProjet ?? "";
            $libelle = $data->libelle ?? "";
            $etat = $data->etat ?? "";
            $dateDebut = $data->dateDebut ?? "";
            $dateFin = $data->dateFin ?? "";
            $description = $data->description ?? "";
            $newProjet = new Project($idProjet,$libelle,$etat,$dateDebut, $dateFin, $description,[]);
            echo json_encode($projetManager->updateProject($idProjet, $newProjet));
        }
        if ($type == "tache"){
            $idTache = $data->idTache ?? "";
            $idProjet = $data->idProjet ?? "";
            $libelle = $data->libelle ?? "";
            $estimation = $data->estimation ?? "";
            $etat = $data->etat ?? "";
            $dateDebut = $data->dateDebut ?? "";
            $dateFin = $data->dateFin ?? "";
            $description = $data->description ?? "";
            $user = $data->user ?? "";
            $newTache = new Tache($idTache, $libelle, $estimation, $dateDebut, $dateFin, $description, $etat, $idProjet, $user);
            echo json_encode($tacheManager->updateTache($idTache, $newTache));
        }
        if ($type == "user"){
            $id = $data->id ?? "";
            $fullname = $data->fullname ?? "";
            $login = $data->login ?? "";
            $password = $data->password ?? "";
            $email = $data->email ?? "";
            $profile = $data->profile ?? "";
            $newUser = new User($id, $fullname, $login, $password, $email, $profile);
            echo json_encode($userManager->updateUser($id, $newUser));
        }
    }
    if ($method == "create"){
        if ($type == "projet"){
            $idProjet = $data->idProjet ?? "";
            $libelle = $data->libelle ?? "";
            $etat = $data->etat ?? "";
            $dateDebut = $data->dateDebut ?? "";
            $dateFin = $data->dateFin ?? "";
            $description = $data->description ?? "";
            $newProjet = new Project($idProjet,$libelle,$etat,$dateDebut, $dateFin, $description,[]);
            echo json_encode($projetManager->createProject($newProjet));
        }
        if ($type == "tache"){
            $idTache = $data->idTache ?? "";
            $idProjet = $data->idProjet ?? "";
            $libelle = $data->libelle ?? "";
            $estimation = $data->estimation ?? "";
            $etat = $data->etat ?? "";
            $dateDebut = $data->dateDebut ?? "";
            $dateFin = $data->dateFin ?? "";
            $description = $data->description ?? "";
            $user = $data->user ?? "";
            $newTache = new Tache($idTache, $libelle, $estimation, $dateDebut, $dateFin, $description, $etat, $idProjet, $user);
            echo json_encode($tacheManager->createTache($newTache));
        }
        if ($type == "user"){
            $id = $data->id ?? "";
            $fullname = $data->fullname ?? "";
            $login = $data->login ?? "";
            $password = $data->password ?? "";
            $email = $data->email ?? "";
            $profile = $data->profile ?? "";
            $newUser = new User($id, $fullname, $login, $password, $email, $profile);
            echo json_encode($userManager->createUser($newUser));
        }
        if ($type == "add_to_project"){
            $idUser = $data->idUser ?? "";
            $idProject = $data->idProject ?? "";
            echo json_encode($userManager->addUserToProject($idUser,$idProject));
        }
    }
    if ($method == "delete"){
        if ($type == "projet"){
            $id = isset($_GET["id"]) ? $_GET["id"] : "";
            echo json_encode($projetManager->deleteProject($id));
        }
        if ($type == "tache"){
            $id = isset($_GET["id"]) ? $_GET["id"] : "";
            echo json_encode($tacheManager->deleteTache($id));
        }
        if ($type == "user"){
            $id = isset($_GET["id"]) ? $_GET["id"] : "";
            echo json_encode($userManager->deleteUser($id));
        }
    }
    if ($method == "stat"){
        echo json_encode($statManager->getStats());
    }




?>
