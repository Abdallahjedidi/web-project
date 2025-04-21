<?php
require_once '../../db.php';
require_once __DIR__ . '/../Model/reserver.php';

class reserverController {

    // Liste des réservations
    public function listReserver() {
        $sql = "SELECT * FROM reserver";
        $db = connexion::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();
            $reservations = $query->fetchAll(PDO::FETCH_ASSOC);
            
            if (empty($reservations)) {
                echo "Aucune réservation trouvée.";
            }
            
            return $reservations;
        } catch (Exception $e) {
            echo 'Erreur lors de la récupération des réservations : ' . $e->getMessage();
            return [];
        }
    }

    // Récupérer une réservation par ID
    public function getReserverById($id) {
        try {
            $pdo = connexion::getConnexion();
            $query = $pdo->prepare("SELECT * FROM reserver WHERE id = :id");
            $query->execute(['id' => $id]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Supprimer une réservation
    public function deleteReserver($id) {
        $sql = "DELETE FROM reserver WHERE id = :id";
        $db = connexion::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    // Ajouter une réservation
    public function addReserver($data) {
        try {
            $pdo = connexion::getConnexion();
            $query = $pdo->prepare("INSERT INTO reserver (activite_id, email, numtlf, date_inscription)
                                    VALUES (:activite_id, :email, :numtlf, :date_inscription)");
            $query->execute([
                'activite_id' => $data['activite_id'],
                'email' => $data['email'],
                'numtlf' => $data['numtlf'],
                'date_inscription' => $data['date_inscription']
            ]);
    
            // Récupérer l'ID de la réservation pour la redirection
            return $pdo->lastInsertId();  // Récupère l'ID de la réservation insérée
        } catch (PDOException $e) {
            die('Erreur lors de l\'insertion : ' . $e->getMessage());
        }
    }
    
    // Mettre à jour une réservation
    public function updateReserver($reserver, $id) {
        try {
            $db = connexion::getConnexion();
            $sql = 'UPDATE reserver SET 
                        activite_id = :activite_id, 
                        utilisateur_id = :utilisateur_id, 
                        email = :email,
                        numtlf = :numtlf,
                        date_inscription = :date_inscription
                    WHERE id = :id';
    
            $params = [
                'activite_id' => $reserver->getActiviteId(),
                'utilisateur_id' => $reserver->getUtilisateurId(),
                'email' => $reserver->getEmail(),
                'numtlf' => $reserver->getNumtlf(),
                'date_inscription' => $reserver->getDateInscription(),
                'id' => $id
            ];
    
            $query = $db->prepare($sql);
            $query->execute($params);
            echo $query->rowCount() . " enregistrement(s) modifié(s) avec succès.";
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}
?>
