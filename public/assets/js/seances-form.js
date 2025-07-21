/**
 * Pour form de séances (create/edit.php)
 */

// var globales pour les données pré-sélectionnées
let preselectedChien = null;
let preselectedClient = null;

// charge les chiens d'un client
function loadChiens(clientId) {
    const chienSelect = document.getElementById('chien_id');

    const currentChienId = chienSelect.value;


    // vide la liste
    chienSelect.innerHTML = '<option value="">Sélectionner un chien</option>';

    if (!clientId) return;

    // affiche un indicateur de chargement
    chienSelect.innerHTML = '<option value="">Chargement...</option>';

    fetch(`index.php?page=seances&action=ajax_chiens&client_id=${clientId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erreur HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(chiens => {
            // vider et remplir la liste
            chienSelect.innerHTML = '<option value="">Sélectionner un chien</option>';

            chiens.forEach(chien => {
                const option = document.createElement('option');
                option.value = chien.id;
                option.textContent = chien.nom + (chien.race ? ` (${chien.race})` : '');
                chienSelect.appendChild(option);
            });

            if (currentChienId) {
                chienSelect.value = currentChienId;
            }
        else if (preselectedChien) {
                chienSelect.value = preselectedChien;
            }

        // MAJ le titre après chargement
            updateTitleIfEmpty();
        })
        .catch(error => {
            console.error('Erreur lors du chargement des chiens:', error);
            chienSelect.innerHTML = '<option value="">Erreur de chargement</option>';
        });
}

// sélectionne un type de séance depuis la sidebar
function selectType(typeId, nom, duree, prix) {
    document.getElementById('type_seance_id').value = typeId;
    document.getElementById('duree_minutes').value = duree;

    if (prix > 0) {
        document.getElementById('prix').value = prix;
    }

    // MaJ le titre après sélection du type
    updateTitleIfEmpty();
}

// MaJ le titre automatiquement si vide
function updateTitleIfEmpty() {
    const titreInput = document.getElementById('titre');

    // ne pas écraser un titre déjà saisi
    if (titreInput.value.trim()) return;

    const chienSelect = document.getElementById('chien_id');
    const typeSelect = document.getElementById('type_seance_id');

    let titre = '';

    // récupère le nom du type sans le prix
    if (typeSelect.selectedIndex > 0) {
        const typeNom = typeSelect.options[typeSelect.selectedIndex].text.split('(')[0].trim();
        titre = typeNom;
    }

    // ajoute le nom du chien si sélectionné
    if (chienSelect.selectedIndex > 0) {
        const chienNom = chienSelect.options[chienSelect.selectedIndex].text.split('(')[0].trim();

        if (titre) {
            titre += ` avec ${chienNom}`;
        } else {
            titre = `Séance avec ${chienNom}`;
        }
    }

    // MaJ
    // le titre si on a quelque chose
    if (titre) {
        titreInput.value = titre;
    }
}

// valide du form avant soumission
async function validateForm(e) {
    const errors = [];

    // valide les champs requis
    const titre = document.getElementById('titre').value.trim();
    const dateSeance = document.getElementById('date_seance').value;
    const clientId = document.getElementById('client_id').value;
    const chienId = document.getElementById('chien_id').value;

    if (!titre) {
        errors.push('Le titre est requis');
    }

    if (!dateSeance) {
        errors.push('La date et l\'heure sont requises');
    }

    if (!clientId) {
        errors.push('Veuillez sélectionner un client');
    }

    if (!chienId) {
        errors.push('Veuillez sélectionner un chien');
    }

    // affiche les erreurs si il y en a
    if (errors.length > 0) {
        alert('Erreurs de validation :\n• ' + errors.join('\n• '));
        e.preventDefault();
        return false;
    }

    // validation de la date
    const dateSeanceObj = new Date(dateSeance);
    const maintenant = new Date();

    if (dateSeanceObj < maintenant) {
        const confirmPast = await showCustomConfirm('Vous programmez une séance dans le passé. Êtes-vous sûr ?');
        if (!confirmPast) {
            e.preventDefault();
            return false;
        }
    }

    // vérifie heures ouvrables
    const heure = dateSeanceObj.getHours();
    if (heure < 8 || heure > 20) {
        const confirmHours = await showCustomConfirm('Cette séance est programmée en dehors des heures habituelles (8h-20h). Continuer ?');
        if (!confirmHours) {
            e.preventDefault();
            return false;
        }
    }

    return true;
}

// initialisation quand le DOM est chargé
function initSeanceForm() {
    // récupère les données pré-sélectionnées depuis les éléments cachés ou var PHP
    const preselectedChienInput = document.querySelector('input[name="preselected_chien"]');
    const preselectedClientInput = document.querySelector('input[name="preselected_client"]');

    if (preselectedChienInput) {
        preselectedChien = preselectedChienInput.value;
    }

    if (preselectedClientInput) {
        preselectedClient = preselectedClientInput.value;
    }



    // ** Event Listeners **

    // changement de client
    const clientSelect = document.getElementById('client_id');
    if (clientSelect) {
        clientSelect.addEventListener('change', function() {
            loadChiens(this.value);
        });

        // Charger les chiens si un client est déjà sélectionné
        if (clientSelect.value) {
            loadChiens(clientSelect.value);
        }
    }

    // changement de type de séance
    const typeSelect = document.getElementById('type_seance_id');
    if (typeSelect) {
        typeSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                const duree = selectedOption.dataset.duree;
                const prix = selectedOption.dataset.prix;

                if (duree) {
                    document.getElementById('duree_minutes').value = duree;
                }
                if (prix && prix > 0) {
                    document.getElementById('prix').value = prix;
                }

                updateTitleIfEmpty();
            }
        });
    }

    // changement de chien
    const chienSelect = document.getElementById('chien_id');
    if (chienSelect) {
        chienSelect.addEventListener('change', updateTitleIfEmpty);
    }

    // valide le form
    const form = document.getElementById('seanceForm');
    if (form) {
        form.addEventListener('submit', validateForm);
    }
}

// initialise quand le DOM est prêt
document.addEventListener('DOMContentLoaded', initSeanceForm);

// function utilitaires pour les pages d'édition
function setPreselectedData(clientId, chienId) {
    preselectedClient = clientId;
    preselectedChien = chienId;
}