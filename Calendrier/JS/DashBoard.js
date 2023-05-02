function manipModalCoordinateurs(value){
    const modal = document.querySelector(".modalCoordinateur");
    const overlay = document.querySelector(".overlay");

    if(value == "open"){
        modal.classList.remove("hidden");
        overlay.classList.remove("hidden");
    }
    else{
        modal.classList.add("hidden");
        overlay.classList.add("hidden");
    }
}

function manipModalCours(value){
    const modal = document.querySelector(".modalCours");
    const overlay = document.querySelector(".overlay");

    if(value == "open"){
        modal.classList.remove("hidden");
        overlay.classList.remove("hidden");
    }
    else{
        modal.classList.add("hidden");
        overlay.classList.add("hidden");
    }
}

function manipModalSalles(value){
    const modal = document.querySelector(".modalSalles");
    const overlay = document.querySelector(".overlay");

    if(value == "open"){
        modal.classList.remove("hidden");
        overlay.classList.remove("hidden");
    }
    else{
        modal.classList.add("hidden");
        overlay.classList.add("hidden");
    }
}


function afficheFormCoord() {
    const coordinateurs = document.querySelector('#scrollList1');
    const addForm = document.querySelector('#addFormCoord');
    const button = document.querySelector('#buttonTableCoord');
    if (addForm.style.display === 'none') {
        button.style.display = 'none';
        coordinateurs.style.display = 'none';
        addForm.style.display = 'block';
    } else {
        coordinateurs.style.display = 'block';
        button.style.display = 'block';
        addForm.style.display = 'none';
    }
}

function afficheFormCoordSupp() {
    const coordinateurs = document.querySelector('#scrollList1');
    const addForm = document.querySelector('#addFormCoordSupp');
    const button = document.querySelector('#buttonTableCoord');
    if (addForm.style.display === 'none') {
        button.style.display = 'none';
        coordinateurs.style.display = 'none';
        addForm.style.display = 'block';
    } else {
        coordinateurs.style.display = 'block';
        button.style.display = 'block';
        addForm.style.display = 'none';
    }
}

function ajouterEnseignants(){
    var form = document.getElementById("enseignants");
    const formData = new FormData(form);
    const nom = formData.get('nom');
    const prenom =  formData.get('prenom');
    const email =  formData.get('email');

    var newRow = $("<tr>").append(
        $("<td>").html("<input type='checkbox' name='checkEnseignant'>"),
        $("<td>").text(nom + " " + prenom),
        $("<td>").text(email)
    );

    var data = [nom, prenom, email];
    var jsonString = JSON.stringify(data);
    $.ajax({
        type: "POST",
        url: "../PHP/DashBoard.php",
        data: {ajoutCoord : jsonString},

        success: function(response){
            // ajouter la nouvelle ligne à la fin de la table
            $("#tableEnseignants").append(newRow);
            // réinitialiser les valeurs du formulaire
            $("input[name='nom']").val("");
            $("input[name='prenom']").val("");
            $("input[name='email']").val("");
        }
    });
}
function supprimerEnseignants() {
    // Récupérer les cases à cocher sélectionnées
    var checkboxes = document.getElementsByName("checkEnseignant");
    var num = [];
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            num.push(i);
        }
    }
    var jsonString = JSON.stringify(num);
    $.ajax({
        type: "POST",
        url: "../PHP/DashBoard.php",
        data: {suppCoord : jsonString},

        success: function(){
            for(var i=num.length-1; i>=0; i--) {
                $('#tableEnseignants tr:eq(' + (num[i]) + ')').remove();
            }
        }
    });
}


function afficheFormCours() {
    const cours = document.querySelector('#scrollList2');
    const addForm = document.querySelector('#addFormCours');
    const button = document.querySelector('#buttonTableCours');
    if (addForm.style.display === 'none') {
        button.style.display = 'none';
        cours.style.display = 'none';
        addForm.style.display = 'block';
    } else {
        cours.style.display = 'block';
        button.style.display = 'block';
        addForm.style.display = 'none';
    }
}
function afficheFormCours2() {
    const cours = document.querySelector('#scrollList2');
    const button = document.querySelector('#buttonTableCours');
    let div = document.getElementById("modifyFormCours");
    if (div.style.display === 'none') {
        button.style.display = 'none';
        cours.style.display = 'none';
        div.style.display = 'block';
    } else {
        let data = ['rafraichir'];
        var jsonString = JSON.stringify(data);
        $.ajax({
            type: "POST",
            url: "../PHP/DashBoard.php",
            data: {rafraichirCour : jsonString},
            success: function(){
            }
        });
        button.style.display = 'block';
        cours.style.display = 'block';
        div.style.display = 'none';

    }
}

function afficheFormCoord2() {
    const cours = document.querySelector('#scrollList1');
    const button = document.querySelector('#buttonTableCoord');
    let div = document.getElementById("modifyFormCoord");
    if (div.style.display === 'none') {
        button.style.display = 'none';
        cours.style.display = 'none';
        div.style.display = 'block';
    } else {
        let data = ['rafraichir'];
        var jsonString = JSON.stringify(data);
        $.ajax({
            type: "POST",
            url: "../PHP/DashBoard.php",
            data: {rafraichirCoord : jsonString},
            success: function(){
            }
        });
        button.style.display = 'block';
        cours.style.display = 'block';
        div.style.display = 'none';

    }
}

function afficheFormSalle2() {
    const cours = document.querySelector('#scrollList3');
    const button = document.querySelector('#buttonTableSalle');
    let div = document.getElementById("modifyFormSalle");
    if (div.style.display === 'none') {
        button.style.display = 'none';
        cours.style.display = 'none';
        div.style.display = 'block';
    } else {
        let data = ['rafraichir'];
        var jsonString = JSON.stringify(data);
        $.ajax({
            type: "POST",
            url: "../PHP/DashBoard.php",
            data: {rafraichirSalle : jsonString},
            success: function(){
            }
        });
        button.style.display = 'block';
        cours.style.display = 'block';
        div.style.display = 'none';

    }
}
function afficheFormCoursSupp() {
    const cours = document.querySelector('#scrollList2');
    const addForm = document.querySelector('#addFormCoursSupp');
    const button = document.querySelector('#buttonTableCours');
    if (addForm.style.display === 'none') {
        button.style.display = 'none';
        cours.style.display = 'none';
        addForm.style.display = 'block';
    } else {
        cours.style.display = 'block';
        button.style.display = 'block';
        addForm.style.display = 'none';
    }
}

function updateColor() {
    var color = $("#colorCour").val();
    $("#tableCours tbody tr:last-child td:last-child").css("background-color", color);
}



function ajouterCours(){
    var form = document.getElementById("cours");
    const formData = new FormData(form);
    const nom = formData.get('nom');
    const color = formData.get('colorCour');

    var newRow = $("<tr>").append(
        $("<td>").html("<input type='checkbox' name='checkCours'>"),
        $("<td>").text(nom),
        $("<td>").css("background-color", color)
    );

    var data = [nom, color];
    var jsonString = JSON.stringify(data);
    $.ajax({
        type: "POST",
        url: "../PHP/DashBoard.php",
        data: {ajoutCours : jsonString},

        success: function(){
            // ajouter la nouvelle ligne à la fin de la table
            $("#tableCours").append(newRow);
            // réinitialiser les valeurs du formulaire
            $("input[name='nom']").val("");
            $("input[name='colorCour']").val("#ff0000"); // réinitialiser la couleur sélectionnée

        }
    });
}
function supprimerCours() {
    // Récupérer les cases à cocher sélectionnées
    var checkboxes = document.getElementsByName("checkCours");
    var num = [];
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            num.push(i);
        }
    }
    var jsonString = JSON.stringify(num);
    $.ajax({
        type: "POST",
        url: "../PHP/DashBoard.php",
        data: {suppCours : jsonString},

        success: function(){
            for(var i=num.length-1; i>=0; i--) {
                $('#tableCours tr:eq(' + (num[i]) + ')').remove();
            }
        }
    });
}

function modifierCour(){
    let checkbox = document.getElementsByName('checkCours');
    for(let i = 0; i < checkbox.length; i++){
        if(checkbox[i].checked){
            let data = [i];
            var jsonString = JSON.stringify(data);
            $.ajax({
                type: "POST",
                url: "../PHP/DashBoard.php",
                data: {indiceCourAMS : jsonString},
                success: function(){
                    $.getJSON("../JSON/cours.json", function (json) {
                        let filiere = JSON.parse(document.getElementById('filiere').getAttribute('filiere'));
                        let niveau = JSON.parse(document.getElementById('niveau').getAttribute('niveau'));
                        json[filiere][niveau].forEach((row) => {
                            if(row['AMS'] == 'true'){
                                let form = document.getElementById("coursModify");
                                form.elements["nom"].value = row['nom'];
                                form.elements["colorCour"].value = row['color'];
                            }
                        });
                        const cours = document.querySelector('#scrollList2');
                        const button = document.querySelector('#buttonTableCours');
                        button.style.display = 'none';
                        cours.style.display = 'none';
                        let div = document.getElementById("modifyFormCours");
                        div.style.display = 'block';
                    });
                }
            });
            break;
        }
    }
}

function modifierCoord(){
    let checkbox = document.getElementsByName('checkEnseignant');
    for(let i = 0; i < checkbox.length; i++){
        if(checkbox[i].checked){
            let data = [i];
            var jsonString = JSON.stringify(data);
            $.ajax({
                type: "POST",
                url: "../PHP/DashBoard.php",
                data: {indiceCoordAMS : jsonString},
                success: function(){
                    $.getJSON("../JSON/enseignants.json", function (json) {
                        let filiere = JSON.parse(document.getElementById('filiere').getAttribute('filiere'));
                        let niveau = JSON.parse(document.getElementById('niveau').getAttribute('niveau'));
                        json[filiere][niveau].forEach((row) => {
                            if(row['AMS'] == 'true'){
                                let form = document.getElementById("coordModify");
                                form.elements["nom"].value = row['nom'];
                                form.elements["prenom"].value = row['prenom'];
                                form.elements["email"].value = row['email'];
                            }
                        });
                        const cours = document.querySelector('#scrollList1');
                        const button = document.querySelector('#buttonTableCoord');
                        button.style.display = 'none';
                        cours.style.display = 'none';
                        let div = document.getElementById("modifyFormCoord");
                        div.style.display = 'block';
                    });
                }
            });
            break;
        }
    }
}

function modifierSalle(){
    let checkbox = document.getElementsByName('checkSalle');
    for(let i = 0; i < checkbox.length; i++){
        if(checkbox[i].checked){
            let data = [i];
            var jsonString = JSON.stringify(data);
            $.ajax({
                type: "POST",
                url: "../PHP/DashBoard.php",
                data: {indiceSalleAMS : jsonString},
                success: function(){
                    $.getJSON("../JSON/salles.json", function (json) {
                        json.forEach((row) => {
                            if(row['AMS'] == 'true'){
                                let form = document.getElementById("salleModify");
                                form.elements["nom"].value = row['nom'];
                            }
                        });
                        const cours = document.querySelector('#scrollList3');
                        const button = document.querySelector('#buttonTableSalle');
                        button.style.display = 'none';
                        cours.style.display = 'none';
                        let div = document.getElementById("modifyFormSalle");
                        div.style.display = 'block';
                    });
                }
            });
            break;
        }
    }
}

function modifieCours(){
    let form = document.getElementById("coursModify");
    let nom = form.elements["nom"].value;
    let color = form.elements["colorCour"].value;
    let data = [nom, color];
    let jsonString = JSON.stringify(data);
    $.ajax({
        type: "POST",
        url: "../PHP/DashBoard.php",
        data: {modifyCourAMS : jsonString},
        success: function(){
            $.getJSON("../JSON/cours.json", function (json) {
                let filiere = JSON.parse(document.getElementById('filiere').getAttribute('filiere'));
                let niveau = JSON.parse(document.getElementById('niveau').getAttribute('niveau'));
                const ranking = document.getElementById("tableCours");
                while(ranking.firstChild){
                    ranking.removeChild(ranking.firstChild);
                }
                json[filiere][niveau].forEach((row) => {
                    const tr = document.createElement("tr");
                    const td1 = document.createElement("td");
                    const input = document.createElement("input");
                    input.type = "checkbox";
                    input.name = "checkCours";
                    input.onclick = () => {
                        cacherModifier("checkCours");
                    };
                    td1.appendChild(input);
                    const td2 = document.createElement("td");
                    td2.innerHTML = row['nom'];
                    const td3 = document.createElement("td");
                    td3.style.backgroundColor = row['color'];
                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    tr.appendChild(td3);
                    ranking.appendChild(tr);
                });
                afficheFormCours2();
            });
        }
    });
}

function modifieCoord(){
    let form = document.getElementById("coordModify");
    let nom = form.elements["nom"].value;
    let prenom = form.elements["prenom"].value;
    let email = form.elements["email"].value;
    let data = [nom, prenom, email];
    let jsonString = JSON.stringify(data);
    $.ajax({
        type: "POST",
        url: "../PHP/DashBoard.php",
        data: {modifyCoordAMS : jsonString},
        success: function(){
            $.getJSON("../JSON/enseignants.json", function (json) {
                let filiere = JSON.parse(document.getElementById('filiere').getAttribute('filiere'));
                let niveau = JSON.parse(document.getElementById('niveau').getAttribute('niveau'));
                const ranking = document.getElementById("tableEnseignants");
                while(ranking.firstChild){
                    ranking.removeChild(ranking.firstChild);
                }
                json[filiere][niveau].forEach((row) => {
                    const tr = document.createElement("tr");
                    const td1 = document.createElement("td");
                    const input = document.createElement("input");
                    input.type = "checkbox";
                    input.name = "checkEnseignant";
                    input.onclick = () => {
                        cacherModifier("checkEnseignant");
                    };
                    td1.appendChild(input);
                    const td2 = document.createElement("td");
                    td2.innerHTML = "".concat(row['nom'], " ", row['prenom']);
                    const td3 = document.createElement("td");
                    td3.innerHTML = row['email'];
                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    tr.appendChild(td3);
                    ranking.appendChild(tr);
                });
                afficheFormCoord2();
            });
        }
    });
}
function modifieSalle(){
    let form = document.getElementById("salleModify");
    let nom = form.elements["nom"].value;
    let data = [nom];
    let jsonString = JSON.stringify(data);
    $.ajax({
        type: "POST",
        url: "../PHP/DashBoard.php",
        data: {modifySalleAMS : jsonString},
        success: function(){
            $.getJSON("../JSON/salles.json", function (json) {
                const ranking = document.getElementById("tableSalle");
                while(ranking.firstChild){
                    ranking.removeChild(ranking.firstChild);
                }
                json.forEach((row) => {
                    const tr = document.createElement("tr");
                    const td1 = document.createElement("td");
                    const input = document.createElement("input");
                    input.type = "checkbox";
                    input.name = "checkSalle";
                    input.onclick = () => {
                        cacherModifier("checkSalle");
                    };
                    td1.appendChild(input);
                    const td2 = document.createElement("td");
                    td2.innerHTML = row['nom'];
                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    ranking.appendChild(tr);
                });
                afficheFormSalle2();
            });
        }
    });
}

function afficheFormSalle() {
    const coordinateurs = document.querySelector('#scrollList3');
    const addForm = document.querySelector('#addFormSalle');
    const button = document.querySelector('#buttonTableSalle');
    if (addForm.style.display === 'none') {
        button.style.display = 'none';
        coordinateurs.style.display = 'none';
        addForm.style.display = 'block';
    } else {
        coordinateurs.style.display = 'block';
        button.style.display = 'block';
        addForm.style.display = 'none';
    }
}

function afficheFormSalleSupp() {
    const cours = document.querySelector('#scrollList3');
    const addForm = document.querySelector('#addFormSalleSupp');
    const button = document.querySelector('#buttonTableSalle');
    if (addForm.style.display === 'none') {
        button.style.display = 'none';
        cours.style.display = 'none';
        addForm.style.display = 'block';
    } else {
        cours.style.display = 'block';
        button.style.display = 'block';
        addForm.style.display = 'none';
    }
}


function ajouterSalle(){
    var form = document.getElementById("salle");
    const formData = new FormData(form);
    const nom = formData.get('nom');

    var newRow = $("<tr>").append(
        $("<td>").html("<input type='checkbox' name='checkSalle'>"),
        $("<td>").text(nom)
    );

    var data = [nom];
    var jsonString = JSON.stringify(data);
    $.ajax({
        type: "POST",
        url: "../PHP/DashBoard.php",
        data: {ajoutSalle : jsonString},

        success: function(){
            // ajouter la nouvelle ligne à la fin de la table
            $("#tableSalle").append(newRow);
            // réinitialiser les valeurs du formulaire
            $("input[name='nom']").val("");
        }
    });
}
function supprimerSalle() {
    // Récupérer les cases à cocher sélectionnées
    var checkboxes = document.getElementsByName("checkSalle");
    var num = [];
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            num.push(i);
        }
    }
    var jsonString = JSON.stringify(num);
    $.ajax({
        type: "POST",
        url: "../PHP/DashBoard.php",
        data: {suppSalle : jsonString},

        success: function(){
            for(var i=num.length-1; i>=0; i--) {
                $('#tableSalle tr:eq(' + (num[i]) + ')').remove();
            }
        }
    });
}

function cacherModifier(value){
    let nMod = document.getElementsByName(value);
    let nB = 0;
    if(value == 'checkEnseignant') {
        let button = document.getElementById("ModifierButton");
        for (let i = 0; i < nMod.length; i++) {
            if (nMod[i].checked) {
                nB++;
                if (nB > 1) {
                    button.classList.add('hiddenButton');
                    break;
                }
            }
        }
        if(nB < 2){
            button.classList.remove('hiddenButton');
        }
    }
    else if(value == 'checkSalle') {
        let button = document.getElementById("ModifierButtonSalle");
        for (let i = 0; i < nMod.length; i++) {
            if (nMod[i].checked) {
                nB++;
                if (nB > 1) {
                    button.classList.add('hiddenButton');
                    break;
                }
            }
        }
        if(nB < 2){
            button.classList.remove('hiddenButton');
        }
    }
    else if(value == 'checkCours') {
        let button = document.getElementById("ModifierButtonCours");
        for (let i = 0; i < nMod.length; i++) {
            if (nMod[i].checked) {
                nB++;
                if (nB > 1) {
                    button.classList.add('hiddenButton');
                    break;
                }
            }
        }
        if(nB < 2){
            button.classList.remove('hiddenButton');
        }
    }
}




