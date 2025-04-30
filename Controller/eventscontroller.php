<?php
    include_once '../../config.php';
    include_once '../../Model/events.php';
class eventcontroller{
    public function addevent($event, $image)
    {
        $db = config::getConnection();
        
        try {
            // Process the image upload
            $imagePath = null; // Default to null if no image is uploaded
    
            if ($image['error'] == 0) {
                // Get image details
                $imageName = $image['name'];
                $imageTmp = $image['tmp_name'];
                $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
                $imagePath = 'uploads/' . uniqid() . '.' . $imageExtension;
    
                // Move the uploaded image to the 'uploads' directory
                if (!move_uploaded_file($imageTmp, $imagePath)) {
                    throw new Exception("Failed to upload image.");
                }
            }
    
            // Insert event data into the database with the image path
            $query = $db->prepare(
                "INSERT INTO events (title, description, date, location, organizer_id, image, latitude, longitude) 
                 VALUES (:title, :description, :date, :location, :organizer_id, :image, :latitude, :longitude)"
            );
            
            $query->execute([
                ':title' => $event->gettitle(),
                ':description' => $event->getdescription(),
                ':date' => $event->getdate(),
                ':location' => $event->getlocation(),
                ':organizer_id' => $event->getorganizer_id(),
                ':image' => $imagePath,
                ':latitude' => $event->getLatitude(),
                ':longitude' => $event->getLongitude()
            ]);
            
            
            echo '
    <div class="alert alert-success alert-dismissible fade show position-fixed" 
         style="top: 20px; right: 20px; z-index: 1050; min-width: 300px;" 
         role="alert" id="successAlert">
        ✅ event ajouté !
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
public function deleteevent($id)
{
    $db = config::getConnection();

    try {
        $query = $db->prepare("DELETE FROM events WHERE id = :id");
        $query->execute([
            ':id' => $id
        ]);

        echo '
<div class="alert alert-success alert-dismissible fade show position-fixed" 
     style="top: 20px; right: 20px; z-index: 1050; min-width: 300px;" 
     role="alert" id="successAlert">
    ✅ event supprimé !
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

public function afficherevent()
{
    $db = config::getConnection();

    try {
        $query = $db->query("SELECT * FROM events");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return [];
    }
}

public function updateevents($data)
{
    error_log('Organizer ID: ' . $data->getOrganizer_Id());  // Log the organizer ID value

    $db = config::getConnection();
    try {
        $query = $db->prepare("
            UPDATE events SET
                title = :title,
                description = :description,
                date = :date,
                location = :location,
                organizer_id = :organizer_id
            WHERE id = :id
        ");
        $query->execute([
            ':id' => $data->getId(),
            ':title' => $data->gettitle(),
            ':description' => $data->getdescription(),
            ':date' => $data->getdate(),
            ':location' => $data->getlocation(),
            ':organizer_id' => $data->getorganizer_id()
        ]);
        echo '
        <div class="alert alert-success alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 1050; min-width: 300px;" 
             role="alert" id="successAlert">
            ✅ event modifer !
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    } catch (PDOException $e) {
        echo '
        <div class="alert alert-danger alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 1050; min-width: 300px;" 
             role="alert" id="errorAlert">
            Erreur : ' . htmlspecialchars($e->getMessage()) . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
    }
}

public function rechercher($id)
{
    $db = config::getConnection();
    $sql = "SELECT * FROM events WHERE id = :id";
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