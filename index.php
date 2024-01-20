<?php 
    //démarrage de la session
    session_start();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    
    <?php 
    include "header.html";
    if(isset($_POST['button_con'])){
        //si le formulaire est envoyé
        //se connecter à la bdd
        include "connexion_bdd.php";
        //extraire les infos du formulaire
        extract($_POST);
        //verification si les champs sont vides 
        if(isset($email) && isset($mdp1) && $email != "" && $mdp1 != ""){
            //verification si les identifiants sont justes
            $user = mysqli_fetch_assoc(mysqli_query($con , "SELECT * FROM utilisateurs WHERE email = '$email'"));
            if ($user && password_verify($mdp1, $user['mdp'])) {
                // Les identifiants sont corrects
                $_SESSION['user'] = $email;
                header("location:chat.php");
                unset($_SESSION['message']);
            } else {
                // Les identifiants sont incorrects
                $error = "Email ou mot de passe incorrect(s) !";
            }
        }else {
            //si les champs sont vides 
            $error = "Veuillez remplir tous les champs !";
        }
    }
    ?>
    <div class="form">
        <form action="" method="POST" class="form_connexion_inscription" >
            <h1>CONNEXION</h1>
            <?php 
                //affichage du message de succes
                if(isset($_SESSION['message'])) {
                    echo $_SESSION['message'];
                }
            ?>
            <p class="message_error">
                <?php 
                    //affichage de l'erreur
                    if(isset($error)){
                        echo $error;
                    }
                ?>
            </p>
            <label>Adresse Mail</label>
            <input type="email" name="email">
            <label>Mot de passe</label>
            <input type="password" name="mdp1">
            <input type="submit" value="Connexion" name="button_con">
            <p class="link">Vous n'avez pas de compte?<a href="inscription.php"> Créer un compte</a></p>
        </form>
    </div><!--form-->

</body>

</html>