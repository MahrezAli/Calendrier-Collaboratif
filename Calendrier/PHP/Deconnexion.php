<?php
    session_start();

    // Détruire toutes les variables de session.
    session_unset();

    // Régénérer un nouvel identifiant de session.
    session_regenerate_id(true);

    // Détruire la session.
    session_destroy();

    // Rediriger vers la page de déconnexion.
    header("Location: ../PHP/Connexion.php");
    exit();
?>