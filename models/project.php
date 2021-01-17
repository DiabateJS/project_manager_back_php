<?php
include_once("config.php");
include_once("bd.php");

class Project
{
    public $id;
    public $libelle;
    public $etat;
    public $dateDebut;
    public $dateFin;
    public $description;
    public $taches;

    /**
     * Project constructor.
     * @param $id
     * @param $libelle
     * @param $etat
     * @param $description
     */
    public function __construct($id, $libelle, $etat, $dateDebut, $dateFin, $description, $taches)
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->etat = $etat;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->description = $description;
        $this->taches = $taches;
    }

}
?>
