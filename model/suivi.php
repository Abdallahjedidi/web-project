<?php

class Suivi {
    private $id_suivi;
    private $id_signalement;
    private $date_suivi;
    private $service_responsable;
    private $statut;
    private $description;

    // Getters
    public function getIdSuivi() {
        return $this->id_suivi;
    }

    public function getIdSignalement() {
        return $this->id_signalement;
    }

    public function getDateSuivi() {
        return $this->date_suivi;
    }

    public function getServiceResponsable() {
        return $this->service_responsable;
    }

    public function getStatut() {
        return $this->statut;
    }

    public function getDescription() {
        return $this->description;
    }

    // Setters
    public function setIdSuivi($id_suivi) {
        $this->id_suivi = $id_suivi;
    }

    public function setIdSignalement($id_signalement) {
        $this->id_signalement = $id_signalement;
    }

    public function setDateSuivi($date_suivi) {
        $this->date_suivi = $date_suivi;
    }

    public function setServiceResponsable($service_responsable) {
        $this->service_responsable = $service_responsable;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
}
?>
