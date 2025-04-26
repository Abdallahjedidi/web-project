<?php

include_once '../../config.php';
include_once '../../model/Suivi.php';




class SuiviC {
    private $db;

    public function __construct() {
        $this->db = config::getConnection();
    }

    public function ajouterSuivi(Suivi $suivi) {
        try {
            $sql = "INSERT INTO suivi (id_signalement, date_suivi, service_responsable, statut, description)
                    VALUES (:id_signalement, :date_suivi, :service_responsable, :statut, :description)";
            $req = $this->db->prepare($sql);

            $req->execute([
                ':id_signalement' => $suivi->getIdSignalement(),
                ':date_suivi' => $suivi->getDateSuivi(),
                ':service_responsable' => $suivi->getServiceResponsable(),
                ':statut' => $suivi->getStatut(),
                ':description' => $suivi->getDescription()
            ]);
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout du suivi : " . $e->getMessage();
        }
    }




    // Afficher tous les Suivis
    public function afficherSuivis() {
        $sql = "SELECT * FROM suivi";
        $req = $this->db->query($sql);
        return $req->fetchAll();
    }

    // Supprimer un Suivi
    public function supprimerSuivi($id_suivi) {
        $sql = "DELETE FROM suivi WHERE id_suivi = :id_suivi";
        $req = $this->db->prepare($sql);
        $req->bindValue(':id_suivi', $id_suivi);
        $req->execute();
    }

    // Modifier un Suivi
    public function modifierSuivi(Suivi $suivi) {
        $sql = "UPDATE suivi SET 
                    id_signalement = :id_signalement, 
                    date_suivi = :date_suivi, 
                    service_responsable = :service_responsable, 
                    statut = :statut, 
                    description = :description
                WHERE id_suivi = :id_suivi";

        $req = $this->db->prepare($sql);

        $req->bindValue(':id_suivi', $suivi->getIdSuivi());
        $req->bindValue(':id_signalement', $suivi->getIdSignalement());
        $req->bindValue(':date_suivi', $suivi->getDateSuivi());
        $req->bindValue(':service_responsable', $suivi->getServiceResponsable());
        $req->bindValue(':statut', $suivi->getStatut());
        $req->bindValue(':description', $suivi->getDescription());

        $req->execute();
    }
    // Chercher tous les suivis d'un signalement donné
public function getSuivisBySignalement($id_signalement) {
    $sql = "SELECT * FROM suivi WHERE id_signalement = :id_signalement";
    $req = $this->db->prepare($sql);
    $req->bindValue(':id_signalement', $id_signalement);
    $req->execute();
    return $req->fetchAll();
}


    

    // Récupérer un Suivi par son id (utile pour modifier)
    public function recupererSuivi($id_suivi) {
        $sql = "SELECT * FROM suivi WHERE id_suivi = :id_suivi";
        $req = $this->db->prepare($sql);
        $req->bindValue(':id_suivi', $id_suivi);
        $req->execute();
        return $req->fetch();
    }
}

?>