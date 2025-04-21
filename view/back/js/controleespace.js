document.addEventListener('DOMContentLoaded', function () {
    const idInput = document.getElementById('id');
    const superficieInput = document.getElementById('superficie');

    // Protéger les addEventListener
    [idInput, superficieInput].forEach(input => {
        if (input) {
            input.addEventListener('keydown', function (event) {
                const keyCode = event.keyCode || event.which;
                if (
                    (keyCode >= 48 && keyCode <= 57) || 
                    keyCode === 8 || keyCode === 9      
                ) {
                    return true;
                } else {
                    event.preventDefault();
                    return false;
                }
            });
        }
    });

    const form = document.querySelector('form');
    if (!form) return;

    const errorContainer = document.createElement('div');
    errorContainer.style.color = 'red';
    form.prepend(errorContainer);

    form.addEventListener('submit', function (event) {
        const id = idInput?.value.trim() || '';
        const nom = document.getElementById('nom')?.value.trim() || '';
        const description = document.getElementById('description')?.value.trim() || '';
        const adresse = document.getElementById('adresse')?.value.trim() || '';
        const ville = document.getElementById('ville')?.value.trim() || '';
        const superficie = superficieInput?.value.trim() || '';
        const statut = document.getElementById('statut')?.value || '';

        let isValid = true;
        let errorMsg = '';

        if (isNaN(id) || parseInt(id) <= 0) {
            errorMsg += "L'ID doit être un nombre entier positif.<br>";
            isValid = false;
        }

        if (nom.length < 3) {
            errorMsg += "Le nom doit contenir au moins 3 caractères.<br>";
            isValid = false;
        }

        if (description.split(' ').filter(word => word.length > 0).length < 3) {
            errorMsg += "La description doit contenir au moins 3 mots.<br>";
            isValid = false;
        }

        if (adresse.length === 0) {
            errorMsg += "L'adresse est obligatoire.<br>";
            isValid = false;
        }

        if (ville.length === 0) {
            errorMsg += "La ville est obligatoire.<br>";
            isValid = false;
        }

        if (isNaN(superficie) || parseFloat(superficie) <= 0) {
            errorMsg += "La superficie doit être un nombre positif.<br>";
            isValid = false;
        }

        if (!statut || statut === '') {
            errorMsg += "Veuillez sélectionner un statut.<br>";
            isValid = false;
        }

        if (!isValid) {
            errorContainer.innerHTML = errorMsg;
            event.preventDefault();
        } else {
            errorContainer.innerHTML = '';
        }
    });
});
