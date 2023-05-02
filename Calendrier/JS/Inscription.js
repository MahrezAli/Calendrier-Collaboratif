// Fonction pour cacher les cases à cocher pour le type de compte
function cacherCasesACocher() {
    // Récupération des éléments HTML nécessaires
    var checkboxEtudiant = document.getElementById("c1");
    var checkboxResponsable = document.getElementById("c2");
    var checkboxCoordinateur = document.getElementById("c3");

    var labelEtudiant = document.getElementById("cc1");
    var labelResponsable = document.getElementById("cc2");
    var labelCoordinateur = document.getElementById("cc3");

    if(checkboxEtudiant.checked){
        checkboxResponsable.style.display = "none";
        labelResponsable.style.display = "none";
        checkboxCoordinateur.style.display = "none";
        labelCoordinateur.style.display = "none";
    }
    else if(checkboxResponsable.checked){
        checkboxEtudiant.style.display = "none";
        labelEtudiant.style.display = "none";
        checkboxCoordinateur.style.display = "none";
        labelCoordinateur.style.display = "none";
    }
    else if(checkboxCoordinateur.checked){
        checkboxEtudiant.style.display = "none";
        labelEtudiant.style.display = "none";
        checkboxResponsable.style.display = "none";
        labelResponsable.style.display = "none";
    }


    var checkboxLL = document.getElementsByClassName("checkbox_container_2");
    for(let i = 0; i < checkboxLL.length; i++){
        if(checkboxEtudiant.checked || checkboxResponsable.checked || checkboxCoordinateur.checked){
            checkboxLL[i].style.display = "block";
        }
    }

}

// Fonction pour afficher les cases à cocher pour le type de compte
function afficherCasesACocher() {
    // Récupération des éléments HTML nécessaires
    var checkboxEtudiant = document.getElementById("c1");
    var checkboxResponsable = document.getElementById("c2");
    var checkboxCoordinateur = document.getElementById("c3");

    var labelEtudiant = document.getElementById("cc1");
    var labelResponsable = document.getElementById("cc2");
    var labelCoordinateur = document.getElementById("cc3");


    if(!checkboxEtudiant.checked){
        checkboxEtudiant.style.display = "block";
        labelEtudiant.style.display = "block";
    }
    if(!checkboxResponsable.checked){
        checkboxResponsable.style.display = "block";
        labelResponsable.style.display = "block";
    }
    if(!checkboxCoordinateur.checked){
        checkboxCoordinateur.style.display = "block";
        labelCoordinateur.style.display = "block";
    }

    var checkboxLL = document.getElementsByClassName("checkbox_container_2");
    for(let i = 0; i < checkboxLL.length; i++){
        if(!checkboxEtudiant.checked && !checkboxResponsable.checked && !checkboxCoordinateur.checked){
            checkboxLL[i].style.display = "none";
        }
    }
}


// Fonction pour cacher les cases à cocher pour l'année
function cacherCasesACocher2() {
    var checkboxLL = document.querySelectorAll(".checkbox_container_2");
    for (let i = 0; i < checkboxLL.length; i++) {
        var input = checkboxLL[i].querySelector("input");
        if (!input.checked) {
            checkboxLL[i].style.display = "none";
        }
    }

    var checkboxLL2 = document.querySelectorAll(".checkbox_container_3");
    for (let i = 0; i < checkboxLL2.length; i++) {
        checkboxLL2[i].style.display = "block";
    }
}

// Fonction pour afficher les cases à cocher pour l'année
function afficherCasesACocher2() {
    var checkboxLL = document.querySelectorAll(".checkbox_container_2");
    var toUncheck = true;
    for (let i = 0; i < checkboxLL.length; i++) {
        var input = checkboxLL[i].querySelector("input");
        toUncheck = toUncheck && !input.checked ;
    }
    if (toUncheck) {
        for (let i = 0; i < checkboxLL.length; i++) {
            checkboxLL[i].style.display = "block";
        }
        var checkboxLL2 = document.querySelectorAll(".checkbox_container_3");
        for (let i = 0; i < checkboxLL2.length; i++) {
            checkboxLL2[i].style.display = "none";
        }
    }
}

// Fonction pour cacher les cases à cocher pour la filière
function cacherCasesACocher3() {
    var checkboxLL = document.querySelectorAll(".checkbox_container_3");
    for (let i = 0; i < checkboxLL.length; i++) {
        var input = checkboxLL[i].querySelector("input");
        if (!input.checked) {
            checkboxLL[i].style.display = "none";
        }
    }
}

// Fonction pour afficher les cases à cocher pour la filière
function afficherCasesACocher3() {
    var checkboxLL = document.querySelectorAll(".checkbox_container_3");
    var toUncheck = true;
    for (let i = 0; i < checkboxLL.length; i++) {
        var input = checkboxLL[i].querySelector("input");
        toUncheck = toUncheck && !input.checked ;
    }
    if (toUncheck) {
        for (let i = 0; i < checkboxLL.length; i++) {
            checkboxLL[i].style.display = "block";
        }
    }
}

function validateAndSubmit() {
    if (validateForm()) {
        document.forms[0].submit(); // envoyer le formulaire
        //window.location.href = 'Connexion.php'; // rediriger vers la page souhaitée
    }
}

function validateForm() {
    var nom = document.forms["myForm"]["nom"].value;
    var prenom = document.forms["myForm"]["prenom"].value;
    var email = document.forms["myForm"]["email"].value;
    var mdp = document.forms["myForm"]["mdp"].value;

    if (nom == "" || prenom == "" || email == "" || mdp == "") {
        alert("Tous les champs sont obligatoires.");
        return false;
    }

    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    var isChecked = false;
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            isChecked = true;
            break;
        }
    }

    // Si aucune case n'est cochée, afficher un message d'erreur
    if (!isChecked) {
        alert("Veuillez cocher au moins une case avant de valider le formulaire.");
        return false;
    }

    return true;
}

