document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    if (!form) return;

    const titreInput = document.getElementById('titre');
    const descriptionInput = document.getElementById('description');
    const dateActiviteInput = document.getElementById('date_activite');
    const heureInput = document.getElementById('heure');
    const typeActiviteInput = document.getElementById('type_activite');

    const errorContainer = document.createElement('div');
    errorContainer.style.color = 'red';
    errorContainer.style.marginBottom = '15px';
    form.prepend(errorContainer);

    form.addEventListener('submit', function (event) {
        let titre = titreInput ? titreInput.value.trim() : '';
        let description = descriptionInput ? descriptionInput.value.trim() : '';
        let dateActivite = dateActiviteInput ? dateActiviteInput.value : '';
        let heure = heureInput ? heureInput.value : '';
        let typeActivite = typeActiviteInput ? typeActiviteInput.value : '';

        let isValid = true;
        let errorMsg = '';

        // Vérification du titre
        if (titre.length < 3 || titre.length > 100) {
            errorMsg += "Le titre doit faire entre 3 et 100 caractères.<br>";
            isValid = false;
        }

        // Vérification de la description
        if (description.length < 10) {
            errorMsg += "La description doit contenir au moins 10 caractères.<br>";
            isValid = false;
        }

        // Vérification de la date
        if (dateActivite === '') {
            errorMsg += "La date de l'activité est obligatoire.<br>";
            isValid = false;
        } else {
            const today = new Date();
            const selectedDate = new Date(dateActivite + "T00:00:00");
            today.setHours(0, 0, 0, 0);
            if (selectedDate < today) {
                errorMsg += "La date de l'activité ne peut pas être dans le passé.<br>";
                isValid = false;
            }
        }

        // Vérification de l'heure
        if (heure === '') {
            errorMsg += "L'heure de l'activité est obligatoire.<br>";
            isValid = false;
        } else {
            const heureDebut = "08:00";
            const heureFin = "22:00";
            if (heure < heureDebut || heure > heureFin) {
                errorMsg += "L'heure doit être comprise entre 08:00 et 22:00.<br>";
                isValid = false;
            }
        }

        // Vérification du type d'activité
        if (typeActivite === '') {
            errorMsg += "Veuillez sélectionner un type d'activité.<br>";
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault();
            errorContainer.innerHTML = errorMsg;
        } else {
            errorContainer.innerHTML = '';
        }
    });
});
