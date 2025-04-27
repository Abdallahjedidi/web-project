<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mot de passe oublié</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link href="css/login.css" rel="stylesheet">

  <!-- Script EmailJS -->
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
  <script type="text/javascript">
    (function(){
        emailjs.init('fnnwZPvZGd3isEur_'); // 🛠️ Ta clé publique EmailJS
    })();
  </script>
</head>
<body>

  <div class="form-container">
    <h2>Mot de passe oublié</h2>
    <form id="reset-form">
      <div class="form-group">
        <label for="email">Votre Email</label>
        <input type="email" name="email" id="email" placeholder="ex: nom@domaine.com" required>
      </div>

      <button type="submit">Réinitialiser le mot de passe</button>

      <a href="login.php">← Retour à la connexion</a>
    </form>

    <div id="message"></div>

    <div class="link-register">
      Pas encore inscrit ? <a href="register.php">Créer un compte</a>
    </div>
  </div>

  <script>
  document.getElementById('reset-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const email = document.getElementById('email').value;

    // Envoi de l'email au fichier PHP pour vérifier et réinitialiser le mot de passe
    fetch('reset_password.php', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({ email: email }),
})
.then(response => response.text())  // Changez .json() en .text() pour obtenir la réponse brute
.then(data => {
  console.log(data);  // Affichez la réponse brute dans la console pour voir ce qui est renvoyé

  try {
    const jsonData = JSON.parse(data);  // Convertissez manuellement en JSON
    if (jsonData.success) {
      // Si l'email et la mise à jour sont réussis
      emailjs.send('service_6vh5zia', 'template_1g9rpts', {
        user_email: email,
        new_password: jsonData.newPassword
      })
      .then(function(response) {
          console.log('SUCCESS!', response.status, response.text);
          document.getElementById('message').innerHTML = "<div class='success'>Un email de réinitialisation a été envoyé à " + email + ".</div>";
      }, function(error) {
          console.error('FAILED...', error);
          document.getElementById('message').innerHTML = "<div class='error'>Erreur lors de l'envoi de l'email. Réessaye plus tard.</div>";
      });
    } else {
      document.getElementById('message').innerHTML = "<div class='error'>" + jsonData.message + "</div>";
    }
  } catch (e) {
    console.error('Erreur de parsing JSON:', e);
    document.getElementById('message').innerHTML = "<div class='error'>Erreur lors de la réinitialisation du mot de passe. Réessayez plus tard.</div>";
  }
})
.catch(error => {
  console.error('Error:', error);
  document.getElementById('message').innerHTML = "<div class='error'>Erreur lors de la réinitialisation du mot de passe. Réessayez plus tard.</div>";
});

  });
</script>

</body>
</html>
