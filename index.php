<?php
    include_once('models/config.php');
  include_once('apiauthent.php');
  include_once('models/projectManager.php');
  include_once('models/userManager.php');
  include_once('models/statistiqueManager.php');
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

        
    $client_key = isset($_GET["api_key"]) ? $_GET["api_key"] : "";

    $oApiKey = new ApiAuth();


  $operation = isset($_GET["operation"]) ? $_GET["operation"] : "";
  $type = isset($_GET["type"]) ? $_GET["type"] : "";

  $data = json_decode(file_get_contents("php://input"));

  if ($operation == "enum"){
      if ($type == "projets"){
          $projetManager = new ProjectManager();
          echo json_encode($projetManager->getAllProjects());
      }
      if ($type == "user_projects"){
          $projetManager = new ProjectManager();
          $idUser = $_GET["idUser"] ?? "";
          echo json_encode($projetManager->getUserProjects($idUser));
      }
      if ($type == "projet"){
          $projetManager = new ProjectManager();
          $idProjet = isset($_GET["idProjet"]) ? $_GET["idProjet"] : "";
          echo json_encode($projetManager->getProjectById($idProjet));
      }
      if ($type == "projet_taches"){
          $idProjet = isset($_GET["idProjet"]) ? $_GET["idProjet"] : "";
          $tacheManager = new TacheManager();
          echo json_encode($tacheManager->getAllProjectsTache($idProjet));
      }
      if ($type == "projet_tache"){
          $idProjet = isset($_GET["idProjet"]) ? $_GET["idProjet"] : "";
          $idTache = isset($_GET["idTache"]) ? $_GET["idTache"] : "";
          $tacheManager = new TacheManager();
          echo json_encode($tacheManager->getTacheWithIds($idProjet, $idTache));
      }
      if ($type == "users"){
          $userManager = new UserManager();
          echo json_encode($userManager->getAllUsers());
      }
      if ($type == "user"){
          $id = isset($_GET["id"]) ? $_GET["id"] : "";
          $userManager = new UserManager();
          echo json_encode($userManager->getUserById($id));
      }
  }
  if ($operation == "auth"){
      $login = isset($_POST["login"]) ? $_POST["login"] : "";
      $pwd = isset($_POST["password"]) ? $_POST["password"] : "";
      $userManager = new UserManager();
      echo json_encode($userManager->isAuth($login, $pwd));
  }
    if ($operation == "update"){
        if ($type == "projet"){
            $idProjet = $data->idProjet ?? "";
            $libelle = $data->libelle ?? "";
            $etat = $data->etat ?? "";
            $dateDebut = $data->dateDebut ?? "";
            $dateFin = $data->dateFin ?? "";
            $description = $data->description ?? "";
            $newProjet = new Project($idProjet,$libelle,$etat,$dateDebut, $dateFin, $description,[]);
            $projetManager = new ProjectManager();
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
            $tacheManager = new TacheManager();
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
            $userManager = new UserManager();
            echo json_encode($userManager->updateUser($id, $newUser));
        }
    }
    if ($operation == "create"){
        if ($type == "projet"){
            $idProjet = $data->idProjet ?? "";
            $libelle = $data->libelle ?? "";
            $etat = $data->etat ?? "";
            $dateDebut = $data->dateDebut ?? "";
            $dateFin = $data->dateFin ?? "";
            $description = $data->description ?? "";
            $newProjet = new Project($idProjet,$libelle,$etat,$dateDebut, $dateFin, $description,[]);
            $projetManager = new ProjectManager();
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
            $tacheManager = new TacheManager();
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
            $userManager = new UserManager();
            echo json_encode($userManager->createUser($newUser));
        }
        if ($type == "add_to_project"){
            $idUser = $data->idUser ?? "";
            $idProject = $data->idProject ?? "";
            $userManager = new UserManager();
            echo json_encode($userManager->addUserToProject($idUser,$idProject));
        }
    }
    if ($operation == "delete"){
        if ($type == "projet"){
            $id = isset($_GET["id"]) ? $_GET["id"] : "";
            $projetManager = new ProjectManager();
            echo json_encode($projetManager->deleteProject($id));
        }
        if ($type == "tache"){
            $id = isset($_GET["id"]) ? $_GET["id"] : "";
            $tacheManager = new TacheManager();
            echo json_encode($tacheManager->deleteTache($id));
        }
        if ($type == "user"){
            $id = isset($_GET["id"]) ? $_GET["id"] : "";
            $userManager = new UserManager();
            echo json_encode($userManager->deleteUser($id));
        }
    }
    if ($operation == "stat"){
        $statManager = new statistiqueManager();
        echo json_encode($statManager->getStats());
    }




?>
