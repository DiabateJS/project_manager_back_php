<?php
include_once('bd.php');
include_once("statistique.php");
include_once("statItem.php");
include_once ("tacheParUserItem.php");

class StatistiqueManager
{

    /**
     * statistiqueManager constructor.
     */
    public function __construct()
    {
    }

    private function getCountProjects(){
        $entete = array("nbre");
        $bdMan = new BdManager();
        $res = $bdMan->executeSelect(Constants::$SQL_COUNT_PROJECTS, $entete);
        $nbre = 0;
        if (count($res) == 1){
            $nbre = $res[0]["nbre"];
        }
        return $nbre;
    }

    private function getCountTasks(){
        $entete = array("nbre");
        $bdMan = new BdManager();
        $res = $bdMan->executeSelect(Constants::$SQL_COUNT_TASKS, $entete);
        $nbre = 0;
        if (count($res) == 1){
            $nbre = $res[0]["nbre"];
        }
        return $nbre;
    }

    private function getProjetsByState(){
        $bdMan = new BdManager();
        $entete = array("etat", "nbre");
        $res = $bdMan->executeSelect(Constants::$SQL_PROJECTS_BY_STATE, $entete);
        $item = null;
        $states = array();
        for ($i = 0 ; $i < count($res) ; $i++)
        {
            $item = new StatItem();
            $item->libelle = $res[$i]["etat"];
            $item->nbre = $res[$i]["nbre"];
            $states[] = $item;
        }
        return $states;
    }

    private function getTaskByState() {
        $bdMan = new BdManager();
        $entete = array("etat", "nbre");
        $res = $bdMan->executeSelect(Constants::$SQL_TASKS_BY_STATE, $entete);
        $states = array();
        $item = null;
        for ($i = 0 ; $i < count($res) ; $i++){
            $item = new StatItem();
            $item->libelle = $res[$i]["etat"];
            $item->nbre = $res[$i]["nbre"];
            $states[] = $item;
        }
        return $states;
    }

    private function getTaskByProject() {
        $bdMan = new BdManager();
        $entete = array("projet", "tache");
        $res = $bdMan->executeSelect(Constants::$SQL_TASKS_BY_PROJECT, $entete);
        $projects = array();
        $item = null;
        for ($i = 0 ; $i < count($res) ; $i++){
            $item = new StatItem();
            $item->libelle = $res[$i]["projet"];
            $item->nbre = $res[$i]["tache"];
            $projects[] = $item;
        }
        return $projects;
    }

    private function getStateByUser() {
        $bdMan = new BdManager();
        $entete = array("fullname", "etat","tache");
        $res = $bdMan->executeSelect(Constants::$SQL_STATE_BY_USERS, $entete);
        $item = null;
        $users = array();
        $states = array();
        $userItem = null;
        $item = null;
        for ($i = 0 ; $i < count($res) ; $i++){
            $fullname = $res[$i]["fullname"];
            $item = new StatItem();
            $item->libelle = $res[$i]["etat"];
            $item->nbre = $res[$i]["tache"];
            if (!array_key_exists($fullname, $states)){
                $states[$fullname] = array(
                    "etats" => array($item)
                );
            }else{
                $states[$fullname]["etats"][] = $item;
            }
        }
        foreach($states as $fullname => $etats){
            $userItem = new TacheParUserItem();
            $userItem->fullname = $fullname;
            $userItem->nbre = count($etats["etats"]);
            $userItem->etats = $etats["etats"];
            $users[] = $userItem;
        }
        return $users;
    }

    public function getStats(){
        $stats = new Statistique();
        $stats->nbreProjets = $this->getCountProjects();
        $stats->nbreTaches = $this->getCountTasks();
        $stats->projetsParEtat = $this->getProjetsByState();
        $stats->tachesParEtat = $this->getTaskByState();
        $stats->tachesParProjet = $this->getTaskByProject();
        $stats->tachesParUser = $this->getStateByUser();
        return $stats;
    }
}
