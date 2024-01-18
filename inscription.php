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
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php 
        if(isset($_POST['button_inscription'])){
            //si le formulaire est envoyé
            //se connecter à la bdd
            include "connexion_bdd.php";
            //extraire les infos du formulaire
            extract($_POST);
            if(isset($email) && isset($mdp1) && $email != "" && $mdp1 != "" && isset($mdp2) && $mdp2 != ""){
                //verification que les mots de passes sont conformes
                if($mdp2 != $mdp1){
                    // si ils sont differents
                    $error = "Les mots de passe ne sont pas identiques !";
                }else {
                    //sinon verification si l'email est existant
                    $req = mysqli_query($con , "SELECT * FROM utilisateurs Where email = '$email'");
                    if(mysqli_num_rows($req) == 0){
                        //si l'email n'existe pas création d'un compte
                        $req = mysqli_query($con, "INSERT INTO utilisateurs VALUES (NULL, '$email', '$mdp1') ");
                        if($req){
                            //si le compte a été créer, création d'une variable pour afficher un message de succes
                            $_SESSION['message'] = "<p class='message_success'>Votre compte a été créer avec succès !</p>" ;
                            //redirection vers la page de connexion
                            header("Location:index.php");
                        }else {
                            //sinon
                            $error = "Inscription échouée !";
                        }
                    }else {
                        // si l'email existe
                        $error = "Cet email est déjà utilisé !";
                    }

                }
            }else {
                $error = "Veuillez remplir tous les champs !";
            }
        }
    ?>
    <form action="" method="POST" class="form_connexion_inscription" >
        <h1>INSCRIPTION</h1>
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
        <input type="password" name="mdp1" class="mdp1">
        <label>Confirmation du mot de passe</label>
        <input type="password" name="mdp2" class="mdp2">
        <input type="submit" value="Inscription" name="button_inscription">
        <p class="link">Vous avez un compte?<a href="index.php"> Se connecter</a></p>
    </form>

    <script src="script.js"></script>
</body>

</html>