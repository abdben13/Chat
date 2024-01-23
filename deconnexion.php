<?php 
    //demarrage de la session
    session_start();
    
    // inclure la connexion à la base de données
    include "connexion_bdd.php";

    if(!isset($_SESSION['user'])) {
        //si l'utilisateur n'est pas connecté, redirection vers la page d'acceuil
        header("Location:index.php");
    }

    // Récupérer l'email de l'utilisateur depuis la session
    $email = $_SESSION['user'];

    // Mettre à jour la base de données pour indiquer que l'utilisateur n'est plus en ligne
    $req_update = mysqli_query($con, "UPDATE utilisateurs SET en_ligne = 0 WHERE email = '$email'");

    // Destruction de la session
    session_destroy();

    // Redirection vers la page de connexion
    header("Location:index.php");
?>