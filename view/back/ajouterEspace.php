<?php
require_once '../../controller/espaceController.php';
require_once '../../model/espace.php'; 

$Pc = new espaceController();

if (
    isset($_POST['nom']) &&
    isset($_POST['description']) &&
    isset($_POST['adresse']) &&
    isset($_POST['ville']) &&
    isset($_POST['superficie']) &&
    isset($_POST['statut']) &&
    isset($_FILES['image'])
) {
    if (
        !empty($_POST['nom']) &&
        !empty($_POST['description']) &&
        !empty($_POST['adresse']) &&
        !empty($_POST['ville']) &&
        !empty($_POST['superficie']) &&
        !empty($_POST['statut']) &&
        !empty($_FILES['image']['name'])
    ) {
        $targetDir = "img/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true); 
        }

        $fileName = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . time() . "_" . $fileName;
        $imageType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];


        if (in_array($imageType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
               
                $espace = new Espace(
                    $_POST['nom'],
                    $_POST['description'],
                    $_POST['adresse'],
                    $_POST['ville'],
                    floatval($_POST['superficie']),
                    $_POST['statut'],
                    $targetFilePath 
                );

                $Pc->addEspace($espace);
                header('Location: tables.php');
                exit;
            } else {
                echo "<p style='color: red;'>Erreur lors du téléchargement de l’image.</p>";
            }
        } else {
            echo "<p style='color: red;'>Seules les images JPG, JPEG, PNG et GIF sont autorisées.</p>";
        }
    } else {
        echo "<p style='color: red;'>Veuillez remplir tous les champs obligatoires.</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Espace</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e0f7fa, #ffffff);
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color:rgb(23, 154, 230);
            color: white;
            border-radius: 15px 15px 0 0;
        }
        .form-control, .form-control-file, .custom-select {
            border-radius: 10px;
        }
        .btn-success {
            background-color:rgb(19, 123, 215);
            border: none;
            border-radius: 10px;
        }
        .btn-success:hover {
            background-color:rgb(9, 169, 249);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="mb-0">Ajouter un Espace</h3>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="nom">Nom</label>
                                <input type="text" id="nom" name="nom" class="form-control" >
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" id="description" name="description" class="form-control" >
                            </div>

                            <div class="form-group">
                                <label for="adresse">Adresse</label>
                                <input type="text" id="adresse" name="adresse" class="form-control" >
                            </div>

                            <div class="form-group">
                                <label for="ville">Ville</label>
                                <input type="text" id="ville" name="ville" class="form-control" >
                            </div>

                            <div class="form-group">
                                <label for="superficie">Superficie (m²)</label>
                                <input type="number" id="superficie" name="superficie" class="form-control" step="0.01" >
                            </div>

                            <div class="form-group">
                                <label for="statut">Statut</label>
                                <select id="statut" name="statut" class="form-control" >
                                    <option value="">-- Sélectionner --</option>
                                    <option value="disponible">Disponible</option>
                                    <option value="occupé">Occupé</option>
                                    <option value="en maintenance">En maintenance</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" id="image" name="image" class="form-control-file" accept="image/*">
                            </div>

                            <button type="submit" class="btn btn-success btn-block mt-4">Ajouter Espace</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/controleespace.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
