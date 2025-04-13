<?php
class Rapport{
    private $id_rapport;
    private $id_vehicule_lie;
    private $utilisateur_nom;
    private $date_signalement;
    private $type_probleme;
    private $description;
    private $photo;
    private $statut;

    public function setIdRapport($id_rapport) {
        $this->id_rapport = $id_rapport;
    }

    public function setIdVehiculeLie($id_vehicule_lie) {
        $this->id_vehicule_lie = $id_vehicule_lie;
    }

    public function setUtilisateurNom($utilisateur_nom) {
        $this->utilisateur_nom = $utilisateur_nom;
    }

    public function setDateSignalement($date_signalement) {
        $this->date_signalement = $date_signalement;
    }

    public function setTypeProbleme($type_probleme) {
        $this->type_probleme = $type_probleme;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setPhoto($photo) {
        $this->photo = $photo;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
    }

    public function getIdRapport() {
        return $this->id_rapport;
    }

    public function getIdVehiculeLie() {
        return $this->id_vehicule_lie;
    }

    public function getUtilisateurNom() {
        return $this->utilisateur_nom;
    }

    public function getDateSignalement() {
        return $this->date_signalement;
    }

    public function getTypeProbleme() {
        return $this->type_probleme;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPhoto() {
        return $this->photo;
    }

    public function getStatut() {
        return $this->statut;
    }
}
?>
