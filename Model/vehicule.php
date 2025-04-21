<?php
class Vehicule {
    private $matricule;
    private $type;
    private $compagnie;
    private $accessibilte;
    private $etat;
    private $niveau_confort;

    public function setmatricule($matricule) {
        $this->matricule = $matricule;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setCompagnie($compagnie) {
        $this->compagnie = $compagnie;
    }

    public function setAccessibilte($accessibilte) {
        $this->accessibilte = $accessibilte;
    }

    public function setEtat($etat) {
        $this->etat = $etat;
    }

    public function setNiveauConfort($niveau_confort) {
        $this->niveau_confort = $niveau_confort;
    }

    public function getmatricule() {
        return $this->matricule;
    }

    public function getType() {
        return $this->type;
    }

    public function getCompagnie() {
        return $this->compagnie;
    }

    public function getAccessibilte() {
        return $this->accessibilte;
    }

    public function getEtat() {
        return $this->etat;
    }

    public function getNiveauConfort() {
        return $this->niveau_confort;
    }
}
?>
