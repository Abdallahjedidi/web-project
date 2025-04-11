<?php
require_once 'C:\xampp\htdocs\espace\db.php';
require_once __DIR__ . '/../Model/espace.php';

class espaceController {

    public function listEspace() {
        $sql = "SELECT * FROM espaces";
        $db = connexion::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();
            $espace = $query->fetchAll(PDO::FETCH_ASSOC);
            
            if (empty($espace)) {
                echo "Aucun espace trouvé.";
            }
            
            return $espace;
        } catch (Exception $e) {
            echo 'Erreur lors de la récupération des espaces : ' . $e->getMessage();
            return [];
        }
    }

    public function getEspaceById($id) {
        try {
            $pdo = connexion::getConnexion();
            $query = $pdo->prepare("SELECT * FROM espaces WHERE id = :id");
            $query->execute(['id' => $id]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function deleteEspace($id) {
        $sql = "DELETE FROM espaces WHERE id = :id";
        $db = connexion::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function addEspace($espace)
    {
        try {
            $pdo = connexion::getConnexion();
            $query = $pdo->prepare("INSERT INTO espaces (nom, description, adresse, ville, superficie, statut, image)
                                    VALUES (:nom, :description, :adresse, :ville, :superficie, :statut, :image)");
            $query->execute([
                'nom' => $espace->getNom(),
                'description' => $espace->getDescription(),
                'adresse' => $espace->getAdresse(),
                'ville' => $espace->getVille(),
                'superficie' => $espace->getSuperficie(),
                'statut' => $espace->getStatut(),
                'image' => $espace->getImage()
            ]);
        } catch (PDOException $e) {
            die('Erreur lors de l\'insertion : ' . $e->getMessage());
        }
    }
    
    
    

    public function updateEspace($espace, $id) {
        try {
            $db = connexion::getConnexion();
            $sql = 'UPDATE espaces SET 
                        nom = :nom, 
                        description = :description,
                        adresse = :adresse,
                        ville = :ville,
                        superficie = :superficie,
                        statut = :statut,
                        image = :image
                    WHERE id = :id';
    
            $params = [
                'nom' => $espace->getNom(),
                'description' => $espace->getDescription(),
                'adresse' => $espace->getAdresse(),
                'ville' => $espace->getVille(),
                'superficie' => $espace->getSuperficie(),
                'statut' => $espace->getStatut(),
                'image' => $espace->getImage(),
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
