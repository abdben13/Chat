<?php 
    //demarrage de la session
    session_start();
    if(!isset($_SESSION['user'])) {
        //si l'utilisateur n'est pas connecté, redirection vers la page d'acceuil
        header("Location:index.php");
    }
    //destruction de la session
    session_destroy();
    // redirection vers la pade de connexion
    header("Location:index.php");
?>