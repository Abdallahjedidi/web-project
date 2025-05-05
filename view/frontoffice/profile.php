<?php
include_once '../../controller/usercontroller.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if ($data && isset($data['id'], $data['nom'], $data['prenom'], $data['email'])) {
        try {
            $controller = new UserController();
            $controller->updateUser($data);
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Données invalides.']);
    }
    exit;
}
?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil Utilisateur</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/home.css">

    <!-- CSS Bootstrap & MaterialDesign -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/3.6.95/css/materialdesignicons.css">
    <link href="css/profile.css" rel="stylesheet">

   
</head>
<body>
 <!-- Navigation -->
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">URBANISME</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto" id="navbar-links">
                    <li class="nav-item">
                        <a class="nav-link active" href="home.html">Accueil</a>
                    </li>
                    <!-- Lien dynamique -->
                    <li class="nav-item" id="profile-link">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-xl-6 col-md-10">
        <div class="card user-card-full" id="profile-info">
            <div class="row m-0">
                <div class="col-sm-4 bg-c-lite-green user-profile">
                    <div class="card-block text-center text-white py-5">
                        <div class="m-b-25">
                            <img src="https://img.icons8.com/bubbles/100/000000/user.png" class="img-radius" alt="User-Profile-Image">
                        </div>
                        
                        <button id="logout-btn" class="btn btn-light btn-sm">Logout</button>
                        </div>
                </div>
                <div class="col-sm-8">
                    <div class="card-block py-4 px-4">
                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Informations personnelles</h6>
                        <div class="row">
                            <div class="col-sm-6">
                                <p class="m-b-10 f-w-600"><i class="mdi mdi-account-circle"></i> Nom</p>
                                <h6 class="text-muted f-w-400" id="user-nom">Nom</h6>
                            </div>
                            <div class="col-sm-6">
                                <p class="m-b-10 f-w-600"><i class="mdi mdi-account"></i> Prénom</p>
                                <h6 class="text-muted f-w-400" id="user-prenom">Prenom</h6>
                            </div>
                            <div class="col-sm-12 mt-2">
                                <p class="m-b-10 f-w-600"><i class="mdi mdi-email"></i> Email</p>
                                <h6 class="text-muted f-w-400" id="user-email">Email</h6>
                            </div>
                            <button class="btn btn-warning btn-sm mt-3" data-toggle="modal" data-target="#editModal">Modifier</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


  </div>
</div>





<!-- JS -->
<script>




  document.getElementById('logout-btn').addEventListener('click', function () {
    localStorage.removeItem('user'); // ou localStorage.clear();
    window.location.href = 'login.php';
});

document.addEventListener("DOMContentLoaded", function () {
    const user = JSON.parse(localStorage.getItem('user'));

    if (!user) {
        document.getElementById('profile-info').innerHTML = "<div class='alert alert-warning'>Aucune information utilisateur trouvée. Veuillez vous connecter.</div>";
        return;
    }

    document.getElementById('user-nom').textContent = user.nom;
    document.getElementById('user-prenom').textContent = user.prenom;
    document.getElementById('user-email').textContent = user.email;

    document.getElementById('update-nom').value = user.nom;
    document.getElementById('update-prenom').value = user.prenom;
    document.getElementById('update-email').value = user.email;

    document.getElementById('update-btn').addEventListener('click', function () {
    const nom = document.getElementById('update-nom').value.trim();
    const prenom = document.getElementById('update-prenom').value.trim();
    const email = document.getElementById('update-email').value.trim();

   const nameRegex = /^[a-zA-ZÀ-ÿ\s\-]+$/;
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

let erreurs = [];

if (nom.trim() === "" || !nameRegex.test(nom)) {
    erreurs.push("❌ Le nom est invalide.");
}

if (prenom.trim() === "" || !nameRegex.test(prenom)) {
    erreurs.push("❌ Le prénom est invalide.");
}

if (email.trim() === "" || !emailRegex.test(email)) {
    erreurs.push("❌ Email invalide.");
}

if (erreurs.length > 0) {
    erreurs.forEach((erreur, index) => {
        setTimeout(() => {
            Toastify({
                text: erreur,
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "#e74c3c",
                stopOnFocus: true,
                style: {
                    fontSize: "14px",
                    borderRadius: "8px"
                }
            }).showToast();
        }, index * 300); // décalage pour chaque toast
    });
    return;
}


    const updatedUser = {
        id: user.id,
        nom,
        prenom,
        email
    };

    fetch('profile.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(updatedUser)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            localStorage.setItem('user', JSON.stringify(updatedUser));
            document.getElementById('user-nom').textContent = updatedUser.nom;
            document.getElementById('user-prenom').textContent = updatedUser.prenom;
            document.getElementById('user-email').textContent = updatedUser.email;
            $('#editModal').modal('hide');
        } else {
            alert("Erreur lors de la mise à jour : " + data.message);
        }
    })
    .catch(error => {
        console.error("Erreur :", error);
        alert("Une erreur est survenue.");
    });
});

});
</script>


<!-- zid zid -->
 <!-- Modal de modification -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Modifier le profil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="edit-form">
              <div class="form-group">
                  <label for="update-nom">Nom</label>
                  <input type="text" class="form-control" id="update-nom" >
              </div>
              <div class="form-group">
                  <label for="update-prenom">Prénom</label>
                  <input type="text" class="form-control" id="update-prenom" >
              </div>
              <div class="form-group">
                  <label for="update-email">Email</label>
                  <input type="email" class="form-control" id="update-email">
              </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" id="update-btn">Enregistrer</button>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Vérifier si le token est présent dans localStorage
    const user = JSON.parse(localStorage.getItem('user'));

    if (!user) {
        window.location.href = '../frontoffice/login.php';
        return;
    }

    if (user.role === 'admin') {
        window.location.href = 'unauthorized1.php'; // Remplace par l'URL de ta page non autorisée
        return;
    } 
});
</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Popper.js (nécessaire pour Bootstrap 4) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>
