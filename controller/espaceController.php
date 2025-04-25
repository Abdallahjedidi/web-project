<?php
require_once '../../db.php';
require_once __DIR__ . '/../Model/espace.php';

class espaceController {

    public function listEspace() {
        // Logic to list espace or other functionality
        try {
            $pdo = connexion::getConnexion();
            $query = $pdo->prepare("SELECT * FROM espace");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function getEspaceById($id) {
        try {
            $pdo = connexion::getConnexion();
            $query = $pdo->prepare("SELECT * FROM espace WHERE id = :id");
            $query->execute(['id' => $id]);
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('PDO Error: ' . $e->getMessage());
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function deleteEspace($id) {
        $sql = "DELETE FROM espace WHERE id = :id";
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
            $query = $pdo->prepare("INSERT INTO espace (nom, description, adresse, ville, superficie, statut, image)
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
            $sql = 'UPDATE espace SET 
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
    
    
public function RechercheB($searchTerm)
{
    $sql = "SELECT * FROM espace WHERE adresse LIKE '%$searchTerm%' OR nom = '$searchTerm'";
    $db = connexion::getConnexion();

    try {
        $query = $db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die('Erreur: ' . $e->getMessage());
    }
}
public function TriEspace() {
    $sql = "SELECT * FROM espace ORDER BY id ASC"; // ou un autre tri selon les besoins
    $db = connexion::getConnexion();
    try {
        $liste = $db->query($sql);
        return $liste->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die('Erreur: ' . $e->getMessage());
    }
}



function Trisup() {
    $sql = "SELECT * FROM espace ORDER BY superficie ASC";
    $db = connexion::getConnexion();
    try {
        $liste = $db->query($sql);
        return $liste;
    } catch (Exception $e) {
        die('Erreur: ' . $e->getMessage());
    }
}

function Trisupdesc() {
    $sql = "SELECT * FROM espace ORDER BY superficie DESC";
    $db = connexion::getConnexion();
    try {
        $liste = $db->query($sql);
        return $liste;
    } catch (Exception $e) {
        die('Erreur: ' . $e->getMessage());
    }
}

}
?>
