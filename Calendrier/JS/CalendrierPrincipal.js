function afficherSemaineSuivante(currentWeek, currentYear) {
    var newWeek = currentWeek + 1;
    var newYear = currentYear;

    if (newWeek > 53) {
        newYear = currentYear + 1;
        newWeek = getWeeksInYear(newYear);
    }
    let data = [newWeek, newYear];
    let jsonString = JSON.stringify(data);
    /*$.ajax({
        type: "POST",
        url: "../PHP/CalendrierPrincipal.php",
        data: {date: jsonString},
        success: function () {

        }
    });*/
    window.location.href = "?week=" + newWeek + "&year=" + newYear;
}
function afficherSemainePrecedente(currentWeek, currentYear) {
    var newWeek = currentWeek - 1;
    var newYear = currentYear;

    if (newWeek < 1) {
        newYear = currentYear - 1;
        newWeek = getWeeksInYear(newYear);
    }

    window.location.href = "?week=" + newWeek + "&year=" + newYear;
}

function getWeeksInYear(year) {
    var date = new Date(year, 11, 31);
    var week = parseInt(date.format("W"));
    if (week == 1) {
        return parseInt(new Date(year, 11, 24).format("W"));
    }
    else {
        return week;
    }
}

function remplirForm(){
    let filiere = JSON.parse(document.getElementById('filiere').getAttribute('filiere'));
    let niveau = JSON.parse(document.getElementById('niveau').getAttribute('niveau'));
    $.getJSON("../JSON/emploiDuTemps.json", function (json) {
        json[filiere][niveau].forEach((row) => {
            if(row["AMS"] == 'true'){
                document.getElementsByName("typeCoursMod")[0].value = row["typeDeCours"];
                document.getElementsByName("matiereMod")[0].value = row["matiere"];
                document.getElementsByName("quelSalle1Mod")[0].value = row['Salle'];
                document.getElementsByName("quelEnseignant1Mod")[0].value = row['Coordinateur'];
            }
        });
    });
}

function manipModalModifier(value){
    const modal = document.querySelector(".modalModify");
    const modalMod = document.querySelector(".modalModify2");
    const overlay = document.querySelector(".overlay");
    if(value=='enregistrer'){
        let t = document.getElementsByName("typeCoursMod")[0].value;
        let m = document.getElementsByName("matiereMod")[0].value;
        let s = document.getElementsByName("quelSalle1Mod")[0].value;
        let c = document.getElementsByName("quelEnseignant1Mod")[0].value;
        let nMod = document.getElementsByName("nMod");
        for(let i = 0; i < nMod.length; i++){
            if(nMod[i].checked){
                nMod = nMod[i].value;
                break;
            }
        }
        let data = [t, m, s, c, nMod];
        let jsonString = JSON.stringify(data);
        $.ajax({
            type: "POST",
            url: "../PHP/CalendrierPrincipal.php",
            data: {modification: jsonString},
            success: function () {
                let filiere = JSON.parse(document.getElementById('filiere').getAttribute('filiere'));
                let niveau = JSON.parse(document.getElementById('niveau').getAttribute('niveau'));
                var arrayWeek = JSON.parse(document.getElementById('arrayWeek').getAttribute('data-array'));
                $.getJSON("../JSON/emploiDuTemps.json", function (json) {
                    let tab = new Array(44);
                    let g = new Array(3);
                    g[0] = 'G1';
                    g[1] = 'G2';
                    g[2] = 'G3';
                    for(let i = 0; i < tab.length; i++){
                        tab[i] = new Array(15);
                        for(let j = 0; j < tab[i].length; j++){
                            tab[i][j] = 99;
                        }
                    }
                    const ranking = document.querySelector("#tableEDT > tbody");
                    while(ranking.firstChild){
                        ranking.removeChild(ranking.firstChild);
                    }
                    let tabI = 0;
                    let tabJ = 0;
                    for(let i = 8; i < 19; i++){
                        for(let j = 0; j <= 45; j += 15){
                            const tr = document.createElement("tr");
                            let m = (j == 0 ? '00' : j);
                            let h = (i < 10 ? "".concat('0', i) : i);
                            const hour = "".concat(h, ':', m);
                            const tdH = document.createElement("td");
                            tdH.innerHTML = "".concat(i,":",m);
                            tdH. setAttribute('id','Cln');
                            tdH.style.backgroundColor = "#f2f2f2";
                            tr.appendChild(tdH);
                            for(let jourSemaine = 0; jourSemaine < 5; jourSemaine++){
                                let jour = arrayWeek[jourSemaine];
                                let [jour2, mois2, annee2] = jour.split("-");
                                g.forEach((groupe) => {
                                    json[filiere][niveau].forEach((row) => {
                                        let dates = getDatesBetween(row['dateDebut'],row['dateFin']);
                                        for(let date = 0; date < dates.length; date++) {
                                            let [annee1, mois1, jour1] = dates[date].split("-");
                                            if (row['heureDebut'] == hour && jour1 == jour2 && mois1 == mois2 && annee1 == annee2 && groupe == row['Groupe'] && tab[tabI][tabJ] == 99) {
                                                let [hours, mins] = row['heureDebut'].split(":");
                                                let [hoursFin, minsFin] = row['heureFin'].split(":");
                                                var rowIndex = ((hours - 8) * 4) + 2; // calculer l'index de ligne en fonction de l'heure de début
                                                if(mins == 15){
                                                    rowIndex += 1;
                                                }
                                                else if(mins == 30){
                                                    rowIndex += 2;
                                                }
                                                else if(mins == 45){
                                                    rowIndex += 3;
                                                }
                                                var rowIndexFin = ((hoursFin - 8) * 4) + 2; // calculer l'index de ligne en fonction de l'heure de début
                                                if(minsFin == 15){
                                                    rowIndexFin += 1;
                                                }
                                                else if(minsFin == 30){
                                                    rowIndexFin += 2;
                                                }
                                                else if(minsFin == 45){
                                                    rowIndexFin += 3;
                                                }
                                                let duration = rowIndexFin - rowIndex;
                                                const td = document.createElement("td");
                                                $.getJSON("../JSON/cours.json", function (c) {
                                                    for (let i = 0; i < c[filiere][niveau].length; i++) {
                                                        if (c[filiere][niveau][i]['nom'] == row['matiere']) {
                                                            td.style.backgroundColor = c[filiere][niveau][i]['color'];
                                                            break;
                                                        }
                                                    }
                                                });
                                                let button = document.createElement("button");
                                                let i = document.createElement("i");
                                                i.innerHTML = '&#xf014;';
                                                i.style.color = 'red';
                                                i.style.fontSize = '24px';
                                                i.className = 'fa';
                                                button.appendChild(i);
                                                button.className = 'trash';
                                                let button2 = document.createElement("button");
                                                let i2 = document.createElement("i");
                                                i2.style.color = '#E4E4E1';
                                                i2.style.fontSize = '24px';
                                                i2.className = 'fa-solid fa-pen-to-square';
                                                button2.appendChild(i2);
                                                button2.className = 'trash';
                                                td.innerHTML = row['typeDeCours']  + "<br> " + row['matiere'] + "<br> " + row['Coordinateur'] + "<br> " + row['Salle'] + "<br>";
                                                button.addEventListener("click", function() {
                                                    manipModalSupp('open', row['dateDebut'], row['heureDebut'], jour, row['dateFin'], groupe);
                                                });
                                                button2.addEventListener("click", function() {
                                                    manipModalMod('open', row['dateDebut'], row['heureDebut'], jour, row['dateFin'], groupe);
                                                });
                                                td.appendChild(button2);
                                                td.appendChild(button);
                                                td.rowSpan = duration;
                                                tr.appendChild(td);
                                                for (let i2 = tabI; i2 < tabI + duration; i2++) {
                                                    tab[i2][tabJ] = 0;
                                                }
                                            }
                                        }
                                    });
                                    if(tab[tabI][tabJ] == 99){
                                        let reformattedDate = "".concat(annee2, '-', mois2, '-', jour2);
                                        const td = document.createElement("td");
                                        let groupee = ''.concat(groupe);
                                        td.innerHTML = "<button onclick=\"manipModal('open'); rempliForm('" + reformattedDate + "', '" + h + "', '" + m + "', '" + groupee + "');\">+</button>";
                                        tr.appendChild(td);
                                    }
                                    tabJ++;
                                });
                            }
                            ranking.appendChild(tr);
                            tabI++;
                            tabJ = 0;
                        }
                    }
                });
            }
        });
        let form2 = document.getElementById("modEdt");
        form2.reset();
        modalMod.classList.add("hiddenMod2");
        modal.classList.add("hiddenMod");
        overlay.classList.add("hidden");
    }
    else if(value=='retour'){
        let form = document.getElementById("modEdt");
        form.reset();
        modalMod.classList.add("hiddenMod2");
        modal.classList.remove("hiddenMod");
    }
    else{
        let form = document.getElementById("modEdt");
        form.reset();
        modalMod.classList.add("hiddenMod2");
        modal.classList.add("hiddenMod");
        overlay.classList.add("hidden");
    }
}

function manipModalMod(value, dateDebut, heureDebut, jourActuel, dateFin, groupe){
    const modal = document.querySelector(".modalModify");
    const overlay = document.querySelector(".overlay");
    const modalMod = document.querySelector(".modalModify2");
    if(value == "open"){
        modal.classList.remove("hiddenMod");
        overlay.classList.remove("hidden");
        let data = [dateDebut, heureDebut, jourActuel, dateFin, groupe];
        let jsonString = JSON.stringify(data);
        $.ajax({
            type: "POST",
            url: "../PHP/CalendrierPrincipal.php",
            data: {AModifier: jsonString},
            success: function (r) {
            }
        });
        // Récupérer la position de l'utilisateur
        const scrollY = window.scrollY;
        const windowHeight = window.innerHeight;

        // Calculer la position du modal en fonction de la position de l'utilisateur
        const modalHeight = modal.offsetHeight;
        const modalTop = Math.min(scrollY + windowHeight/2 - modalHeight/2, scrollY + windowHeight - modalHeight - 20);

        // Appliquer la position calculée au modal
        modal.style.top = modalTop+100 + 'px';

    }
    else if(value == "vaEtreMod"){
        var caseCoche = -1;
        var checkboxes = document.querySelectorAll('input[name="nMod"]');
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                caseCoche = i;
                break;
            }
        }
        if(caseCoche != -1){
            remplirForm();
            modal.classList.add("hiddenMod");
            modalMod.classList.remove("hiddenMod2");
            const scrollY = window.scrollY;
            const windowHeight = window.innerHeight;

            // Calculer la position du modal en fonction de la position de l'utilisateur
            const modalHeight = modal.offsetHeight;
            const modalTop = Math.min(scrollY + windowHeight/2 - modalHeight/2, scrollY + windowHeight - modalHeight - 20);

            // Appliquer la position calculée au modal
            modalMod.style.top = modalTop-20+ 'px';

        }
        else{
            alert("Vous devez cocher une case !");
        }
    }
    else{
        let data = "rafraichir";
        let jsonString = JSON.stringify(data);
        $.ajax({
            type: "POST",
            url: "../PHP/CalendrierPrincipal.php",
            data: {Arafraichir: jsonString},
            success: function (r) {
            }
        });
        let form = document.getElementById("modEdt");
        form.reset();
        modalMod.classList.add("hiddenMod2");
        modal.classList.add("hiddenMod");
        overlay.classList.add("hidden");
    }
}

function manipModal(value){
    const modal = document.querySelector(".modal");
    const overlay = document.querySelector(".overlay");
    let form2 = document.getElementById("modEdt");
    form2.reset();
    if(value == "open"){
        modal.classList.remove("hidden");
        overlay.classList.remove("hidden");
        // Récupérer la position de l'utilisateur
        const scrollY = window.scrollY;
        const windowHeight = window.innerHeight;

        // Calculer la position du modal en fonction de la position de l'utilisateur
        const modalHeight = modal.offsetHeight;
        const modalTop = Math.min(scrollY + windowHeight/2 - modalHeight/2, scrollY + windowHeight - modalHeight - 20);

        // Appliquer la position calculée au modal
        modal.style.top = modalTop+250 + 'px';
    }
    else{
        let data = "rafraichir";
        let jsonString = JSON.stringify(data);
        $.ajax({
            type: "POST",
            url: "../PHP/CalendrierPrincipal.php",
            data: {Arafraichir: jsonString},
            success: function (r) {
            }
        });
        let form = document.getElementById("emploiDeTemps");
        modal.classList.add("hidden");
        overlay.classList.add("hidden");
        cacherLabels();
        form.reset();
    }
}
function manipModalSupp(value, t1, t2, t3, t4, g){
    const modal = document.querySelector(".modalSupression");
    const overlay = document.querySelector(".overlay");
    let form2 = document.getElementById("modEdt");
    form2.reset();

    if(value == "open"){
        overlay.classList.remove("hidden");
        modal.classList.remove("hiddenSupp");
        let data = [t1, t2, t3, t4, g];
        let jsonString = JSON.stringify(data);
        $.ajax({
            type: "POST",
            url: "../PHP/CalendrierPrincipal.php",
            data: {ASupprimer: jsonString},
            success: function (r) {
            }
        });
        // Récupérer la position de l'utilisateur
        const scrollY = window.scrollY;
        const windowHeight = window.innerHeight;

        // Calculer la position du modal en fonction de la position de l'utilisateur
        const modalHeight = modal.offsetHeight;
        const modalTop = Math.min(scrollY + windowHeight/2 - modalHeight/2, scrollY + windowHeight - modalHeight - 20);

        // Appliquer la position calculée au modal
        modal.style.top = modalTop+100 + 'px';
    }
    else if(value == "vaEtreSupp"){
        let form = document.getElementById("suppEdt");
        modal.classList.add("hiddenSupp");
        overlay.classList.add("hidden");
        form.reset();
        afficherCasesLabels2();
    }
    else{
        let form = document.getElementById("suppEdt");
        modal.classList.add("hiddenSupp");
        overlay.classList.add("hidden");
        form.reset();
        afficherCasesLabels2();
        let data = "rafraichir";
        let jsonString = JSON.stringify(data);
        $.ajax({
            type: "POST",
            url: "../PHP/CalendrierPrincipal.php",
            data: {Arafraichir: jsonString},
            success: function (r) {
            }
        });
    }
}


function afficherCasesLabels(value) {
    // déterminer le nombre de cases cochées
    var nbCases = value;
    var nbCases2 = 0;
    var checkboxes = document.querySelectorAll('input[name="nb_Groupes"]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            nbCases2++;
        }
    }

    // masquer tous les labels
    var labels = document.querySelectorAll('.select2');
    for (var i = 0; i < nbCases; i++) {
        labels[i].style.display = 'block';
    }
    if(nbCases2 == 0){
        for (var i = 0; i < labels.length; i++) {
            labels[i].style.display = 'none';
        }
    }
}




function afficherCasesLabels2() {
    // Récupération des éléments HTML nécessaires
    let checkboxSupp1 = document.getElementById("s1");
    let checkboxSupp2 = document.getElementById("s2");

    let labelSupp1 = document.getElementById("ss1");
    let labelSupp2 = document.getElementById("ss2");


    if(!checkboxSupp1.checked){
        checkboxSupp1.style.display = "inline-block";
        labelSupp1.style.display = "inline-block";
    }
    if(!checkboxSupp2.checked){
        checkboxSupp2.style.display = "inline-block";
        labelSupp2.style.display = "inline-block";
    }
}

function cacherCasesLabels2() {
    // Récupération des éléments HTML nécessaires
    let checkboxSupp1 = document.getElementById("s1");
    let checkboxSupp2 = document.getElementById("s2");

    let labelSupp1 = document.getElementById("ss1");
    let labelSupp2 = document.getElementById("ss2");

    if(checkboxSupp1.checked){
        checkboxSupp2.style.display = "none";
        labelSupp2.style.display = "none";
    }
    else if(checkboxSupp2.checked){
        checkboxSupp1.style.display = "none";
        labelSupp1.style.display = "none";
    }
}

function cacherLabels(){
    // masquer tous les labels
    let labels = document.querySelectorAll('.select2');
    for (let i = 0; i < labels.length; i++) {
        labels[i].style.display = 'none';
    }
}



function getDatesBetween(startDate, endDate) {
    const dates = [];
    let currentDate = new Date(startDate);
    const addLeadingZero = (number) => (number < 10 ? "0" + number : number);

    while (currentDate <= new Date(endDate)) {
        const year = currentDate.getFullYear();
        const month = addLeadingZero(currentDate.getMonth() + 1);
        const day = addLeadingZero(currentDate.getDate());
        const dateString = `${year}-${month}-${day}`;
        dates.push(dateString);
        currentDate.setDate(currentDate.getDate() + 7);
    }
    return dates;
}

function ajouteCours(){
    let form = document.getElementById("emploiDeTemps");
    const formData = new FormData(form);
    let dateDebut = formData.get("dateDebut"); // Date du début du cours
    let dateFin = formData.get("dateFin"); // Date de fin du cours
    let heureD = document.getElementsByName("heureDebut")[0].value;
    let minuteD = document.getElementsByName("minuteDebut")[0].value;
    let heureF = document.getElementsByName("heureFin")[0].value;
    let minuteF = document.getElementsByName("minuteFin")[0].value;
    let heureDebut = "".concat(heureD, ":", minuteD); // Heure du début du cours
    let heureFin = "".concat(heureF, ":", minuteF); // Heure de fin du cours
    let typeCour = document.getElementsByName("typeCours")[0].value; // Créneau du cours
    let matiere = document.getElementsByName("matiere")[0].value; // Matiére
    let nbGroupes = document.getElementsByName("nb_Groupes");
    let filiere = JSON.parse(document.getElementById('filiere').getAttribute('filiere'));
    let niveau = JSON.parse(document.getElementById('niveau').getAttribute('niveau'));
    for(let i = 0; i < nbGroupes.length; i++){
        if(nbGroupes[i].checked){
            nbGroupes = nbGroupes[i].value;
            break;
        }
    }
    if(nbGroupes == "n1"){
        var quelGroupe1 = document.getElementsByName("quelGroupe1")[0].value;
        var quelSalle1 = document.getElementsByName("quelSalle1")[0].value;
        var coordinateur1 = document.getElementsByName("quelEnseignant1")[0].value; // Le coordinateur du cours
        var data = [nbGroupes, dateDebut, dateFin, heureDebut, heureFin, typeCour, matiere, coordinateur1, quelGroupe1, quelSalle1];
    }
    else if(nbGroupes == "n2"){
        var quelGroupe1 = document.getElementsByName("quelGroupe1")[0].value;
        var quelSalle1 = document.getElementsByName("quelSalle1")[0].value;
        var coordinateur1 = document.getElementsByName("quelEnseignant1")[0].value; // Le coordinateur du cours
        var quelGroupe2 = document.getElementsByName("quelGroupe2")[0].value;
        var quelSalle2 = document.getElementsByName("quelSalle2")[0].value;
        var coordinateur2 = document.getElementsByName("quelEnseignant2")[0].value; // Le coordinateur du cours
        var data = [nbGroupes, dateDebut, dateFin, heureDebut, heureFin, typeCour, matiere, coordinateur1, quelGroupe1, quelSalle1, coordinateur2, quelGroupe2, quelSalle2];

    }
    else if(nbGroupes == "n3"){
        var quelGroupe1 = document.getElementsByName("quelGroupe1")[0].value;
        var quelSalle1 = document.getElementsByName("quelSalle1")[0].value;
        var coordinateur1 = document.getElementsByName("quelEnseignant1")[0].value; // Le coordinateur du cours
        var quelGroupe2 = document.getElementsByName("quelGroupe2")[0].value;
        var quelSalle2 = document.getElementsByName("quelSalle2")[0].value;
        var coordinateur2 = document.getElementsByName("quelEnseignant2")[0].value; // Le coordinateur du cours
        var quelGroupe3 = document.getElementsByName("quelGroupe3")[0].value;
        var quelSalle3 = document.getElementsByName("quelSalle3")[0].value;
        var coordinateur3 = document.getElementsByName("quelEnseignant3")[0].value; // Le coordinateur du cours
        var data = [nbGroupes, dateDebut, dateFin, heureDebut, heureFin, typeCour, matiere, coordinateur1, quelGroupe1, quelSalle1, coordinateur2, quelGroupe2, quelSalle2, coordinateur3, quelGroupe3, quelSalle3];
    }
    var jsonString = JSON.stringify(data);
    var arrayWeek = JSON.parse(document.getElementById('arrayWeek').getAttribute('data-array'));
    $.ajax({
        type: "POST",
        url: "../PHP/CalendrierPrincipal.php",
        data: {ajoutEmploiDuTemps: jsonString},
        success: function (r) {
            console.log(r);
            $.getJSON("../JSON/emploiDuTemps.json", function (json) {
                let tab = new Array(44);
                let g = new Array(3);
                g[0] = 'G1';
                g[1] = 'G2';
                g[2] = 'G3';
                for (let i = 0; i < tab.length; i++) {
                    tab[i] = new Array(15);
                    for (let j = 0; j < tab[i].length; j++) {
                        tab[i][j] = 99;
                    }
                }
                const ranking = document.querySelector("#tableEDT > tbody");
                while (ranking.firstChild) {
                    ranking.removeChild(ranking.firstChild);
                }
                let tabI = 0;
                let tabJ = 0;
                for (let i = 8; i < 19; i++) {
                    for (let j = 0; j <= 45; j += 15) {
                        const tr = document.createElement("tr");
                        let m = (j == 0 ? '00' : j);
                        let h = (i < 10 ? "".concat('0', i) : i);
                        const hour = "".concat(h, ':', m);
                        const tdH = document.createElement("td");
                        tdH.innerHTML = "".concat(i, ":", m);
                        tdH.setAttribute('id', 'Cln');
                        tdH.style.backgroundColor = "#f2f2f2";
                        tr.appendChild(tdH);
                        for (let jourSemaine = 0; jourSemaine < 5; jourSemaine++) {
                            let jour = arrayWeek[jourSemaine];
                            let [jour2, mois2, annee2] = jour.split("-");
                            g.forEach((groupe) => {
                                json[filiere][niveau].forEach((row) => {
                                    let dates = getDatesBetween(row['dateDebut'], row['dateFin']);
                                    for (let date = 0; date < dates.length; date++) {
                                        let [annee1, mois1, jour1] = dates[date].split("-");
                                        if (row['heureDebut'] == hour && jour1 == jour2 && mois1 == mois2 && annee1 == annee2 && groupe == row['Groupe'] && tab[tabI][tabJ] == 99) {
                                            let [hours, mins] = row['heureDebut'].split(":");
                                            let [hoursFin, minsFin] = row['heureFin'].split(":");
                                            var rowIndex = ((hours - 8) * 4) + 2; // calculer l'index de ligne en fonction de l'heure de début
                                            if (mins == 15) {
                                                rowIndex += 1;
                                            } else if (mins == 30) {
                                                rowIndex += 2;
                                            } else if (mins == 45) {
                                                rowIndex += 3;
                                            }
                                            var rowIndexFin = ((hoursFin - 8) * 4) + 2; // calculer l'index de ligne en fonction de l'heure de début
                                            if (minsFin == 15) {
                                                rowIndexFin += 1;
                                            } else if (minsFin == 30) {
                                                rowIndexFin += 2;
                                            } else if (minsFin == 45) {
                                                rowIndexFin += 3;
                                            }
                                            let duration = rowIndexFin - rowIndex;
                                            const td = document.createElement("td");
                                            $.getJSON("../JSON/cours.json", function (c) {
                                                for (let i = 0; i < c[filiere][niveau].length; i++) {
                                                    if (c[filiere][niveau][i]['nom'] == row['matiere']) {
                                                        td.style.backgroundColor = c[filiere][niveau][i]['color'];
                                                        break;
                                                    }
                                                }
                                            });
                                            let button = document.createElement("button");
                                            let i = document.createElement("i");
                                            i.innerHTML = '&#xf014;';
                                            i.style.color = 'red';
                                            i.style.fontSize = '24px';
                                            i.className = 'fa';
                                            button.appendChild(i);
                                            button.className = 'trash';
                                            let button2 = document.createElement("button");
                                            let i2 = document.createElement("i");
                                            i2.style.color = '#E4E4E1';
                                            i2.style.fontSize = '24px';
                                            i2.className = 'fa-solid fa-pen-to-square';
                                            button2.appendChild(i2);
                                            button2.className = 'trash';
                                            td.innerHTML = row['typeDeCours'] + "<br> " + row['matiere'] + "<br> " + row['Coordinateur'] + "<br> " + row['Salle'] + "<br>";
                                            button.addEventListener("click", function () {
                                                manipModalSupp('open', row['dateDebut'], row['heureDebut'], jour, row['dateFin'], groupe);
                                            });
                                            button2.addEventListener("click", function () {
                                                manipModalMod('open', row['dateDebut'], row['heureDebut'], jour, row['dateFin'], groupe);
                                            });
                                            td.appendChild(button2);
                                            td.appendChild(button);
                                            td.rowSpan = duration;
                                            tr.appendChild(td);
                                            for (let i2 = tabI; i2 < tabI + duration; i2++) {
                                                tab[i2][tabJ] = 0;
                                            }
                                        }
                                    }
                                });
                                if (tab[tabI][tabJ] == 99) {
                                    let reformattedDate = "".concat(annee2, '-', mois2, '-', jour2);
                                    const td = document.createElement("td");
                                    let groupee = ''.concat(groupe);
                                    td.innerHTML = "<button onclick=\"manipModal('open'); rempliForm('" + reformattedDate + "', '" + h + "', '" + m + "', '" + groupee + "');\">+</button>";
                                    tr.appendChild(td);
                                }
                                tabJ++;
                            });
                        }
                        ranking.appendChild(tr);
                        tabI++;
                        tabJ = 0;
                    }
                }
            });
            let form2 = document.getElementById("modEdt");
            form2.reset();
        }
    });
    return false;
}

function rempliForm(dateD, heureDebut, minuteDebut, group) {
    let dateObj = new Date(dateD);
    let year = dateObj.getFullYear();
    let month = dateObj.getMonth() + 1;
    let day = dateObj.getDate();
    let dateDebut = year + "-" + (month < 10 ? "0" : "") + month + "-" + (day < 10 ? "0" : "") + day;
    document.getElementsByName("dateDebut")[0].value = dateDebut;
    let heure = document.getElementsByName("heureDebut")[0];
    heure.value = heureDebut;
    let minute = document.getElementsByName("minuteDebut")[0];
    minute.value = minuteDebut;
    let nbGroupes = document.getElementsByName("nb_Groupes")[0];
    nbGroupes.checked = true;
    afficherCasesLabels(1);
    document.getElementsByName("quelGroupe1")[0].value = group;

}



function suppCours(){
    let filiere = JSON.parse(document.getElementById('filiere').getAttribute('filiere'));
    let niveau = JSON.parse(document.getElementById('niveau').getAttribute('niveau'));
    let nbGroupes = document.getElementsByName("nSupp");
    let arrayWeek = JSON.parse(document.getElementById('arrayWeek').getAttribute('data-array'));

    for(let i = 0; i < nbGroupes.length; i++){
        if(nbGroupes[i].checked){
            nbGroupes = nbGroupes[i].value;
            break;
        }
    }
    if(nbGroupes == "s1"){
        var data = [nbGroupes];
    }
    else if(nbGroupes == "s2"){
        var data = [nbGroupes];
    }
    let jsonString = JSON.stringify(data);
    $.ajax({
        type: "POST",
        url: "../PHP/CalendrierPrincipal.php",
        data: {supprEdt : jsonString},

        success: function(r){
            $.getJSON("../JSON/emploiDuTemps.json", function (json) {
                let tab = new Array(44);
                let g = new Array(3);
                g[0] = 'G1';
                g[1] = 'G2';
                g[2] = 'G3';
                for(let i = 0; i < tab.length; i++){
                    tab[i] = new Array(15);
                    for(let j = 0; j < tab[i].length; j++){
                        tab[i][j] = 99;
                    }
                }
                const ranking = document.querySelector("#tableEDT > tbody");
                while(ranking.firstChild){
                    ranking.removeChild(ranking.firstChild);
                }
                let tabI = 0;
                let tabJ = 0;
                for(let i = 8; i < 19; i++){
                    for(let j = 0; j <= 45; j += 15){
                        const tr = document.createElement("tr");
                        let m = (j == 0 ? '00' : j);
                        let h = (i < 10 ? "".concat('0', i) : i);
                        const hour = "".concat(h, ':', m);
                        const tdH = document.createElement("td");
                        tdH.innerHTML = "".concat(i,":",m);
                        tdH. setAttribute('id','Cln');
                        tdH.style.backgroundColor = "#f2f2f2";
                        tr.appendChild(tdH);
                        for(let jourSemaine = 0; jourSemaine < 5; jourSemaine++){
                            let jour = arrayWeek[jourSemaine];
                            let [jour2, mois2, annee2] = jour.split("-");
                            g.forEach((groupe) => {
                                json[filiere][niveau].forEach((row) => {
                                    let dates = getDatesBetween(row['dateDebut'],row['dateFin']);
                                    for(let date = 0; date < dates.length; date++) {
                                        let [annee1, mois1, jour1] = dates[date].split("-");
                                        if (row['heureDebut'] == hour && jour1 == jour2 && mois1 == mois2 && annee1 == annee2 && groupe == row['Groupe'] && tab[tabI][tabJ] == 99) {
                                            let [hours, mins] = row['heureDebut'].split(":");
                                            let [hoursFin, minsFin] = row['heureFin'].split(":");
                                            var rowIndex = ((hours - 8) * 4) + 2; // calculer l'index de ligne en fonction de l'heure de début
                                            if(mins == 15){
                                                rowIndex += 1;
                                            }
                                            else if(mins == 30){
                                                rowIndex += 2;
                                            }
                                            else if(mins == 45){
                                                rowIndex += 3;
                                            }
                                            var rowIndexFin = ((hoursFin - 8) * 4) + 2; // calculer l'index de ligne en fonction de l'heure de début
                                            if(minsFin == 15){
                                                rowIndexFin += 1;
                                            }
                                            else if(minsFin == 30){
                                                rowIndexFin += 2;
                                            }
                                            else if(minsFin == 45){
                                                rowIndexFin += 3;
                                            }
                                            let duration = rowIndexFin - rowIndex;
                                            const td = document.createElement("td");
                                            $.getJSON("../JSON/cours.json", function (c) {
                                                for (let i = 0; i < c[filiere][niveau].length; i++) {
                                                    if (c[filiere][niveau][i]['nom'] == row['matiere']) {
                                                        td.style.backgroundColor = c[filiere][niveau][i]['color'];
                                                        break;
                                                    }
                                                }
                                            });
                                            let button = document.createElement("button");
                                            let i = document.createElement("i");
                                            i.innerHTML = '&#xf014;';
                                            i.style.color = 'red';
                                            i.style.fontSize = '24px';
                                            i.className = 'fa';
                                            button.appendChild(i);
                                            button.className = 'trash';
                                            let button2 = document.createElement("button");
                                            let i2 = document.createElement("i");
                                            i2.style.color = '#E4E4E1';
                                            i2.style.fontSize = '24px';
                                            i2.className = 'fa-solid fa-pen-to-square';
                                            button2.appendChild(i2);
                                            button2.className = 'trash';
                                            td.innerHTML = row['typeDeCours']  + "<br> " + row['matiere'] + "<br> " + row['Coordinateur'] + "<br> " + row['Salle'] + "<br>";
                                            button.addEventListener("click", function() {
                                                manipModalSupp('open', row['dateDebut'], row['heureDebut'], jour, row['dateFin'], groupe);
                                            });
                                            button2.addEventListener("click", function() {
                                                manipModalMod('open', row['dateDebut'], row['heureDebut'], jour, row['dateFin'], groupe);
                                            });
                                            td.appendChild(button2);
                                            td.appendChild(button);
                                            td.rowSpan = duration;
                                            tr.appendChild(td);
                                            for (let i2 = tabI; i2 < tabI + duration; i2++) {
                                                tab[i2][tabJ] = 0;
                                            }
                                        }
                                    }
                                });
                                if(tab[tabI][tabJ] == 99){
                                    let reformattedDate = "".concat(annee2, '-', mois2, '-', jour2);
                                    const td = document.createElement("td");
                                    let groupee = ''.concat(groupe);
                                    td.innerHTML = "<button onclick=\"manipModal('open'); rempliForm('" + reformattedDate + "', '" + h + "', '" + m + "', '" + groupee + "');\">+</button>";
                                    tr.appendChild(td);
                                }
                                tabJ++;
                            });
                        }
                        ranking.appendChild(tr);
                        tabI++;
                        tabJ = 0;
                    }
                }
            });
            let form2 = document.getElementById("modEdt");
            form2.reset();
        }
    });
    return false;

}









