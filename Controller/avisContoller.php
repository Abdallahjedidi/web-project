<?php
include_once '../../config.php';
include_once '../../Model/avis.php';

class AvisController {

    public function addAvis($avis) {
        $db = config::getConnection();
    
        try {
            $query = $db->prepare(
                "INSERT INTO avis (id, id_event, name, description, reported_at) 
                 VALUES (:id, :event_id, :name, :description, :reported_at)"
            );
    
            $query->execute([
                ':id' => $avis->getId(),
                ':event_id' => $avis->getIdEvent(),
                ':name' => $avis->getName(),
                ':description' => $avis->getDescription(),
                ':reported_at' => $avis->getReportedAt(),
            ]);

            echoSuccessAlert("✅ Ajout réussi !");
        } catch (PDOException $e) {
            echoErrorAlert($e->getMessage());
        }
    }

    public function deleteAvis($id) {
        $db = config::getConnection();

        try {
            $query = $db->prepare("DELETE FROM avis WHERE id = :id");
            $query->execute([':id' => $id]);

            echoSuccessAlert("✅ Supprimé avec succès !");
        } catch (PDOException $e) {
            echoErrorAlert($e->getMessage());
        }
    }

    public function afficherAvis() {
        $db = config::getConnection();

        try {
            $query = $db->query("SELECT * FROM avis");
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return [];
        }
    }

    public function updateAvis($data) {
        $db = config::getConnection();

        try {
            $query = $db->prepare("
                UPDATE avis SET
                    id_event = :event_id,
                    name = :name,
                    description = :description,
                    reported_at = :reported_at
                WHERE id = :id
            ");
            
            $query->execute([
                
                ':id' => $data->getId(),
                ':event_id' => $data->getIdEvent(),
                ':name' => $data->getName(),
                ':description' => $data->getDescription(),
                ':reported_at' => $data->getReportedAt()
            ]);

            echoSuccessAlert("✅ Modification réussie !");
        } catch (PDOException $e) {
            echoErrorAlert($e->getMessage());
        }
    }

    public function rechercher($id) {
        $db = config::getConnection();
        $sql = "SELECT * FROM avis WHERE id = :id";

        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            return $query->fetchAll();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

public function getAvisById($id)
    {
        $sql = "SELECT * FROM avis WHERE id = :id";
        $db = config::getConnection();
        try {
            $query = $db->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    }function echoSuccessAlert($message) {
    echo '
    <div class="alert alert-success alert-dismissible fade show position-fixed" 
         style="top: 20px; right: 20px; z-index: 1050; min-width: 300px;" 
         role="alert" id="successAlert">
        ' . $message . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <script>
        setTimeout(function() {
            let alert = document.getElementById("successAlert");
            if (alert) {
                alert.classList.remove("show");
                alert.classList.add("fade");
            }
        }, 4000);
    </script>
    ';
}

function echoErrorAlert($errorMessage) {
    echo '
    <div class="alert alert-danger alert-dismissible fade show position-fixed" 
         style="top: 20px; right: 20px; z-index: 1050; min-width: 300px;" 
         role="alert" id="errorAlert">
        Erreur : ' . htmlspecialchars($errorMessage) . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <script>
        setTimeout(function() {
            let alert = document.getElementById("errorAlert");
            if (alert) {
                alert.classList.remove("show");
                alert.classList.add("fade");
            }
        }, 4000);
    </script>
    ';
}
?>
