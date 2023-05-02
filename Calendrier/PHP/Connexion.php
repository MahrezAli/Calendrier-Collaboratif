<?php
session_start();
function verificationConnexion(){
    if (file_exists('../JSON/comptes.json')) {
        // le fichier existe, on peut le lire et vérifier si une adresse mail est déjà présente
        $contenu = file_get_contents('../JSON/comptes.json');
        $infos = json_decode($contenu, true); // transforme le contenu en tableau associatif

        $compte_existe = false;
        foreach ($infos as $info) {
            if ($info['email'] == $_POST['email'] && $info['mot_de_passe'] == $_POST['mdp']) {
                $compte_existe = true;
                $_SESSION['email'] = $_POST['email'];
                break;
            }
        }
        if ($compte_existe) {
            header('Location: Accueil.php');
            exit();
            //echo "<script>alert('Connexion réussie');</script>";
        } else {
            echo "<script>alert('Email ou mot de passe incorrect');</script>";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="../CSS/Connexion.css">
</head>
<body>
<div class="container">
    <div class="connexion_container">
        <h1>Connexion</h1>
        <form method="post">
            <input type="text" placeholder="Email" name="email" required> <br>
            <input type="password" placeholder="Mot de passe" name="mdp" required> <br>
            <p><a href="Connexion.html">Mot de passe oublié ?</a></p> <br>
            <button type="submit" name="submit">Se connecter</button> <br>
        </form>
    </div>
    <div class="inscription_container">
        <h1>Bonjour, l'ami !</h1>
        <p>Entre tes coordonnées et rejoins l'équipe</p>
        <button type="submit" onclick="window.location.href='Inscription.php';">Inscription</button> <br>
    </div>
</div>
</body>
<?php
if(isset($_POST["submit"])){
    verificationConnexion();
}
?>
</html>