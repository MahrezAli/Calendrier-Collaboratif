<?php
session_start();
//Extraire les informations de l'utilisateur
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

//Extraire les informations des cours
if(file_exists('../JSON/cours.json')) {
    $contenuCours = file_get_contents('../JSON/cours.json');
    $coursDecode = json_decode($contenuCours, true);
    $cours = $coursDecode[$filiere][$niveau];
}

//Extraire les informations des salles
if(file_exists('../JSON/salles.json')) {
    $contenuSalles = file_get_contents('../JSON/salles.json');
    $salles = json_decode($contenuSalles, true);
}

//Extraire les informations des Coordinateurs
if(file_exists('../JSON/enseignants.json')) {
    $contenuCoordinateur = file_get_contents('../JSON/enseignants.json');
    $coordinateurs = json_decode($contenuCoordinateur, true);
}

//Extraire les informations des Emplois de temps
if(file_exists('../JSON/emploiDuTemps.json')){
    $contenuEDT = file_get_contents('../JSON/emploiDuTemps.json');
    $edt = json_decode($contenuEDT, true);
}


/*$informatique = [['Introduction Python', 'Programmation Impérative', 'Programmation Modulaire', 'Algorithmique Structure de Donnée', 'Algèbre Linéaire', "Math pour l'info", 'Calculus', 'Analyse', 'Anglais', 'SPOC', 'Explorer Environnement Professionnel'],
    ['BDD', 'Programmation fonctionnelle', 'Programmation Objet', 'Génie Logiciel', "Math pour l'info", 'OLA', 'PIL', 'Architecture des Ordinateurs', 'Réseaux', 'Introduction au science de données', 'Anglais', 'SPOC'],
    ['Algorithme', 'Logique', 'Système', 'Réseaux avancés', 'BD2', 'PFA', 'PCII', 'IAS', 'IA', 'Programmation Web', 'Bio-Informatique', 'LF', 'Analyse Combinatoire', 'Programmation Interface']];
$biologie = [['Biologie 1 : Unité, diversité, évolution du vivant', "Chimie 1 : De l'atome à la matière", 'Chimie-Biologie : Aux origines de la vie', 'Mathématiques', 'Système Terre, Climat, Énergies', "Biologie 2 : De la molécule à l'organisme", 'Chimie 2 : Transformations et propriétés de la matière', 'Physique', 'PPEI', 'Anglais', 'Méthodologie scientifique', 'Minéraux et roches', 'Stage de terrain en Géosciences', 'Bases physiques, anatomiques et physiologiques pour la kinésithérapie'],
    ['Génétique et Biologie Moléculaire 1', 'Biochimie', 'Écologie et Génétique des PopulationsÉcologie et Génétique des Populations', 'Informatique pour la biologie', 'Statistiques pour la biologie', 'Génétique et Biologie Moléculaire 2', 'Biologie cellulaire et développement', 'Écologie et Statistiques', 'Physiologie végétale', 'Les fondamentaux de Physiologie animale', 'Écologie des populations et des communautés', 'MES', 'Anglais', 'PPEI', 'SPOC', 'Biochimie', 'Statistiques pour la biologie', 'Biologie cellulaire et développement', 'Chimie générale I'],
    ['Écologie des écosystèmes', 'Botanique', "De l'exploration des génomes à la fonction des macromolécules", 'Utilisation et applications de la bioinformatique en sciences du vivant', 'Génétique des populations', 'Écologie : théorie et pratique', 'Biologie évolutive', 'Modèles dynamiques en biologie', 'Organisation et diversité des Métazoaires', 'Physiologie des Fonctions Cardiorespiratoires, Digestives et Métabolisme', 'Évolution et grandes fonctions des Métazoaires', 'Écophysiologie végétale', 'Physiologie des Régulations Endocrines et Neurosciences', 'TP de Biologie Moléculaire et Biochimie', 'Organisation Fonctionnelle et Dysfonctionnements de la Cellule', 'Géologie et Environnement', "Germination: de l'Organisme à la Molécule"]];
$math = [['Introduction Python', 'Programmation Impérative', 'Programmation Modulaire', 'Algorithmique Structure de Donnée', 'Algèbre Linéaire', "Math pour l'info", 'Calculus', 'Analyse', 'Anglais', 'SPOC', 'Explorer Environnement Professionnel'],
    ['Algèbre_linéaire_2', 'Algèbre et arithmétique', 'Topologie 1', 'Analyse 2 - Séries et Intégrales', 'Topologie 2 - Courbes et surfaces', 'Algèbre linéaire 3', 'Analyse 3 - Suites et Séries de fonctions', 'Probabilités 1', 'Calcul Numérique 1 - Python pour le calcul scientifique', 'Calcul Numérique 2 - Introduction à la modélisation et au calcul scientifique'],
    ['Probabilités 2', 'Equations différentielles ordinaires', 'Algèbre', 'Analyse', 'PPEI - Stage', 'Anglais', 'Statistiques exploratoires multidimensionnelles', 'Méthode numériques pour les équations différentielles', 'Géométrie', 'Construction des nombres, arithmétique et enseignement', 'Analyse matricielle et optimisation', 'Statistiques Inférentielles et Analyse de données', 'Analyse Hilbertienne', 'Topologie et calcul différentiel']];
$physique = [['Optique', 'Calculus', 'Algèbre', 'Mécanique 1', 'Thermodynamique 1', 'Électromagnétisme 1', 'Enseignements Experimentaux', 'Méthode Numérique', 'Analyse 1', 'PPEI', 'Anglais', 'SPOC'],
    ['Électromagnétisme 2', 'Mécanique 2', 'Thermodynamique 2', 'Ondes et Vibrations', 'Physique Numérique', 'Anglais', 'SPOC', 'Algèbre', 'Analyse et Convergence', 'Analyse', 'Enseignements Expérimentaux', 'Électromagnétisme 3', 'Optique Ondulatoire', 'Introduction Physique Quantique'],
    ['Mécanique des fluides', 'Mécanique 3', 'Électromagnétisme 4', 'Physique Quantique', 'Mathématique S5', 'Anglais', 'Comportement des matériaux solides et liquides', 'Thermodynamique appliquée : dispositifs et machines thermiques', 'Instrumentation - électronique', 'Enseignements expérimentaux', 'Electromagnétisme 5', 'Optique', 'Physique statistique']];*/
?>
<?php
    function creneauInclus($HD1, $HF1, $HD2, $HF2) {
        $debut1 = strtotime("1970-01-01T" . $HD1 . ":00Z");
        $fin1 = strtotime("1970-01-01T" . $HF1 . ":00Z");
        $debut2 = strtotime("1970-01-01T" . $HD2 . ":00Z");
        $fin2 = strtotime("1970-01-01T" . $HF2 . ":00Z");

        // Vérifie si le premier créneau est inclus dans le deuxième
        if ($debut1 >= $debut2) {
            if($debut1 < $fin2 || $fin1 < $fin2){
                return true;
            }
        }

        // Vérifie si le deuxième créneau est inclus dans le premier
        if ($debut2 >= $debut1) {
            if($debut2 < $fin1 || $fin2 < $fin1){
                return true;
            }
        }

        // Aucun créneau n'est inclus dans l'autre
        return false;
    }

    function jourPrecedent($date) {
        $timestamp = strtotime($date);
        $jour_precedent = date('Y-m-d', strtotime("-1 day", $timestamp));
        return $jour_precedent;
    }
    function getWeekDates($week, $year) {
        // spécifier le fuseau horaire à utiliser
        $timezone = new DateTimeZone('Europe/Paris');
        $firstMondayOfYear = new DateTime('First Monday of January ' . $year, $timezone);
        $startDate = clone $firstMondayOfYear;
        $startDate->modify("+".(($week - 1) * 7)." days");
        $weekDates = array();
        for ($i = 0; $i < 5; $i++) {
            $day = clone $startDate;
            $day->modify("+{$i} days");
            $weekDates[] = $day->format('d-m-Y');
        }
        return $weekDates;
    }

    //Fonction qui donne les dates avec interval de semaine entre deux dates
    function get_dates_between($start_date, $end_date, $interval_days) {
        $dates = array();
        $current_date = strtotime($start_date);
        $end_date = strtotime($end_date);

        while ($current_date <= $end_date) {
            $dates[] = date('d-m-Y', $current_date);
            $current_date = strtotime('+' . $interval_days . ' days', $current_date);
        }

        return $dates;
    }

    function get_dates_between2($start_date, $end_date) {
        $dates = array();
        $current_date = strtotime($start_date);
        $end_date = strtotime($end_date);

        while ($current_date <= $end_date) {
            $dates[] = date('Y-m-d', $current_date);
            $current_date = strtotime('+1 week', $current_date);
        }

        return $dates;
    }
    //Affiche les dates mais à l'envers
    function get_dates_between5($start_date, $end_date) {
        $dates = array();
        $current_date = strtotime($end_date);
        $end_date = strtotime($start_date);

        while ($current_date >= $end_date) {
            array_push($dates, date('Y-m-d', $current_date));
            $current_date = strtotime('-1 week', $current_date);
        }

        return $dates;
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Calendrier</title>
    <link rel="stylesheet" href="../CSS/CalendrierPrincipal.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../JS/CalendrierPrincipal.js"></script>
</head>
<body>
    <header>
        <div id="wrap">
            <nav>
                <a href="../PHP/Accueil.php">Accueil</a>
                <a class="active">Calendrier</a>
                <?php
                    if($fonction == 'Responsable'){
                        echo " <a href='../PHP/DashBoard.php'>DashBoard</a>";
                    }
                ?>
                <a href="../PHP/Deconnexion.php"><button class="exit"><i class="fa-solid fa-power-off" style="font-size:20px;"></i></button></a>
            </nav>
        </div>
    </header>
    <?php

    $week = isset($_GET['week']) ? intval($_GET['week']) : intval(date('W'));
    $year = isset($_GET['year']) ? intval($_GET['year']) : intval(date('Y'));
    $weekDates = getWeekDates($week, $year);
    $arrayMonth = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Décembre"];
    $arrayWeek = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
    $premierJourSemaine = date("j", strtotime($weekDates[0]));
    $dernierJourSemaine = date("j", strtotime($weekDates[4]));
    $moisPremiereSemaine = $arrayMonth[date("n", strtotime($weekDates[0]))-1];
    $moisDerniereSemaine = $arrayMonth[date("n", strtotime($weekDates[4]))-1];
    $anneePremiereSemaine = date("Y", strtotime($weekDates[0]));
    $anneeDerniereSemaine = date("Y", strtotime($weekDates[4]));

    ?>
    <h1><center>Calendrier</center></h1>

    <div class="buttons">
        <button class="button" id="Precedent" onclick="afficherSemainePrecedente(<?php echo $week; ?>, <?php echo $year; ?>)">Precedent</button>
        <span>Semaine du <?php echo $premierJourSemaine." ".$moisPremiereSemaine." ".$anneePremiereSemaine; ?> au <?php echo $dernierJourSemaine." ".$moisDerniereSemaine." ".$anneeDerniereSemaine; ?></span>
        <button class="button" id="Suivant" onclick="afficherSemaineSuivante(<?php echo $week; ?>, <?php echo $year; ?>)">Suivant</button>
    </div>
    <?php
    if($fonction == 'Responsable' || $fonction == 'Coordinateur'){ ?>
        <form method="post" id="emploiDeTemps" onsubmit="return false;">
            <section class="modal hidden">
                <div class="flex">
                    <button class="btn-close" onclick="manipModal('close');">⨉</button>
                </div>
                <div>
                    <label>Entrez la date du cour:</label>
                    <input type="date" name="dateDebut"> <br><br>
                    <label>Entrez la date de fin de cour:</label>
                    <input type="date" name="dateFin"> <br><br>
                    <label class="select">Entrez l'heure de début du cours :
                        <select id="debut" required="required" name="heureDebut">
                            <option disabled="disabled" selected="selected">--Choisir--</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                        </select>
                        <select id="debut" required="required" name="minuteDebut">
                            <option disabled="disabled" selected="selected">--Choisir--</option>
                            <option value="00">00</option>
                            <option value="15">15</option>
                            <option value="30">30</option>
                            <option value="45">45</option>
                        </select>
                        <svg>
                            <use xlink:href="#select-arrow-down"></use>
                        </svg>
                    </label><br><br>
                    <!---<input type="time" name="heure_debut" min="08:00" max="18:00" step="900"> <br><br>-->
                    <label class="select">Entrez l'heure de fin du cours :
                        <select id="fin" required="required" name="heureFin">
                            <option disabled="disabled" selected="selected">--Choisir--</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                        </select>
                        <select id="fin" required="required" name="minuteFin">
                            <option disabled="disabled" selected="selected">--Choisir--</option>
                            <option value="00">00</option>
                            <option value="15">15</option>
                            <option value="30">30</option>
                            <option value="45">45</option>
                        </select>
                        <svg>
                            <use xlink:href="#select-arrow-down"></use>
                        </svg>
                    </label>
                    <!---<input type="time" name="heure_fin" min="08:00" max="18:00" step="900"> <br><br>-->
                </div>
                <label class="select" for="slct">Choisir un type de créneau:
                    <select id="slct" required="required" name="typeCours">
                        <option disabled="disabled" selected="selected">--Choisir--</option>
                        <option value="Cours">Cours</option>
                        <option value="TD">TD</option>
                        <option value="TP">TP</option>
                        <option value="Examen">Examen</option>
                        <option value="Soutenance">Soutenance</option>
                        <option value="Amphi de présentation">Amphi de présentation</option>
                    </select>
                    <svg>
                        <use xlink:href="#select-arrow-down"></use>
                    </svg>
                </label><br>
                <label class="select" for="slct">Choisir la matière:
                    <select id="slct" required="required" name="matiere">
                        <option disabled="disabled" selected="selected">--Choisir--</option>
                        <?php
                        if(file_exists('../JSON/cours.json') &&  $cours != null) {
                            foreach($cours as $cour){
                                echo '<option>' . $cour["nom"] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <svg>
                        <use xlink:href="#select-arrow-down"></use>
                    </svg>
                </label><br>

                <div class="checkbox_container">
                    <label> Combien de groupe ? </label> <br>
                    <input id="n1" type="checkbox" name="nb_Groupes" value="n1" onclick="afficherCasesLabels(1)">
                    <label id="nn1" for="n1">1</label>
                    <input id="n2" type="checkbox" name="nb_Groupes" value="n2" onclick="afficherCasesLabels(2)">
                    <label id="nn2" for="n2">2</label>
                    <input id="n3" type="checkbox" name="nb_Groupes" value="n3" onclick="afficherCasesLabels(3)">
                    <label id="nn3" for="n3">3</label>
                </div>

                <div class="select_container">
                    <label class="select2" for="slct2" id="group1" style="display:none;">
                        <select id="slct2_1" required="required" name="quelGroupe1">
                            <option disabled="disabled" selected="selected">Groupe</option>
                            <option>G1</option>
                            <option>G2</option>
                            <option>G3</option>
                        </select>
                        <select id="slct2_3" required="required" name="quelSalle1">
                            <option disabled="disabled" selected="selected">Salle</option>
                            <?php
                            if(file_exists('../JSON/salles.json') &&  $salles != null) {
                                for ($i = 0; $i < count($salles); $i++) {
                                    echo '<option>' . $salles[$i]["nom"] . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <select id="slct" required="required" name="quelEnseignant1">
                            <option disabled="disabled" selected="selected">Coordinateur</option>
                            <?php
                            if(file_exists('../JSON/enseignants.json') &&  $coordinateurs != null) {
                                if($fonction == 'Coordinateur'){
                                    for ($i = 0; $i < count($coordinateurs[$filiere][$niveau]); $i++) {
                                        if($coordinateurs[$filiere][$niveau][$i]["email"] == $email){
                                            echo '<option selected="selected">' . $coordinateurs[$filiere][$niveau][$i]["nom"] . " " . $coordinateurs[$filiere][$niveau][$i]["prenom"] . '</option>';
                                            break;
                                        }
                                    }
                                }
                                else{
                                    for ($i = 0; $i < count($coordinateurs[$filiere][$niveau]); $i++) {
                                        echo '<option>' . $coordinateurs[$filiere][$niveau][$i]["nom"] . " " . $coordinateurs[$filiere][$niveau][$i]["prenom"] . '</option>';
                                    }
                                }
                            }
                            ?>
                        </select>
                        <svg>
                            <use xlink:href="#select-arrow-down"></use>
                        </svg>
                    </label>

                    <label class="select2" for="slct2" id="group2" style="display:none;">
                        <select id="slct2_2" required="required" name="quelGroupe2">
                            <option disabled="disabled" selected="selected">Groupe</option>
                            <option>G1</option>
                            <option>G2</option>
                            <option>G3</option>
                        </select>
                        <select id="slct2_3" required="required" name="quelSalle2">
                            <option disabled="disabled" selected="selected">Salle</option>
                            <?php
                            if($salles != null) {
                                for ($i = 0; $i < count($salles); $i++) {
                                    echo '<option>' . $salles[$i]["nom"] . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <select id="slct" required="required" name="quelEnseignant2">
                            <option disabled="disabled" selected="selected">Coordinateur</option>
                            <?php
                            if(file_exists('../JSON/enseignants.json') &&  $coordinateurs != null) {
                                if($fonction == 'Coordinateur'){
                                    for ($i = 0; $i < count($coordinateurs[$filiere][$niveau]); $i++) {
                                        if($coordinateurs[$filiere][$niveau][$i]["email"] == $email){
                                            echo '<option selected="selected">' . $coordinateurs[$filiere][$niveau][$i]["nom"] . " " . $coordinateurs[$filiere][$niveau][$i]["prenom"] . '</option>';
                                            break;
                                        }
                                    }
                                }
                                else{
                                    for ($i = 0; $i < count($coordinateurs[$filiere][$niveau]); $i++) {
                                        echo '<option>' . $coordinateurs[$filiere][$niveau][$i]["nom"] . " " . $coordinateurs[$filiere][$niveau][$i]["prenom"] . '</option>';
                                    }
                                }
                            }
                            ?>
                        </select>
                        <svg>
                            <use xlink:href="#select-arrow-down"></use>
                        </svg>
                    </label>
                    <label class="select2" for="slct2" id="group3" style="display:none;">
                        <select id="slct2_3" required="required" name="quelGroupe3">
                            <option disabled="disabled" selected="selected">Groupe</option>
                            <option>G1</option>
                            <option>G2</option>
                            <option>G3</option>
                        </select>
                        <select id="slct2_3" required="required" name="quelSalle3">
                            <option disabled="disabled" selected="selected">Salle</option>
                            <?php
                            if(file_exists('../JSON/salles.json') && $salles != null) {
                                for ($i = 0; $i < count($salles); $i++) {
                                    echo '<option>' . $salles[$i]["nom"] . '</option>';
                                }
                            }
                            ?>
                        </select>
                        <select id="slct" required="required" name="quelEnseignant3">
                            <option disabled="disabled" selected="selected">Coordinateur</option>
                            <?php
                            if(file_exists('../JSON/enseignants.json') &&  $coordinateurs != null) {
                                if($fonction == 'Coordinateur'){
                                    for ($i = 0; $i < count($coordinateurs[$filiere][$niveau]); $i++) {
                                        if($coordinateurs[$filiere][$niveau][$i]["email"] == $email){
                                            echo '<option selected="selected">' . $coordinateurs[$filiere][$niveau][$i]["nom"] . " " . $coordinateurs[$filiere][$niveau][$i]["prenom"] . '</option>';
                                            break;
                                        }
                                    }
                                }
                                else{
                                    for ($i = 0; $i < count($coordinateurs[$filiere][$niveau]); $i++) {
                                        echo '<option>' . $coordinateurs[$filiere][$niveau][$i]["nom"] . " " . $coordinateurs[$filiere][$niveau][$i]["prenom"] . '</option>';
                                    }
                                }
                            }
                            ?>
                        </select>
                        <svg>
                            <use xlink:href="#select-arrow-down"></use>
                        </svg>
                    </label>
                </div>
                <?php echo '<div id="arrayWeek" data-array="' . htmlspecialchars(json_encode($weekDates), ENT_QUOTES, 'UTF-8') . '"></div>' ; ?>
                <?php echo '<div id="filiere" filiere="' . htmlspecialchars(json_encode($filiere), ENT_QUOTES, 'UTF-8') . '"></div>' ; ?>
                <?php echo '<div id="niveau" niveau="' . htmlspecialchars(json_encode($niveau), ENT_QUOTES, 'UTF-8') . '"></div>' ; ?>
                <button class="btn" onclick="ajouteCours(); manipModal('close'); return false;">Enregistrer</button>
            </section>
            <input type="hidden" name="no-resubmit" value="1" />
        </form>
        <div class="test">
            <button type="button" class="btn btn-open" onclick="manipModal('open');">Ajouter</button>
        </div>
        <section class="modalSupression hiddenSupp">
            <div class="flexSuppEdt">
                <button class="btn-close closeBtn" onclick="manipModalSupp('close');">⨉</button>
                <form method="post" name="suppEdt" id="suppEdt">
                    <input type="hidden" name="suppEdt" value="suppEdt">
                    <h3>Comment voulez-vous supprimer ce cour ?</h3><br>
                    <div class="checkboxSupp_container">
                        <input id="s1" type="checkbox" name="nSupp" value="s1" onclick="afficherCasesLabels2();cacherCasesLabels2();">
                        <label id="ss1" for="s1">Tous les créneaux de ce cour</label><br>
                        <input id="s2" type="checkbox" name="nSupp" value="s2" onclick="afficherCasesLabels2();cacherCasesLabels2();">
                        <label id="ss2" for="s2">Ce créneau seulement</label><br>
                    </div>
                    <div class="suppEdt">
                        <button class="btn" onclick="manipModalSupp('close');return false;">Retour</button>
                        <button class="btn" onclick="suppCours(); manipModalSupp('vaEtreSupp');return false;">Supprimer</button>
                    </div>
                </form>
            </div>
        </section>
        <section class="modalModify hiddenMod">
            <div class="flexModEdt">
                <button class="btn-close closeBtn" onclick="manipModalMod('close');">⨉</button>
                <form method="post" name="modEdt" id="modEdt">
                    <input type="hidden" name="modEdt" value="modEdt">
                    <h3>Comment voulez-vous modifier ce cour ?</h3><br>
                    <div class="checkboxMod_container">
                        <input id="m1" type="radio" name="nMod" value="m1" onclick="">
                        <label id="mm1" for="m1">Tous les créneaux de ce cour</label><br>
                        <input id="m2" type="radio" name="nMod" value="m2" onclick="">
                        <label id="mm2" for="m2">Ce créneau seulement</label><br>
                    </div>
                    <div class="modEdt">
                        <button class="btn" onclick="manipModalMod('close');return false;">Retour</button>
                        <button class="btn" onclick="manipModalMod('vaEtreMod');return false;">Suivant</button>
                    </div>
                </form>
            </div>
        </section>
        <section  class="modalModify2 hiddenMod2">
            <div class="flexModEdt2">
                <button class="btn-close closeBtn" onclick="manipModalMod('close');">⨉</button>
                <form method="post" name="modEdt2" id="modEdt2">
                    <input type="hidden" name="modEdt2" value="modEdt2">
                    <div class="formModify">
                        <label class="select" for="slct">Choisir un type de créneau:
                            <select id="slct" required="required" name="typeCoursMod">
                                <option disabled="disabled" selected="selected">--Choisir--</option>
                                <option value="Cours">Cours</option>
                                <option value="TD">TD</option>
                                <option value="TP">TP</option>
                                <option value="Examen">Examen</option>
                                <option value="Soutenance">Soutenance</option>
                                <option value="Amphi de présentation">Amphi de présentation</option>
                            </select>
                            <svg>
                                <use xlink:href="#select-arrow-down"></use>
                            </svg>
                        </label><br>
                        <label class="select" for="slct">Choisir la matière:
                            <select id="slct" required="required" name="matiereMod">
                                <option disabled="disabled" selected="selected">--Choisir--</option>
                                <?php
                                if(file_exists('../JSON/cours.json') &&  $cours != null) {
                                    foreach($cours as $cour){
                                        echo '<option>' . $cour["nom"] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                            <svg>
                                <use xlink:href="#select-arrow-down"></use>
                            </svg>
                        </label><br>
                        <label class="select20" for="slct20" id="group1">
                            <select id="slct20_3" required="required" name="quelSalle1Mod">
                                <option disabled="disabled" selected="selected">Salle</option>
                                <?php
                                if(file_exists('../JSON/salles.json') &&  $salles != null) {
                                    for ($i = 0; $i < count($salles); $i++) {
                                        echo '<option>' . $salles[$i]["nom"] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                            <select id="slct" required="required" name="quelEnseignant1Mod">
                                <option disabled="disabled" selected="selected">Coordinateur</option>
                                <?php
                                if(file_exists('../JSON/enseignants.json') &&  $coordinateurs != null) {
                                    for ($i = 0; $i < count($coordinateurs[$filiere][$niveau]); $i++) {
                                        echo '<option>' . $coordinateurs[$filiere][$niveau][$i]["nom"] . " " . $coordinateurs[$filiere][$niveau][$i]["prenom"] . '</option>';
                                    }
                                }
                                ?>
                            </select>

                            <svg>
                                <use xlink:href="#select-arrow-down"></use>
                            </svg>
                        </label>
                    </div>
                    <div class="modEdt2">
                        <button class="btn" onclick="manipModalModifier('retour');return false;">Retour</button>
                        <button class="btn" onclick="manipModalModifier('enregistrer');return false;">Enregistrer</button>
                    </div>
                </form>
            </div>
        </section>
        <div class="overlay hidden"></div>
    <?php } ?>
    <table id="tableEDT">
        <thead>
        <tr>
            <th rowspan="2"></th>
            <?php
            for($i = 0; $i < count($arrayWeek); $i++){
                echo "<th colspan='3'>" . $arrayWeek[$i] . "<br>".date("j", strtotime($weekDates[$i]))."</th>";
            }
            ?>
        </tr>
        <tr>
            <?php
            for($i = 0; $i < count($arrayWeek); $i++){
                echo "<th>G1</th>";
                echo "<th>G2</th>";
                echo "<th>G3</th>";
            }
            ?>
        </tr>
        </thead>

        <tbody>
        <?php
        $infosCours = $edt[$filiere][$niveau];
        $tabl = array_fill(0, 44, array_fill(0, 15,99));
        $tablI = 0;
        $tablJ = 0;
        //Parcours des heures
        for ($h = 8; $h < 19; $h++) {
            for ($m = 0; $m <= 45; $m += 15) {
                echo "<tr><td id='Cln'>";
                $m == 0 ? ($m = '00') : '';
                $hour = $h.':'.$m;
                echo $hour.'</td>';
                for($jourSemaine = 0; $jourSemaine < 5; $jourSemaine++) {
                    $day = $weekDates[$jourSemaine]; // Les jours de la semaine
                    if (isset($edt)) { // Si l'emploie du temps existe
                        $cours_trouve = false;
                        //Parcours des groupes
                        foreach (array('G1', 'G2', 'G3') as $group) {
                            foreach ($infosCours as $cour) { // Parcourir la liste des cours
                                $start_time = strtotime($cour['dateDebut'] . ' ' . $cour['heureDebut']);
                                $end_time = strtotime($cour['dateFin'] . ' ' . $cour['heureFin']);
                                $end_time2 = strtotime($cour['dateDebut'] . ' ' . $cour['heureFin']);
                                $date_cours = get_dates_between(date('d-m-Y', $start_time), date('d-m-Y', $end_time), 7);
                                $bool = false;
                                foreach ($date_cours as $date_cour) { //Parcourir toutes les dates où le cours peut avoir lieu
                                    if ($group == $cour['Groupe'] && $hour == date("G:i", $start_time) && $day == $date_cour) {
                                        foreach($cours as $c){
                                            if($c['nom'] == $cour['matiere']){
                                                $color = $c['color'];
                                                break;
                                            }
                                        }
                                        // Afficher les informations de l'événement dans la cellule correspondante
                                        $duration = ceil(($end_time2 - $start_time) / 60) / 15;
                                        if($fonction == 'Responsable' || $fonction == 'Coordinateur') {
                                            echo "<td rowspan='" . $duration . "' style='background-color:" . $color . "'>" .
                                                $cour['typeDeCours'] . "<br>" .
                                                $cour['matiere'] . "<br>" .
                                                $cour['Coordinateur'] . "<br>" .
                                                $cour['Salle'] . "<br><button class='trash' onclick=\"manipModalMod('open', '" . htmlspecialchars($cour['dateDebut']) . "', '" . htmlspecialchars($cour['heureDebut']) . "', '" . htmlspecialchars($day) . "', '" . htmlspecialchars($cour['dateFin']) . "', '" . htmlspecialchars($group) . "');\">
                                            <i class='fa-solid fa-pen-to-square' style='font-size:24px; color:#E4E4E1;'></i></button><button class='trash' onclick=\"manipModalSupp('open', '" .
                                                htmlspecialchars($cour['dateDebut']) . "', '" . htmlspecialchars($cour['heureDebut']) . "', '" . htmlspecialchars($day) . "', '" . htmlspecialchars($cour['dateFin']) . "', '" . htmlspecialchars($group) . "');\"><i style='font-size:24px; color:red' class='fa'>&#xf014;</i></button></td>";
                                        }
                                        else{
                                            echo "<td rowspan='" . $duration . "' style='background-color:" . $color . "'>" .
                                                $cour['typeDeCours'] . "<br>" .
                                                $cour['matiere'] . "<br>" .
                                                $cour['Coordinateur'] . "<br>" .
                                                $cour['Salle'];
                                        }
                                        $bool_Tmp = true;
                                        for ($i2 = $tablI; $i2 < $tablI + $duration; $i2++) {
                                            if ($bool_Tmp) {
                                                $bool_Tmp = false;
                                                $tabl[$i2][$tablJ] = $duration;
                                            } else {
                                                $tabl[$i2][$tablJ] = 0;
                                            }
                                        }
                                        $cours_trouve = true;
                                        $bool = true;
                                    }
                                }
                                if ($bool) {
                                    break;
                                }
                            }
                            if ($tabl[$tablI][$tablJ] == 99) {
                                if($fonction == 'Responsable'|| $fonction == 'Coordinateur'){
                                    $h < 10 ? ($hh = '0'.$h) : $hh = $h;
                                    $reformattedDate = date('Y-m-d', strtotime($day));
                                    ?>
                                    <td><button onclick="manipModal('open'); rempliForm('<?php echo $reformattedDate; ?>','<?php echo $hh; ?>', '<?php echo $m; ?>', '<?php echo $group; ?>');"> + </button></td>
                                    <?php }
                                else {
                                    echo "<td></td>";
                                }
                            }
                            $tablJ++;
                        }
                    } else { // Si l'emploie du temps n'existe pas
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                    }
                }
                echo '</tr>';
                $tablI++;
                $tablJ = 0;
            }
        }
        ?>

        </tbody>
    </table>
</body>

<?php
    if(isset($_POST['ASupprimer'])){
        $json_data = $_POST['ASupprimer'];
        $data = json_decode($json_data, true);
        // le fichier existe, on peut le lire et vérifier si un cour est déjà présente
        $contenuEDT = file_get_contents('../JSON/emploiDuTemps.json');
        $infosEDT = json_decode($contenuEDT, true); // transforme le contenu en tableau associatif
        for($i = 0; $i < count($infosEDT[$filiere][$niveau]); $i++){
            $info = $infosEDT[$filiere][$niveau][$i];
            if($info["dateDebut"] == $data[0] && $info["heureDebut"] == $data[1] && $info['dateFin'] == $data[3] && $info['Groupe'] == $data[4]){
                $infosEDT[$filiere][$niveau][$i]["AMS"] = 'true';
                $infosEDT[$filiere][$niveau][$i]["dateAMS"] = $data[2];
                break;
            }
        }
        // Convertir le tableau en JSON
        $infosEDT_json = json_encode($infosEDT, JSON_PRETTY_PRINT);

        // Écrire le JSON dans un fichier
        file_put_contents('../JSON/emploiDuTemps.json', $infosEDT_json);
    }
    else if(isset($_POST['AModifier'])){
        $json_data = $_POST['AModifier'];
        $data = json_decode($json_data, true);
        // le fichier existe, on peut le lire et vérifier si un cour est déjà présente
        $contenuEDT = file_get_contents('../JSON/emploiDuTemps.json');
        $infosEDT = json_decode($contenuEDT, true); // transforme le contenu en tableau associatif
        for($i = 0; $i < count($infosEDT[$filiere][$niveau]); $i++){
            $info = $infosEDT[$filiere][$niveau][$i];
            if($info["dateDebut"] == $data[0] && $info["heureDebut"] == $data[1] && $info['dateFin'] == $data[3] && $info['Groupe'] == $data[4]){
                $infosEDT[$filiere][$niveau][$i]["AMS"] = 'true';
                $infosEDT[$filiere][$niveau][$i]["dateAMS"] = $data[2];
                break;
            }
        }
        // Convertir le tableau en JSON
        $infosEDT_json = json_encode($infosEDT, JSON_PRETTY_PRINT);

        // Écrire le JSON dans un fichier
        file_put_contents('../JSON/emploiDuTemps.json', $infosEDT_json);
    }
    else if(isset($_POST['Arafraichir'])){
        // le fichier existe, on peut le lire et vérifier si un cour est déjà présente
        $contenuEDT = file_get_contents('../JSON/emploiDuTemps.json');
        $infosEDT = json_decode($contenuEDT, true); // transforme le contenu en tableau associatif
        for($i = 0; $i < count($infosEDT[$filiere][$niveau]); $i++){
            if($infosEDT[$filiere][$niveau][$i]["AMS"] == 'true'){
                $infosEDT[$filiere][$niveau][$i]["AMS"] = 'false';
                $infosEDT[$filiere][$niveau][$i]["dateAMS"] = '';
            }
        }
        // Convertir le tableau en JSON
        $infosEDT_json = json_encode($infosEDT, JSON_PRETTY_PRINT);

        // Écrire le JSON dans un fichier
        file_put_contents('../JSON/emploiDuTemps.json', $infosEDT_json);
    }
    if(isset($_POST['ajoutEmploiDuTemps'])){
        if(file_exists('../JSON/emploiDuTemps.json')){
            // le fichier existe, on peut le lire et vérifier si un cour est déjà présente
            $contenuEDT = file_get_contents('../JSON/emploiDuTemps.json');
            $infosEDT = json_decode($contenuEDT, true); // transforme le contenu en tableau associatif
            $json_data = $_POST['ajoutEmploiDuTemps'];
            $data = json_decode($json_data, true);
            $dates1 = get_dates_between($data[1], $data[2], 7);
            $courExiste = false;
            foreach ($infosEDT[$filiere][$niveau] as $info) {
                if($data[0] == "n1"){
                    if($info["Groupe"] == $data[8]){
                        $dates2 = get_dates_between($info['dateDebut'], $info['dateFin'], 7);
                        for ($i = 0; $i < count($dates1); $i++){
                            for ($j = 0; $j < count($dates2); $j++){
                                if ($dates1[$i] == $dates2[$j] && creneauInclus($data[3], $data[4], $info['heureDebut'], $info['heureFin'])) { // voir si l'edt contient deja ce cour
                                    $courExiste = true;
                                    break;
                                }
                            }
                        }
                    }
                }
                else if($data[0] == "n2"){
                    if($info["Groupe"] == $data[8] || $info["Groupe"] == $data[12]){
                        $dates2 = get_dates_between($info['dateDebut'], $info['dateFin'], 7);
                        for ($i = 0; $i < count($dates1); $i++){
                            for ($j = 0; $j < count($dates2); $j++){
                                if ($dates1[$i] == $dates2[$j] && creneauInclus($data[3], $data[4], $info['heureDebut'], $info['heureFin'])) { // voir si l'edt contient deja ce cour
                                    $courExiste = true;
                                    break;
                                }
                            }
                        }
                    }
                }
                else if($data[0] == "n3"){
                    if($info["Groupe"] == $data[8] || $info["Groupe"] == $data[11] || $info["Groupe"] == $data[14]){
                        $dates2 = get_dates_between($info['dateDebut'], $info['dateFin'], 7);
                        for ($i = 0; $i < count($dates1); $i++){
                            for ($j = 0; $j < count($dates2); $j++){
                                if ($dates1[$i] == $dates2[$j] && creneauInclus($data[3], $data[4], $info['heureDebut'], $info['heureFin'])) { // voir si l'edt contient deja ce cour
                                    $courExiste = true;
                                    break;
                                }
                            }
                        }
                    }
                }
            }
            if(!$courExiste) {
                // Création de la clé 'filiere' si elle n'existe pas déjà
                if (!isset($infosEDT[$filiere])) {
                    $infosEDT[$filiere] = array();
                }

                // Création de la clé 'niveau' pour la filière si elle n'existe pas déjà
                if (!isset($infosEDT[$filiere][$niveau])) {
                    $infosEDT[$filiere][$niveau] = array();
                }
                if ($data[0] == "n1") {
                    // Ajout des informations de cours dans le tableau associatif correspondant au niveau de la filière
                    $infosEDT[$filiere][$niveau][] = array(
                        'dateDebut' => $data[1],
                        'dateFin' => $data[2],
                        'heureDebut' => $data[3],
                        'heureFin' => $data[4],
                        'typeDeCours' => $data[5],
                        'matiere' => $data[6],
                        'Coordinateur' => $data[7],
                        'Groupe' => $data[8],
                        'Salle' => $data[9],
                        'AMS' => 'false',
                        'dateAMS' => ''
                    );
                } else if ($data[0] == "n2") {
                    $infosEDT[$filiere][$niveau][] = array(
                        'dateDebut' => $data[1],
                        'dateFin' => $data[2],
                        'heureDebut' => $data[3],
                        'heureFin' => $data[4],
                        'typeDeCours' => $data[5],
                        'matiere' => $data[6],
                        'Coordinateur' => $data[7],
                        'Groupe' => $data[8],
                        'Salle' => $data[9],
                        'AMS' => 'false',
                        'dateAMS' => ''
                    );
                    $infosEDT[$filiere][$niveau][] = array(
                        'dateDebut' => $data[1],
                        'dateFin' => $data[2],
                        'heureDebut' => $data[3],
                        'heureFin' => $data[4],
                        'typeDeCours' => $data[5],
                        'matiere' => $data[6],
                        'Coordinateur' => $data[10],
                        'Groupe' => $data[11],
                        'Salle' => $data[12],
                        'AMS' => 'false',
                        'dateAMS' => ''
                    );

                } else if ($data[0] == "n3") {
                    $infosEDT[$filiere][$niveau][] = array(
                        'dateDebut' => $data[1],
                        'dateFin' => $data[2],
                        'heureDebut' => $data[3],
                        'heureFin' => $data[4],
                        'typeDeCours' => $data[5],
                        'matiere' => $data[6],
                        'Coordinateur' => $data[7],
                        'Groupe' => $data[8],
                        'Salle' => $data[9],
                        'AMS' => 'false',
                        'dateAMS' => ''
                    );
                    $infosEDT[$filiere][$niveau][] = array(
                        'dateDebut' => $data[1],
                        'dateFin' => $data[2],
                        'heureDebut' => $data[3],
                        'heureFin' => $data[4],
                        'typeDeCours' => $data[5],
                        'matiere' => $data[6],
                        'Coordinateur' => $data[10],
                        'Groupe' => $data[11],
                        'Salle' => $data[12],
                        'AMS' => 'false',
                        'dateAMS' => ''
                    );
                    $infosEDT[$filiere][$niveau][] = array(
                        'dateDebut' => $data[1],
                        'dateFin' => $data[2],
                        'heureDebut' => $data[3],
                        'heureFin' => $data[4],
                        'typeDeCours' => $data[5],
                        'matiere' => $data[6],
                        'Coordinateur' => $data[13],
                        'Groupe' => $data[14],
                        'Salle' => $data[15],
                        'AMS' => 'false',
                        'dateAMS' => ''
                    );
                }
                // Convertir le tableau en JSON
                $infosEDT_json = json_encode($infosEDT, JSON_PRETTY_PRINT);

                // Écrire le JSON dans un fichier
                file_put_contents('../JSON/emploiDuTemps.json', $infosEDT_json);
            }
            else{
                echo 'ya pas de place';
                echo ' ';
            }
        }
        else{
            // le fichier n'existe pas, il faut le créer et y ajouter les informations
            $json_data = $_POST['ajoutEmploiDuTemps'];
            $data = json_decode($json_data, true);
            // Création du tableau pour stocker les informations classées
            $infosEDT = array();

            // Création de la clé 'filiere' si elle n'existe pas déjà
            if (!isset($infosEDT[$filiere])) {
                $infosEDT[$filiere] = array();
            }

            // Création de la clé 'niveau' pour la filière si elle n'existe pas déjà
            if (!isset($infosEDT[$filiere][$niveau])) {
                $infosEDT[$filiere][$niveau] = array();
            }
            if ($data[0] == "n1") {
                // Ajout des informations de cours dans le tableau associatif correspondant au niveau de la filière
                $infosEDT[$filiere][$niveau][] = array(
                    'dateDebut' => $data[1],
                    'dateFin' => $data[2],
                    'heureDebut' => $data[3],
                    'heureFin' => $data[4],
                    'typeDeCours' => $data[5],
                    'matiere' => $data[6],
                    'Coordinateur' => $data[7],
                    'Groupe' => $data[8],
                    'Salle' => $data[9],
                    'AMS' => 'false',
                    'dateAMS' => ''
                );
            } else if ($data[0] == "n2") {
                $infosEDT[$filiere][$niveau][] = array(
                    'dateDebut' => $data[1],
                    'dateFin' => $data[2],
                    'heureDebut' => $data[3],
                    'heureFin' => $data[4],
                    'typeDeCours' => $data[5],
                    'matiere' => $data[6],
                    'Coordinateur' => $data[7],
                    'Groupe' => $data[8],
                    'Salle' => $data[9],
                    'AMS' => 'false',
                    'dateAMS' => ''
                );
                $infosEDT[$filiere][$niveau][] = array(
                    'dateDebut' => $data[1],
                    'dateFin' => $data[2],
                    'heureDebut' => $data[3],
                    'heureFin' => $data[4],
                    'typeDeCours' => $data[5],
                    'matiere' => $data[6],
                    'Coordinateur' => $data[10],
                    'Groupe' => $data[11],
                    'Salle' => $data[12],
                    'AMS' => 'false',
                    'dateAMS' => ''
                );

            } else if ($data[0] == "n3") {
                $infosEDT[$filiere][$niveau][] = array(
                    'dateDebut' => $data[1],
                    'dateFin' => $data[2],
                    'heureDebut' => $data[3],
                    'heureFin' => $data[4],
                    'typeDeCours' => $data[5],
                    'matiere' => $data[6],
                    'Coordinateur' => $data[7],
                    'Groupe' => $data[8],
                    'Salle' => $data[9],
                    'AMS' => 'false',
                    'dateAMS' => ''
                );
                $infosEDT[$filiere][$niveau][] = array(
                    'dateDebut' => $data[1],
                    'dateFin' => $data[2],
                    'heureDebut' => $data[3],
                    'heureFin' => $data[4],
                    'typeDeCours' => $data[5],
                    'matiere' => $data[6],
                    'Coordinateur' => $data[10],
                    'Groupe' => $data[11],
                    'Salle' => $data[12],
                    'AMS' => 'false',
                    'dateAMS' => ''
                );
                $infosEDT[$filiere][$niveau][] = array(
                    'dateDebut' => $data[1],
                    'dateFin' => $data[2],
                    'heureDebut' => $data[3],
                    'heureFin' => $data[4],
                    'typeDeCours' => $data[5],
                    'matiere' => $data[6],
                    'Coordinateur' => $data[13],
                    'Groupe' => $data[14],
                    'Salle' => $data[15],
                    'AMS' => 'false',
                    'dateAMS' => ''
                );
            }
            // Convertir le tableau en JSON
            $infosEDT_json = json_encode($infosEDT, JSON_PRETTY_PRINT);

            // Écrire le JSON dans un fichier
            file_put_contents('../JSON/emploiDuTemps.json', $infosEDT_json);
            chmod('../JSON/emploiDuTemps.json', 0777);
        }
    }
    if(isset($_POST['supprEdt'])){
        $json_data = $_POST['supprEdt'];
        $data = json_decode($json_data, true);
        // le fichier existe, on peut le lire et vérifier si un cour est déjà présente
        $contenuEDT = file_get_contents('../JSON/emploiDuTemps.json');
        $infosEDT = json_decode($contenuEDT, true); // transforme le contenu en tableau associatif
        for($i = 0; $i < count($infosEDT[$filiere][$niveau]); $i++){
            $info = $infosEDT[$filiere][$niveau][$i];
            if($info["AMS"] == 'true'){
                if($data[0] == 's1'){
                    array_splice($infosEDT[$filiere][$niveau], $i, 1);
                }
                else if($data[0] == 's2'){
                    $dd = get_dates_between2($info["dateDebut"], $info["dateFin"]);
                    if(count($dd) > 1){
                        $jourASupp = date("Y-m-d", strtotime($info["dateAMS"]));
                        if($info["dateDebut"] == $jourASupp){
                            $infosEDT[$filiere][$niveau][] = array(
                                'dateDebut' => $dd[1],
                                'dateFin' => $info["dateFin"],
                                'heureDebut' => $info["heureDebut"],
                                'heureFin' => $info["heureFin"],
                                'typeDeCours' => $info["typeDeCours"],
                                'matiere' => $info['matiere'],
                                'Coordinateur' => $info['Coordinateur'],
                                'Groupe' => $info['Groupe'],
                                'Salle' => $info['Salle'],
                                'AMS' => 'false',
                                'dateAMS' => ''
                            );
                        }
                        else if($info["dateFin"] == $jourASupp){
                            $jourA = jourPrecedent($info["dateFin"]);
                            $infosEDT[$filiere][$niveau][] = array(
                                'dateDebut' => $info["dateDebut"],
                                'dateFin' => $jourA,
                                'heureDebut' => $info["heureDebut"],
                                'heureFin' => $info["heureFin"],
                                'typeDeCours' => $info["typeDeCours"],
                                'matiere' => $info['matiere'],
                                'Coordinateur' => $info['Coordinateur'],
                                'Groupe' => $info['Groupe'],
                                'Salle' => $info['Salle'],
                                'AMS' => 'false',
                                'dateAMS' => ''
                            );
                        }
                        else{
                            $dd2 = get_dates_between2($jourASupp, $info["dateFin"]);
                            $jourA = jourPrecedent($jourASupp);
                            $infosEDT[$filiere][$niveau][] = array(
                                'dateDebut' => $info["dateDebut"],
                                'dateFin' => $jourA,
                                'heureDebut' => $info["heureDebut"],
                                'heureFin' => $info["heureFin"],
                                'typeDeCours' => $info["typeDeCours"],
                                'matiere' => $info['matiere'],
                                'Coordinateur' => $info['Coordinateur'],
                                'Groupe' => $info['Groupe'],
                                'Salle' => $info['Salle'],
                                'AMS' => 'false',
                                'dateAMS' => ''
                            );

                            if(count($dd2) > 1){
                                $infosEDT[$filiere][$niveau][] = array(
                                    'dateDebut' => $dd2[1],
                                    'dateFin' => $info["dateFin"],
                                    'heureDebut' => $info["heureDebut"],
                                    'heureFin' => $info["heureFin"],
                                    'typeDeCours' => $info["typeDeCours"],
                                    'matiere' => $info['matiere'],
                                    'Coordinateur' => $info['Coordinateur'],
                                    'Groupe' => $info['Groupe'],
                                    'Salle' => $info['Salle'],
                                    'AMS' => 'false',
                                    'dateAMS' => ''
                                );
                            }
                        }
                        array_splice($infosEDT[$filiere][$niveau], $i, 1);

                    }
                    else{
                        array_splice($infosEDT[$filiere][$niveau], $i, 1);
                    }
                }
                break;
            }
        }
        // Convertir le tableau en JSON
        $infosEDT_json = json_encode($infosEDT, JSON_PRETTY_PRINT);

        // Écrire le JSON dans un fichier
        file_put_contents('../JSON/emploiDuTemps.json', $infosEDT_json);
    }
    if(isset($_POST['modification'])){
        $json_data = $_POST['modification'];
        $data = json_decode($json_data, true);
        // le fichier existe, on peut le lire et vérifier si un cour est déjà présente
        $contenuEDT = file_get_contents('../JSON/emploiDuTemps.json');
        $infosEDT = json_decode($contenuEDT, true); // transforme le contenu en tableau associatif
        for($i = 0; $i < count($infosEDT[$filiere][$niveau]); $i++) {
            $info = $infosEDT[$filiere][$niveau][$i];
            if ($infosEDT[$filiere][$niveau][$i]["AMS"] == 'true') {
                if ($data[4] == 'm1') {
                    $infosEDT[$filiere][$niveau][$i]["typeDeCours"] = $data[0];
                    $infosEDT[$filiere][$niveau][$i]["matiere"] = $data[1];
                    $infosEDT[$filiere][$niveau][$i]["Salle"] = $data[2];
                    $infosEDT[$filiere][$niveau][$i]["Coordinateur"] = $data[3];
                    $infosEDT[$filiere][$niveau][$i]["AMS"] = 'false';
                    $infosEDT[$filiere][$niveau][$i]["dateAMS"] = '';
                    break;
                }
                else if ($data[4] == 'm2') {
                    $dd = get_dates_between2($info["dateDebut"], $info["dateFin"]);
                    if (count($dd) > 1) {
                        $jourAMod = date("Y-m-d", strtotime($info["dateAMS"]));
                        if ($info["dateDebut"] == $jourAMod) {
                            $infosEDT[$filiere][$niveau][] = array(
                                'dateDebut' => $dd[1],
                                'dateFin' => $info["dateFin"],
                                'heureDebut' => $info["heureDebut"],
                                'heureFin' => $info["heureFin"],
                                'typeDeCours' => $info["typeDeCours"],
                                'matiere' => $info['matiere'],
                                'Coordinateur' => $info['Coordinateur'],
                                'Groupe' => $info['Groupe'],
                                'Salle' => $info['Salle'],
                                'AMS' => 'false',
                                'dateAMS' => ''
                            );
                            $infosEDT[$filiere][$niveau][$i]["dateFin"] = $jourAMod;
                        }
                        else if ($info["dateFin"] == $jourAMod) {
                            $jourA = jourPrecedent($info["dateFin"]);
                            $infosEDT[$filiere][$niveau][] = array(
                                'dateDebut' => $info["dateDebut"],
                                'dateFin' => $jourA,
                                'heureDebut' => $info["heureDebut"],
                                'heureFin' => $info["heureFin"],
                                'typeDeCours' => $info["typeDeCours"],
                                'matiere' => $info['matiere'],
                                'Coordinateur' => $info['Coordinateur'],
                                'Groupe' => $info['Groupe'],
                                'Salle' => $info['Salle'],
                                'AMS' => 'false',
                                'dateAMS' => ''
                            );
                            $infosEDT[$filiere][$niveau][$i]["dateDebut"] = $jourAMod;
                        }
                        else {
                            $dd2 = get_dates_between2($jourAMod, $info["dateFin"]);
                            $jourA = jourPrecedent($jourAMod);
                            $infosEDT[$filiere][$niveau][] = array(
                                'dateDebut' => $info["dateDebut"],
                                'dateFin' => $jourA,
                                'heureDebut' => $info["heureDebut"],
                                'heureFin' => $info["heureFin"],
                                'typeDeCours' => $info["typeDeCours"],
                                'matiere' => $info['matiere'],
                                'Coordinateur' => $info['Coordinateur'],
                                'Groupe' => $info['Groupe'],
                                'Salle' => $info['Salle'],
                                'AMS' => 'false',
                                'dateAMS' => ''
                            );
                            if (count($dd2) > 1) {
                                $infosEDT[$filiere][$niveau][] = array(
                                    'dateDebut' => $dd2[1],
                                    'dateFin' => $info["dateFin"],
                                    'heureDebut' => $info["heureDebut"],
                                    'heureFin' => $info["heureFin"],
                                    'typeDeCours' => $info["typeDeCours"],
                                    'matiere' => $info['matiere'],
                                    'Coordinateur' => $info['Coordinateur'],
                                    'Groupe' => $info['Groupe'],
                                    'Salle' => $info['Salle'],
                                    'AMS' => 'false',
                                    'dateAMS' => ''
                                );
                            }
                            $infosEDT[$filiere][$niveau][$i]["dateDebut"] = $jourAMod;
                            $infosEDT[$filiere][$niveau][$i]["dateFin"] = $jourAMod;
                        }
                    }
                    $infosEDT[$filiere][$niveau][$i]["typeDeCours"] = $data[0];
                    $infosEDT[$filiere][$niveau][$i]["matiere"] = $data[1];
                    $infosEDT[$filiere][$niveau][$i]["Salle"] = $data[2];
                    $infosEDT[$filiere][$niveau][$i]["Coordinateur"] = $data[3];
                    $infosEDT[$filiere][$niveau][$i]["AMS"] = 'false';
                    $infosEDT[$filiere][$niveau][$i]["dateAMS"] = '';
                    break;
                }
            }
        }
        // Convertir le tableau en JSON
        $infosEDT_json = json_encode($infosEDT, JSON_PRETTY_PRINT);

        // Écrire le JSON dans un fichier
        file_put_contents('../JSON/emploiDuTemps.json', $infosEDT_json);
    }



?>
</html>
