<?php
    include_once '../../config.php';
    include_once '../../Model/rapport.php';
class Rapportc{

    public function addRapport($rapport)
{
    $db = config::getConnection();

    try {
        $query = $db->prepare(
            "INSERT INTO rapport (id_rapport, matricule_lie, utilisateur_nom, date_signalement, type_probleme, description, photo, statut) 
             VALUES (:id_rapport, :matricule_lie, :utilisateur_nom, :date_signalement, :type_probleme, :description, :photo, :statut)"
        );

        $query->bindValue(':id_rapport', $rapport->getIdRapport(), PDO::PARAM_INT);
        $query->bindValue(':matricule_lie', $rapport->getmatriculeLie(), PDO::PARAM_STR);
        $query->bindValue(':utilisateur_nom', $rapport->getUtilisateurNom(), PDO::PARAM_STR);
        $query->bindValue(':date_signalement', $rapport->getDateSignalement(), PDO::PARAM_STR);
        $query->bindValue(':type_probleme', $rapport->getTypeProbleme(), PDO::PARAM_STR);
        $query->bindValue(':description', $rapport->getDescription(), PDO::PARAM_STR);
        $query->bindValue(':statut', $rapport->getStatut(), PDO::PARAM_STR);

        if ($rapport->getPhoto() !== null) {
            $query->bindValue(':photo', $rapport->getPhoto(), PDO::PARAM_LOB);
        } else {
            $query->bindValue(':photo', null, PDO::PARAM_NULL);
        }

        $query->execute();

        echo '
<div class="alert alert-success alert-dismissible fade show position-fixed" 
     style="top: 20px; right: 20px; z-index: 1050; min-width: 300px;" 
     role="alert" id="successAlert">
    ✅ Rapport ajouté avec succès !
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

    } catch (PDOException $e) {
        echo '
<div class="alert alert-danger alert-dismissible fade show position-fixed" 
     style="top: 20px; right: 20px; z-index: 1050; min-width: 300px;" 
     role="alert" id="errorAlert">
    Erreur : ' . htmlspecialchars($e->getMessage()) . '
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
}

public function afficherRAPPORT()
{
    $db = config::getConnection();

    try {
        $query = $db->query("SELECT * FROM rapport");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return [];
    }
}



    public function updateRapportStatus($rapportId, $status) {
        $db = config::getConnection();
        try {
            $stmt = $db->prepare("UPDATE rapport SET statut = :statut WHERE id_rapport = :id_rapport");
            $stmt->bindParam(':statut', $status);
            $stmt->bindParam(':id_rapport', $rapportId);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    public function deleteRapport($rapportId) {
        $db = config::getConnection();
        try {
            $stmt = $db->prepare("DELETE FROM rapport WHERE id_rapport = :id_rapport");
            $stmt->bindParam(':id_rapport', $rapportId);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}



?>