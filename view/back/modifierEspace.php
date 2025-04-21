<?php
require_once '..\..\controller\espaceController.php';

$Pc = new espaceController();

if (
    isset($_POST['nom']) &&
    isset($_POST['description']) &&
    isset($_POST['adresse']) &&
    isset($_POST['ville']) &&
    isset($_POST['superficie']) &&
    isset($_POST['statut'])
) {
    if (
        !empty($_POST['nom']) &&
        !empty($_POST['description']) &&
        !empty($_POST['adresse']) &&
        !empty($_POST['ville']) &&
        !empty($_POST['superficie']) &&
        !empty($_POST['statut'])
    ) {

        $image = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = 'uploads/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $image);
            
        }

      
        $espace = new Espace(
            $_POST['nom'],
            $_POST['description'],
            $_POST['adresse'],
            $_POST['ville'],
            floatval($_POST['superficie']),
            $_POST['statut'],
            $image
        );

        
        $Pc->updateEspace($espace, $_GET['id']);
        header('Location: tables.php');
        exit;
    } else {
        echo "<p style='color: red;'>Veuillez remplir tous les champs obligatoires.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mise à jour de l'Espace</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <?php
            if (isset($_GET['id'])) {
                $espace = $Pc->getEspaceById($_GET['id']);
            }
            ?>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h1>Mise à Jour de l'Espace</h1>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="nom">Nom :</label>
                                <input type="text" id="nom" name="nom" class="form-control" value="<?= $espace['nom']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="description">Description :</label>
                                <input type="text" id="description" name="description" class="form-control" value="<?= $espace['description']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="adresse">Adresse :</label>
                                <input type="text" id="adresse" name="adresse" class="form-control" value="<?= $espace['adresse']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="ville">Ville :</label>
                                <input type="text" id="ville" name="ville" class="form-control" value="<?= $espace['ville']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="superficie">Superficie (m²) :</label>
                                <input type="number" id="superficie" name="superficie" step="0.01" class="form-control" value="<?= $espace['superficie']; ?>">
                            </div>

                            <div class="form-group">
                                <label for="statut">Statut :</label>
                                <select id="statut" name="statut" class="form-control">
                                    <option value="disponible" <?= $espace['statut'] == 'disponible' ? 'selected' : ''; ?>>Disponible</option>
                                    <option value="occupé" <?= $espace['statut'] == 'occupé' ? 'selected' : ''; ?>>Occupé</option>
                                    <option value="en maintenance" <?= $espace['statut'] == 'en maintenance' ? 'selected' : ''; ?>>En maintenance</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="image">Image :</label>
                                <input type="file" id="image" name="image" class="form-control">
                                <?php if ($espace['image']): ?>
                                    <p><strong>Image actuelle :</strong> <img src="<?= $espace['image']; ?>" alt="Image actuelle" width="100"></p>
                                <?php endif; ?>
                            </div>

                            <input type="hidden" name="id" value="<?= $espace['id']; ?>">

                            <button type="submit" class="btn btn-success btn-block mt-3">Mettre à Jour</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
