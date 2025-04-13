<?php
    include_once '../../config.php';
    include_once '../../Model/vehicule.php';
class Vehiculec{

    public function addVehicule($vehicule)
{
    
    $db = config::getConnection();
    
    try {
        $query = $db->prepare(
            "INSERT INTO vehicule (id_vehicule, type, compagnie, accessibilte, etat, niveau_confort) 
             VALUES (:id_vehicule, :type, :compagnie, :accessibilte, :etat, :niveau_confort)"
        );
        
        $query->execute([
            ':id_vehicule' => $vehicule->getIdVehicule(),
            ':type' => $vehicule->getType(),
            ':compagnie' => $vehicule->getCompagnie(),
            ':accessibilte' => $vehicule->getAccessibilte(),
            ':etat' => $vehicule->getEtat(),
            ':niveau_confort' => $vehicule->getNiveauConfort(),
        ]);
        
        echo '
<div class="alert alert-success alert-dismissible fade show position-fixed" 
     style="top: 20px; right: 20px; z-index: 1050; min-width: 300px;" 
     role="alert" id="successAlert">
    ✅ Véhicule ajouté !
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
    }, 4000); // Disappears after 4 seconds
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
    }, 4000); // 4 seconds
</script>
';

    }
}
public function deleteVehicule($id_vehicule)
{
    $db = config::getConnection();

    try {
        $query = $db->prepare("DELETE FROM vehicule WHERE id_vehicule = :id_vehicule");
        $query->execute([
            ':id_vehicule' => $id_vehicule
        ]);

        echo '
<div class="alert alert-success alert-dismissible fade show position-fixed" 
     style="top: 20px; right: 20px; z-index: 1050; min-width: 300px;" 
     role="alert" id="successAlert">
    ✅ Véhicule supprimé !
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
    }, 4000); // Disappears after 4 seconds
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
    }, 4000); // 4 seconds
</script>
';
    }
}

public function afficherVehicule()
{
    $db = config::getConnection();

    try {
        $query = $db->query("SELECT * FROM vehicule");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return [];
    }
}

public function updateVehicule($data)
{
    $db = config::getConnection();
    try {
        $query = $db->prepare("
            UPDATE vehicule SET
                type = :type,
                compagnie = :compagnie,
                accessibilte = :accessibilte,
                etat = :etat,
                niveau_confort = :niveau_confort
            WHERE id_vehicule = :id_vehicule
        ");
        $query->execute([
            ':id_vehicule' => $data->getIdVehicule(),
            ':type' => $data->getType(),
            ':compagnie' => $data->getCompagnie(),
            ':accessibilte' => $data->getAccessibilte(),
            ':etat' => $data->getEtat(),
            ':niveau_confort' => $data->getNiveauConfort()
        ]);
        echo '
        <div class="alert alert-success alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 1050; min-width: 300px;" 
             role="alert" id="successAlert">
            ✅ Véhicule modifer !
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
            }, 4000); // Disappears after 4 seconds
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
            }, 4000); // 4 seconds
        </script>
        ';
    }
}
public function rechercher($id)
{
    $db = config::getConnection();
    $sql = "SELECT * FROM vehicule WHERE id_vehicule = :id";
    try {
        $query = $db->prepare($sql);
        $query->execute(['id' => $id]);
        return $query->fetchAll();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

}
?>