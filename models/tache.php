<?php
include_once("config.php");
include_once("bd.php");

class Tache
{
    public $id;
    public $libelle;
    public $estimation;
    public $dateDebut;
    public $dateFin;
    public $description;
    public $etat;
    public $idProjet;
    public $user;

    /**
     * Tache constructor.
     * @param $id
     * @param $libelle
     * @param $estimation
     * @param $description
     * @param $etat
     * @param $idProjet
     * @param $user
     */
    public function __construct($id, $libelle, $estimation, $dateDebut, $dateFin, $description, $etat, $idProjet, $user)
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->estimation = $estimation;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->description = $description;
        $this->etat = $etat;
        $this->idProjet = $idProjet;
        $this->user = $user;
    }

}
?>
