<?php
    session_start();
    $contenu = file_get_contents('../JSON/comptes.json');
    $infos = json_decode($contenu, true); // transforme le contenu en tableau associatif
    foreach ($infos as $info) {
        if ($info['email'] == $_SESSION['email']) {
            $nom_utilisateur = $info['nom'];
            $prenom_utilisateur = $info['prenom'];
            $email = $info['email'];
            $fonction = $info['fonction'];
            $niveau = $info['niveau'];
            $filiere = $info['filiere'];
            break;
        }
    }
    echo '<div id="filiere" filiere="' . htmlspecialchars(json_encode($filiere), ENT_QUOTES, 'UTF-8') . '"></div>' ;
    echo '<div id="niveau" niveau="' . htmlspecialchars(json_encode($niveau), ENT_QUOTES, 'UTF-8') . '"></div>' ;
?>
<?php
    if(file_exists('../JSON/cours.json')){
        $contenuCourstmp = file_get_contents('../JSON/cours.json');
        $cours = json_decode($contenuCourstmp, true);
    }
    if(file_exists('../JSON/enseignants.json')){
        $contenuEnseignantstmp = file_get_contents('../JSON/enseignants.json');
        $enseignants = json_decode($contenuEnseignantstmp, true);
    }
    if(file_exists('../JSON/salles.json')){
        $contenuSallestmp = file_get_contents('../JSON/salles.json');
        $salles = json_decode($contenuSallestmp, true);
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>DashBoard</title>
        <link rel="stylesheet" href="../CSS/DashBoard.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script src="../JS/DashBoard.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    </head>
    <body>
        <header>
            <div id="wrap">
                <nav>
                    <a href="../PHP/Accueil.php">Accueil</a>
                    <a href="../PHP/CalendrierPrincipal.php">Calendrier</a>
                    <?php
                    if($fonction == 'Responsable'){
                        echo " <a class='active'>DashBoard</a>";
                    }
                    ?>
                    <a href="../PHP/Deconnexion.php" class="exit"><i class="fa-solid fa-power-off" style="font-size:20px;"></i></a>
                </nav>
            </div>
        </header>
        <div class="container">
            <!--- Coordinateurs ---->
            <section class="modalCoordinateur hidden">
                <div class="flexCoordinateur">
                    <button class="btn-close" onclick="manipModalCoordinateurs('close');">⨉</button>
                </div>
                <div class="scrollList" id="scrollList1">
                    <table class="Coordinateur">
                        <thead>
                        <tr>
                            <th></th>
                            <th><center>Noms des Coordinateurs</center></th>
                            <th><center>Adresse mail</center></th>
                        </tr>
                        </thead>
                        <tbody id="tableEnseignants">
                            <?php
                                $i = 0;
                                foreach ($enseignants[$filiere][$niveau] as $enseignant) {
                                    echo '<tr>';
                                    echo "<td><input type='checkbox' name='checkEnseignant' onclick='cacherModifier(\"checkEnseignant\");' ></td>";
                                    echo '<td>'.$enseignant['nom'].' '.$enseignant['prenom'].'</td>';
                                    echo '<td>'.$enseignant['email'].'</td>';
                                    echo '</tr>';
                                    $i++;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="modifyFormCoord" style="display: none;">
                    <form method="post" name="coordModify" id="coordModify">
                        <input type="hidden" name="coordModify" value="formCoordModify">
                        <div class="addForm1">
                            <h3>Veuillez modifier les informations de l'enseignant :</h3><br>
                            <input type="text" placeholder="nom" name="nom"><br>
                            <input type="text" placeholder="prenom" name="prenom"><br>
                            <input type="text" placeholder="email" name="email"><br>
                        </div>
                        <div class="addForm2">
                            <button class="btnFormCoord" onclick="afficheFormCoord2(); return false;">Retour</button>
                            <button class="btnFormCoord" onclick="modifieCoord();return false;">Enregistrer</button>
                        </div>
                    </form>
                </div>
                <div id="addFormCoordSupp" style="display: none;">
                    <form method="post" name="enseignants">
                        <input type="hidden" name="enseignants" value="formCoordinateurSupp">
                        <div class="addForm1">
                            <h3>Êtes-vous sûr ?</h3><br>
                        </div>
                        <div class="addForm2">
                            <button class="btnFormCoord" onclick="afficheFormCoordSupp(); return false;">Annuler</button>
                            <button class="btnFormCoord" onclick="supprimerEnseignants();afficheFormCoordSupp(); return false;">Supprimer</button>
                        </div>
                    </form>
                </div>
                <div id="addFormCoord" style="display: none;">
                    <form method="post" id="enseignants" name="enseignants">
                        <input type="hidden" name="enseignants" value="formCoordinateur">
                        <div class="addForm1">
                            <h3>Veuillez remplir le formulaire suivant:</h3><br>
                            <input type="text" placeholder="nom" name="nom"><br>
                            <input type="text" placeholder="prenom" name="prenom"><br>
                            <input type="text" placeholder="email" name="email"><br>
                        </div>
                        <div class="addForm2">
                            <button class="btnFormCoord" onclick="afficheFormCoord(); return false;">Retour</button>
                            <button class="btnFormCoord" onclick="ajouterEnseignants();afficheFormCoord(); return false;">Enregistrer</button>
                        </div>
                    </form>
                </div>
                <div class="buttonTable" id="buttonTableCoord">
                    <button class="btn" id="ModifierButton" onclick="modifierCoord();">Modifier</button>
                    <button class="btn" onclick="afficheFormCoord();">Ajouter</button>
                    <button class="btn" onclick="afficheFormCoordSupp();">Supprimer</button>
                </div>
            </section>
            <button class="coordinateurs" onclick="manipModalCoordinateurs('open')"> COORDINATEURS </button>
            <!--- Cours ---->
            <section class="modalCours hidden">
                <div class="flexCours">
                    <button class="btn-close" onclick="manipModalCours('close');">⨉</button>
                </div>
                <div class="scrollList" id="scrollList2">
                    <table>
                        <thead>
                        <tr>
                            <th></th>
                            <th><center>Noms des cours</center></th>
                            <th><center>Couleurs</center></th>
                        </tr>
                        </thead>
                        <tbody id="tableCours">
                        <?php
                        $infosCours = $cours[$filiere][$niveau];
                        foreach ($infosCours as $cour) {
                            echo '<tr>';
                            echo "<td><input type='checkbox' name='checkCours' onclick='cacherModifier(\"checkCours\");' ></td>";
                            echo '<td>'.$cour['nom'].'</td>';
                            echo "<td style='background-color:".$cour['color']."'></td>";
                            echo '</tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div id="modifyFormCours" style="display: none;">
                    <form method="post" name="coursModify" id="coursModify">
                        <input type="hidden" name="coursModify" value="formCoursModify">
                        <div class="addForm1">
                            <h3>Veuillez modifier les informations du cour :</h3><br>
                            <input type="text" placeholder="nom" name="nom">
                            <input type='color' name='colorCour' value='#ff0000' onchange='updateColor();'><br>
                        </div>
                        <div class="addForm2">
                            <button class="btnFormCoord" onclick="afficheFormCours2(); return false;">Retour</button>
                            <button class="btnFormCoord" onclick="modifieCours();return false;">Enregistrer</button>
                        </div>
                    </form>
                </div>
                <div id="addFormCoursSupp" style="display: none;">
                    <form method="post" name="cours">
                        <input type="hidden" name="cours" value="formCoursSupp">
                        <div class="addForm1">
                            <h3>Êtes-vous sûr ?</h3><br>
                        </div>
                        <div class="addForm2">
                            <button class="btnFormCoord" onclick="afficheFormCoursSupp(); return false;">Annuler</button>
                            <button class="btnFormCoord" onclick="supprimerCours();afficheFormCoursSupp(); return false;">Supprimer</button>
                        </div>
                    </form>
                </div>
                <div id="addFormCours" style="display: none;">
                    <form method="post" name="cours" id="cours">
                        <input type="hidden" name="cours" value="formCours">
                        <div class="addForm1">
                            <h3>Veuillez entrez le nom du cour à rajouter :</h3><br>
                            <input type="text" placeholder="nom" name="nom">
                            <input type='color' name='colorCour' value='#ff0000' onchange='updateColor();'><br>
                        </div>
                        <div class="addForm2">
                            <button class="btnFormCoord" onclick="afficheFormCours(); return false;">Retour</button>
                            <button class="btnFormCoord" onclick="ajouterCours();afficheFormCours(); return false;">Enregistrer</button>
                        </div>
                    </form>
                </div>
                <div class="buttonTable" id="buttonTableCours">
                    <button class="btn" id="ModifierButtonCours" onclick="modifierCour();">Modifier</button>
                    <button class="btn" onclick="afficheFormCours();">Ajouter</button>
                    <button class="btn" onclick="afficheFormCoursSupp();">Supprimer</button>
                </div>
            </section>
            <button class="cours"  onclick="manipModalCours('open')"> MATIÈRES </button>

            <!--- Salles ---->
            <section class="modalSalles hidden">
                <div class="flexSalles">
                    <button class="btn-close" onclick="manipModalSalles('close');">⨉</button>
                </div>
                <div class="scrollList" id="scrollList3">
                    <table>
                        <thead>
                        <tr>
                            <th></th>
                            <th><center>Noms des Salles</center></th>
                        </tr>
                        </thead>
                        <tbody id="tableSalle">
                        <?php
                        $i = 0;
                        foreach ($salles as $salle) {
                            echo '<tr>';
                            echo "<td><input type='checkbox' name='checkSalle' onclick='cacherModifier(\"checkSalle\");'></td>";
                            echo '<td>'.$salle['nom'].'</td>';
                            echo '</tr>';
                            $i++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div><div id="modifyFormSalle" style="display: none;">
                    <form method="post" name="salleModify" id="salleModify">
                        <input type="hidden" name="salleModify" value="formSalleModify">
                        <div class="addForm1">
                            <h3>Veuillez modifier les informations de la salle :</h3><br>
                            <input type="text" placeholder="nom" name="nom">
                        </div>
                        <div class="addForm2">
                            <button class="btnFormCoord" onclick="afficheFormSalle2(); return false;">Retour</button>
                            <button class="btnFormCoord" onclick="modifieSalle();return false;">Enregistrer</button>
                        </div>
                    </form>
                </div>
                <div id="addFormSalle" style="display: none;">
                    <form method="post" name="salles" id="salle">
                        <input type="hidden" name="salles" value="formSalles">
                        <div class="addForm1">
                            <h3>Veuillez entrez la salle à rajouter :</h3><br>
                            <input type="text" placeholder="nom" name="nom"><br>
                        </div>
                        <div class="addForm2">
                            <button class="btnFormCoord" onclick="afficheFormSalle(); return false;">Retour</button>
                            <button class="btnFormCoord" onclick="ajouterSalle();afficheFormSalle(); return false;">Enregistrer</button>
                        </div>
                    </form>
                </div>
                <div id="addFormSalleSupp" style="display: none;">
                    <form method="post" name="salle">
                        <input type="hidden" name="salle" value="formSalleSupp">
                        <div class="addForm1">
                            <h3>Êtes-vous sûr ?</h3><br>
                        </div>
                        <div class="addForm2">
                            <button class="btnFormCoord" onclick="afficheFormSalleSupp(); return false;">Annuler</button>
                            <button class="btnFormCoord" onclick="supprimerSalle();afficheFormSalleSupp(); return false;">Supprimer</button>
                        </div>
                    </form>
                </div>
                <div class="buttonTable" id="buttonTableSalle">
                    <button class="btn" id="ModifierButtonSalle" onclick="modifierSalle();">Modifier</button>
                    <button class="btn" onclick="afficheFormSalle();">Ajouter</button>
                    <button class="btn"  onclick="afficheFormSalleSupp();">Supprimer</button>
                </div>
            </section>
            <button class="salles"  onclick="manipModalSalles('open')"> SALLES </button>
            <div class="overlay hidden"></div>
        </div>
    </body>
    <?php

    ?>
</html>

<?php
if(isset($_POST['ajoutCoord'])) {
    if (file_exists('../JSON/enseignants.json')) {
        // le fichier existe, on peut le lire et vérifier si une adresse mail est déjà présente
        $contenuEnseignants = file_get_contents('../JSON/enseignants.json');
        $infosEnseignants = json_decode($contenuEnseignants, true); // transforme le contenu en tableau associatif
        $json_data = $_POST['ajoutCoord'];
        $data = json_decode($json_data, true);
        $enseignantExiste = false;
        foreach ($infosEnseignants[$filiere][$niveau] as $info) {
            if ($info['email'] == $data[2]) {
                $enseignantExiste = true;
                break;
            }
        }
        if (!$enseignantExiste) {
            // Création de la clé 'filiere' si elle n'existe pas déjà
            if (!isset($infosEnseignants[$filiere])) {
                $infosEnseignants[$filiere] = array();
            }

            // Création de la clé 'niveau' pour la filière si elle n'existe pas déjà
            if (!isset($infosEnseignants[$filiere][$niveau])) {
                $infosEnseignants[$filiere][$niveau] = array();
            }
            $infosEnseignants[$filiere][$niveau][] = array(
                'nom' => $data[0],
                'prenom' => $data[1],
                'email' => $data[2],
                'AMS' => ''
            );
            // Convertir le tableau en JSON
            $infosEnseignants_json = json_encode($infosEnseignants, JSON_PRETTY_PRINT);

            // Écrire le JSON dans un fichier
            file_put_contents('../JSON/enseignants.json', $infosEnseignants_json);

        }

    } else {
        // Création de la clé 'filiere' si elle n'existe pas déjà
        if (!isset($infosEnseignants[$filiere])) {
            $infosEnseignants[$filiere] = array();
        }

        // Création de la clé 'niveau' pour la filière si elle n'existe pas déjà
        if (!isset($infosEnseignants[$filiere][$niveau])) {
            $infosEnseignants[$filiere][$niveau] = array();
        }
        // le fichier n'existe pas, il faut le créer et y ajouter les informations
        $json_data = $_POST['ajoutCoord'];
        $data = json_decode($json_data, true);
        $infosEnseignants[$filiere][$niveau][] = array(
            'nom' => $data[0],
            'prenom' => $data[1],
            'email' => $data[2],
            'AMS' => ''
        );
        // Convertir le tableau en JSON
        $infosEnseignants_json = json_encode($infosEnseignants, JSON_PRETTY_PRINT);

        // Écrire le JSON dans un fichier
        file_put_contents('../JSON/enseignants.json', $infosEnseignants_json);
        chmod('../JSON/enseignants.json', 0777);
    }
}
else if(isset($_POST['suppCoord'])){
    $json_data = $_POST['suppCoord'];
    $data = json_decode($json_data, true);
    $contenuEnseignants = file_get_contents('../JSON/enseignants.json');
    $infosEnseignants = json_decode($contenuEnseignants, true); // transforme le contenu en tableau associatif
    foreach($data as $index){
        unset($infosEnseignants[$filiere][$niveau][$index]);
    }
    $infosEnseignants[$filiere][$niveau] = array_values($infosEnseignants[$filiere][$niveau]); // Réorganiser les indices numériques
    // Convertir le tableau en JSON
    $infosEnseignants_json = json_encode($infosEnseignants, JSON_PRETTY_PRINT);

    // Écrire le JSON dans un fichier
    file_put_contents('../JSON/enseignants.json', $infosEnseignants_json);
}
else if(isset($_POST['ajoutCours'])){
    if (file_exists('../JSON/cours.json')) {
        // le fichier existe, on peut le lire et vérifier si une adresse mail est déjà présente
        $contenuCours = file_get_contents('../JSON/cours.json');
        $infosCours = json_decode($contenuCours, true); // transforme le contenu en tableau associatif
        $json_data = $_POST['ajoutCours'];
        $data = json_decode($json_data, true);
        $coursExiste = false;
        foreach ($infosCours[$filiere][$niveau] as $info) {
            if ($info['nom'] == $data[0] && $info['niveau'] == $niveau && $info['filiere'] == $filiere) {
                $coursExiste = true;
                break;
            }
        }
        if (!$coursExiste) {
            // Création de la clé 'filiere' si elle n'existe pas déjà
            if (!isset($infosCours[$filiere])) {
                $infosCours[$filiere] = array();
            }

            // Création de la clé 'niveau' pour la filière si elle n'existe pas déjà
            if (!isset($infosCours[$filiere][$niveau])) {
                $infosCours[$filiere][$niveau] = array();
            }
            $infosCours[$filiere][$niveau][] = array(
                'nom' => $data[0],
                'color' => $data[1],
                'AMS' => ''
            );
            // Convertir le tableau en JSON
            $infosCours_json = json_encode($infosCours, JSON_PRETTY_PRINT);

            // Écrire le JSON dans un fichier
            file_put_contents('../JSON/cours.json', $infosCours_json);

        }
    } else {
        // le fichier n'existe pas, il faut le créer et y ajouter les informations
        $json_data = $_POST['ajoutCours'];
        $data = json_decode($json_data, true);
        $infosCours = array();
        // Création de la clé 'filiere' si elle n'existe pas déjà
        if (!isset($infosCours[$filiere])) {
            $infosCours[$filiere] = array();
        }

        // Création de la clé 'niveau' pour la filière si elle n'existe pas déjà
        if (!isset($infosCours[$filiere][$niveau])) {
            $infosCours[$filiere][$niveau] = array();
        }
        $infosCours[$filiere][$niveau][] = array(
            'nom' => $data[0],
            'color' => $data[1],
            'AMS' => ''
        );
        // Convertir le tableau en JSON
        $infosCours_json = json_encode($infosCours, JSON_PRETTY_PRINT);

        // Écrire le JSON dans un fichier
        file_put_contents('../JSON/cours.json', $infosCours_json);
        chmod('../JSON/cours.json', 0777);

    }
}
else if(isset($_POST['suppCours'])){
    $json_data = $_POST['suppCours'];
    $data = json_decode($json_data, true);
    $contenuCours = file_get_contents('../JSON/cours.json');
    $infosCours = json_decode($contenuCours, true); // transforme le contenu en tableau associatif
    foreach($data as $index){
        unset($infosCours[$filiere][$niveau][$index]);
    }
    $infosCours[$filiere][$niveau] = array_values($infosCours[$filiere][$niveau]); // Réorganiser les indices numériques
    // Convertir le tableau en JSON
    $infosCours_json = json_encode($infosCours, JSON_PRETTY_PRINT);

    // Écrire le JSON dans un fichier
    file_put_contents('../JSON/cours.json', $infosCours_json);
}
else if(isset($_POST['ajoutSalle'])){
    if (file_exists('../JSON/salles.json')) {
        // le fichier existe, on peut le lire et vérifier si une adresse mail est déjà présente
        $contenuSalles = file_get_contents('../JSON/salles.json');
        $infosSalles = json_decode($contenuSalles, true); // transforme le contenu en tableau associatif
        $json_data = $_POST['ajoutSalle'];
        $data = json_decode($json_data, true);
        $salleExiste = false;
        foreach ($infosSalles as $info) {
            if ($info['nom'] == $data[0]) {
                $salleExiste = true;
                break;
            }
        }

        if (!$salleExiste) {
            $infosSalles[] = array(
                'nom' => $data[0],
                'AMS' => ''
            );
            // Convertir le tableau en JSON
            $infosSalles_json = json_encode($infosSalles, JSON_PRETTY_PRINT);

            // Écrire le JSON dans un fichier
            file_put_contents('../JSON/salles.json', $infosSalles_json);
        }
    } else {
        // le fichier n'existe pas, il faut le créer et y ajouter les informations
        $json_data = $_POST['ajoutSalle'];
        $data = json_decode($json_data, true);
        $infosSalles[] = array(
            'nom' => $data[0],
            'AMS' => ''
        );
        // Convertir le tableau en JSON
        $infosSalles_json = json_encode($infosSalles, JSON_PRETTY_PRINT);

        // Écrire le JSON dans un fichier
        file_put_contents('../JSON/salles.json', $infosSalles_json);
        chmod('../JSON/salles.json', 0777);
    }
}
else if(isset($_POST['suppSalle'])){
    $json_data = $_POST['suppSalle'];
    $data = json_decode($json_data, true);
    $contenuSalles = file_get_contents('../JSON/salles.json');
    $infosSalles = json_decode($contenuSalles, true); // transforme le contenu en tableau associatif
    foreach($data as $index){
        unset($infosSalles[$index]);
    }
    $infosSalles = array_values($infosSalles); // Réorganiser les indices numériques
    // Convertir le tableau en JSON
    $infosSalles_json = json_encode($infosSalles, JSON_PRETTY_PRINT);

    // Écrire le JSON dans un fichier
    file_put_contents('../JSON/salles.json', $infosSalles_json);
}
if(isset($_POST['indiceCourAMS'])){
    $json_data = $_POST['indiceCourAMS'];
    $data = json_decode($json_data, true);
    $contenuCours = file_get_contents('../JSON/cours.json');
    $infosCours = json_decode($contenuCours, true); // transforme le contenu en tableau associatif
    $infosCours[$filiere][$niveau][$data[0]]['AMS'] = 'true';
    $contenuCours_json = json_encode($infosCours, JSON_PRETTY_PRINT);

    // Écrire le JSON dans un fichier
    file_put_contents('../JSON/cours.json', $contenuCours_json);
}
if(isset($_POST['rafraichirCour'])){
    $json_data = $_POST['rafraichirCour'];
    $data = json_decode($json_data, true);
    $contenuCours = file_get_contents('../JSON/cours.json');
    $infosCours = json_decode($contenuCours, true); // transforme le contenu en tableau associatif
    for($i = 0; $i < count($infosCours[$filiere][$niveau]); $i++){
        $infosCours[$filiere][$niveau][$i]['AMS'] = '';
    }
    $contenuCours_json = json_encode($infosCours, JSON_PRETTY_PRINT);

    // Écrire le JSON dans un fichier
    file_put_contents('../JSON/cours.json', $contenuCours_json);
}
if(isset($_POST['modifyCourAMS'])){
    $json_data = $_POST['modifyCourAMS'];
    $data = json_decode($json_data, true);
    $contenuCours = file_get_contents('../JSON/cours.json');
    $infosCours = json_decode($contenuCours, true); // transforme le contenu en tableau associatif
    for($i = 0; $i < count($infosCours[$filiere][$niveau]); $i++){
        if($infosCours[$filiere][$niveau][$i]['AMS'] == 'true'){
            $infosCours[$filiere][$niveau][$i]['nom'] = $data[0];
            $infosCours[$filiere][$niveau][$i]['color'] = $data[1];
            $infosCours[$filiere][$niveau][$i]['AMS'] = '';
            break;
        }
    }
    $contenuCours_json = json_encode($infosCours, JSON_PRETTY_PRINT);

    // Écrire le JSON dans un fichier
    file_put_contents('../JSON/cours.json', $contenuCours_json);
}

if(isset($_POST['indiceCoordAMS'])){
    $json_data = $_POST['indiceCoordAMS'];
    $data = json_decode($json_data, true);
    $contenuEnseignants = file_get_contents('../JSON/enseignants.json');
    $infosEnseignants = json_decode($contenuEnseignants, true);
    $infosEnseignants[$filiere][$niveau][$data[0]]['AMS'] = 'true';
    $contenuEnseignants_json = json_encode($infosEnseignants, JSON_PRETTY_PRINT);

    // Écrire le JSON dans un fichier
    file_put_contents('../JSON/enseignants.json', $contenuEnseignants_json);
}
if(isset($_POST['rafraichirCoord'])){
    $json_data = $_POST['rafraichirCoord'];
    $data = json_decode($json_data, true);
    $contenuEnseignants = file_get_contents('../JSON/enseignants.json');
    $infosEnseignants = json_decode($contenuEnseignants, true);
    for($i = 0; $i < count($infosEnseignants[$filiere][$niveau]); $i++){
        $infosEnseignants[$filiere][$niveau][$i]['AMS'] = '';
    }
    $contenuEnseignants_json = json_encode($infosEnseignants, JSON_PRETTY_PRINT);

    // Écrire le JSON dans un fichier
    file_put_contents('../JSON/enseignants.json', $contenuEnseignants_json);
}
if(isset($_POST['modifyCoordAMS'])){
    $json_data = $_POST['modifyCoordAMS'];
    $data = json_decode($json_data, true);
    $contenuEnseignants = file_get_contents('../JSON/enseignants.json');
    $infosEnseignants = json_decode($contenuEnseignants, true); // transforme le contenu en tableau associatif
    for($i = 0; $i < count($infosEnseignants[$filiere][$niveau]); $i++){
        if($infosEnseignants[$filiere][$niveau][$i]['AMS'] == 'true'){
            $infosEnseignants[$filiere][$niveau][$i]['nom'] = $data[0];
            $infosEnseignants[$filiere][$niveau][$i]['prenom'] = $data[1];
            $infosEnseignants[$filiere][$niveau][$i]["email"] = $data[2];
            $infosEnseignants[$filiere][$niveau][$i]['AMS'] = '';
            break;
        }
    }
    $contenuEnseignants_json = json_encode($infosEnseignants, JSON_PRETTY_PRINT);

    // Écrire le JSON dans un fichier
    file_put_contents('../JSON/enseignants.json', $contenuEnseignants_json);
}

if(isset($_POST['indiceSalleAMS'])){
    $json_data = $_POST['indiceSalleAMS'];
    $data = json_decode($json_data, true);
    $contenuSalles = file_get_contents('../JSON/salles.json');
    $infosSalles = json_decode($contenuSalles, true);
    $infosSalles[$data[0]]['AMS'] = 'true';
    $contenuSalles_json = json_encode($infosSalles, JSON_PRETTY_PRINT);

    // Écrire le JSON dans un fichier
    file_put_contents('../JSON/salles.json', $contenuSalles_json);
}
if(isset($_POST['rafraichirSalle'])){
    $json_data = $_POST['rafraichirSalle'];
    $data = json_decode($json_data, true);
    $contenuSalles = file_get_contents('../JSON/salles.json');
    $infosSalles = json_decode($contenuSalles, true);
    for($i = 0; $i < count($infosSalles); $i++){
        $infosSalles[$i]['AMS'] = '';
    }
    $contenuSalles_json = json_encode($infosSalles, JSON_PRETTY_PRINT);

    // Écrire le JSON dans un fichier
    file_put_contents('../JSON/salles.json', $contenuSalles_json);
}
if(isset($_POST['modifySalleAMS'])){
    $json_data = $_POST['modifySalleAMS'];
    $data = json_decode($json_data, true);
    $contenuSalles = file_get_contents('../JSON/salles.json');
    $infosSalles = json_decode($contenuSalles, true);
    for($i = 0; $i < count($infosSalles); $i++){
        if($infosSalles[$i]['AMS'] == 'true'){
            $infosSalles[$i]['nom'] = $data[0];
            $infosSalles[$i]['AMS'] = '';
            break;
        }
    }
    $contenuSalles_json = json_encode($infosSalles, JSON_PRETTY_PRINT);

    // Écrire le JSON dans un fichier
    file_put_contents('../JSON/salles.json', $contenuSalles_json);
}

?>
