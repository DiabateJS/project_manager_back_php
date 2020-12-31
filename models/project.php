<?php
include_once("config.php");
include_once("bd.php");

class Project
{
    public $id;
    public $libelle;
    public $etat;
    public $description;
    public $taches;

    /**
     * Project constructor.
     * @param $id
     * @param $libelle
     * @param $etat
     * @param $description
     */
    public function __construct($id, $libelle, $etat, $description, $taches)
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->etat = $etat;
        $this->description = $description;
        $this->taches = $taches;
    }

}
?>
