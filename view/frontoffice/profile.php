<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil Utilisateur</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS Bootstrap & MaterialDesign -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/3.6.95/css/materialdesignicons.css">
    <link href="css/profile.css" rel="stylesheet">

   
</head>
<body>

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
        const updatedUser = {
            id: user.id,
            nom: document.getElementById('update-nom').value,
            prenom: document.getElementById('update-prenom').value,
            email: document.getElementById('update-email').value
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

<!-- JS Bootstrap -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
