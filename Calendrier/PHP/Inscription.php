<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="../CSS/Inscription.css">
    <script src="../JS/Inscription.js"></script>
</head>
<body>
<div class="container">
    <div class="connexion_container">
        <h1>Bonjour, l'ami !</h1>
        <p>Pour rester connecter avec nous, inscrivez vous avec vos informations personnelles</p>
        <button type="submit" onclick="window.location.href='Connexion.php';">Se connecter</button> <br>
    </div>
    <div class="inscription_container">
        <h1>Inscription</h1>
        <form id="formm" method="post" name="myForm">
            <input type="text" placeholder="Nom" name="nom" required> <br>
            <input type="text" placeholder="Prénom" name="prenom" required> <br>
            <input type="text" placeholder="Email" name="email" required> <br>
            <input type="password" placeholder="Mot de passe" name="mdp" required> <br>
            <div class="checkbox_container">
                <input id="c1" type="checkbox" name="fonction" value="Etudiant" onchange="afficherCasesACocher(); cacherCasesACocher();">
                <label id = "cc1" for="c1">Étudiant</label>
            </div>
            <div class="checkbox_container">
                <input id="c2" type="checkbox" name="fonction" value="Responsable" onchange="afficherCasesACocher(); cacherCasesACocher();">
                <label id = "cc2" for="c2">Responsable</label>
            </div>
            <div class="checkbox_container">
                <input id="c3" type="checkbox" name="fonction" value="Coordinateur" onchange="afficherCasesACocher(); cacherCasesACocher();">
                <label id = "cc3" for="c3">Coordinateur</label>
            </div>

            <div class="checkbox_container_2">
                <input id="l1" type="checkbox" name="niveau" value="L1" onchange="cacherCasesACocher2(); afficherCasesACocher2();">
                <label id = "ll1" for="l1" >L1</label>
            </div>
            <div class="checkbox_container_2">
                <input id="l2" type="checkbox" name="niveau" value="L2" onchange="cacherCasesACocher2(); afficherCasesACocher2();">
                <label id = "ll2" for="l2">L2</label>
            </div>
            <div class="checkbox_container_2">
                <input id="l3" type="checkbox" name="niveau" value="L3" onchange="cacherCasesACocher2(); afficherCasesACocher2();">
                <label id = "ll3" for="l3">L3</label>
            </div>

            <div class="checkbox_container_3">
                <input id="f1" type="checkbox" name="filiere" value="Informatique" onchange="cacherCasesACocher3(); afficherCasesACocher3();">
                <label id = "ff1" for="f1" >Informatique</label>
            </div>
            <div class="checkbox_container_3">
                <input id="f2" type="checkbox" name="filiere" value="Biologie" onchange="cacherCasesACocher3(); afficherCasesACocher3();">
                <label id = "ff2" for="f2">Biologie</label>
            </div>
            <div class="checkbox_container_3">
                <input id="f3" type="checkbox" name="filiere" value="Math" onchange="cacherCasesACocher3(); afficherCasesACocher3();">
                <label id = "ff3" for="f3">Math</label>
            </div>

            <div class="checkbox_container_3">
                <input id="f4" type="checkbox" name="filiere" value="Physique" onchange="cacherCasesACocher3(); afficherCasesACocher3();">
                <label id = "ff3" for="f4">Physique</label>
            </div>
            <button type="button" onclick="validateAndSubmit();">s'inscrire</button>
        </form>
    </div>
</div>
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (file_exists('../JSON/comptes.json')) {
        // le fichier existe, on peut le lire et vérifier si une adresse mail est déjà présente
        $contenu = file_get_contents('../JSON/comptes.json');
        $infos = json_decode($contenu, true); // transforme le contenu en tableau associatif

        $email_existe_deja = false;
        foreach ($infos as $info) {
            if ($info['email'] == $_POST['email']) {
                $email_existe_deja = true;
                break;
            }
        }
        if ($email_existe_deja) {
            echo "<script>alert('Cette adresse email est déjà utilisée.');</script>";
        } else {
            $nouvelles_infos = array(
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'email' => $_POST['email'],
                'mot_de_passe' => $_POST['mdp'],
                'fonction' => $_POST['fonction'],
                'niveau' => $_POST['niveau'],
                'filiere' => $_POST['filiere'],
            );
            $infos[] = $nouvelles_infos;
            // Convertir le tableau en JSON
            $infos_json = json_encode($infos, JSON_PRETTY_PRINT);

            // Écrire le JSON dans un fichier
            file_put_contents('../JSON/comptes.json', $infos_json);
        }
    } else {
        // le fichier n'existe pas, il faut le créer et y ajouter les informations
        $infos[] = array(
            'nom' => $_POST['nom'],
            'prenom' => $_POST['prenom'],
            'email' => $_POST['email'],
            'mot_de_passe' => $_POST['mdp'],
            'fonction' => $_POST['fonction'],
            'niveau' => $_POST['niveau'],
            'filiere' => $_POST['filiere'],
        );
        // Convertir le tableau en JSON
        $infos_json = json_encode($infos, JSON_PRETTY_PRINT);

        // Écrire le JSON dans un fichier
        file_put_contents('../JSON/comptes.json', $infos_json);
        chmod('../JSON/comptes.json', 0777);
        // Rediriger l'utilisateur vers une autre page
        //header('Location: confirmation.php');
        //exit();
    }
}
?>
</body>
</html>

