<?php
require_once '../../db.php';
require_once __DIR__ . '/../Model/activite.php';

class activiteController {

    public function listActivite() {
        $sql = "SELECT * FROM activite";
        $db = connexion::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo 'Erreur lors de la récupération des activités : ' . $e->getMessage();
            return [];
        }
    }

    public function getActiviteById($id) {
        try {
            $pdo = connexion::getConnexion();
            $query = $pdo->prepare("SELECT * FROM activite WHERE id = :id");
            $query->execute(['id' => $id]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function deleteActivite($id) {
        $sql = "DELETE FROM activite WHERE id = :id";
        $db = connexion::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function addActivite($activite) {
        try {
            $pdo = connexion::getConnexion();
            $query = $pdo->prepare("INSERT INTO activite (titre, description, date_activite, heure, type_activite, espace_id)
                                    VALUES (:titre, :description, :date_activite, :heure, :type_activite, :espace_id)");
            $query->execute([
                'titre' => $activite->getTitre(),
                'description' => $activite->getDescription(),
                'date_activite' => $activite->getDateActivite(),
                'heure' => $activite->getHeure(),
                'type_activite' => $activite->getTypeActivite(),
                'espace_id' => $activite->getEspaceId()
            ]);
        } catch (PDOException $e) {
            die('Erreur lors de l\'insertion : ' . $e->getMessage());
        }
    }

    public function listActiviteByEspace($idEspace) {
        try {
            $pdo = connexion::getConnexion();
    
            if (!$pdo) {
                throw new Exception("Failed to connect to the database.");
            }
            $query = $pdo->prepare("
            SELECT p.*, c.nom AS cespace_name 
            FROM activite p
            INNER JOIN espace c ON p.espace_id = c.id
            WHERE p.espace_id = :id
        ");
        
            $query->execute(['id' => $idEspace]);
            return $query->fetchAll();
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function updateActivite($activite, $id) {
        try {
            $db = connexion::getConnexion();
            $sql = 'UPDATE activite SET 
                        titre = :titre, 
                        description = :description,
                        date_activite = :date_activite,
                        heure = :heure,
                        type_activite = :type_activite,
                        espace_id = :espace_id
                    WHERE id = :id';

            $params = [
                'titre' => $activite->getTitre(),
                'description' => $activite->getDescription(),
                'date_activite' => $activite->getDateActivite(),
                'heure' => $activite->getHeure(),
                'type_activite' => $activite->getTypeActivite(),
                'espace_id' => $activite->getEspaceId(),
                'id' => $id
            ];

            $query = $db->prepare($sql);
            $query->execute($params);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

}

?>
