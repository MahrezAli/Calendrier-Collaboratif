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

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Accueil</title>
        <link rel="stylesheet" href="../CSS/Accueil.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <header>
            <div id="wrap">
                <nav>
                    <a class='active'>Accueil</a>
                    <a href="../PHP/CalendrierPrincipal.php">Calendrier</a>
                    <?php
                    if($fonction == 'Responsable'){
                        echo " <a href='../PHP/DashBoard.php'>DashBoard</a>";
                    }
                    ?>
                    <a href="../PHP/Deconnexion.php"><button class="exit"><i class="fa-solid fa-power-off" style="font-size:20px;"></i></button></a>
                </nav>
            </div>
        </header>
        <div class="pl">
            <div class="pl__outer-ring"></div>
            <div class="pl__inner-ring"></div>
            <div class="pl__track-cover"></div>
            <div class="pl__ball">
                <div class="pl__ball-texture"></div>
                <div class="pl__ball-outer-shadow"></div>
                <div class="pl__ball-inner-shadow"></div>
                <div class="pl__ball-side-shadows"></div>
            </div>
        </div>
        <h1>Bienvenue M <?php echo $nom_utilisateur; ?></h1>
        <?php
            if($fonction == 'Etudiant'){
                echo "Vous êtes ".$fonction." en ".$niveau." en filière ".$filiere;
            }
            else if($fonction == 'Responsable' || $fonction == 'Coordinateur'){
                echo "Vous êtes ".$fonction." pour les ".$niveau." en filière ".$filiere;
            }
        ?>
        <p>C'est votre page d'accueil personnalisée.</p>
    </body>
</html>