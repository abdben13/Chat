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
    if(isset($_POST['button_con'])){
        //si le formulaire est envoyé
        //se connecter à la bdd
        include "connexion_bdd.php";
        //extraire les infos du formulaire
        extract($_POST);
        //verification si les champs sont vides 
        if(isset($email) && isset($mdp1) && $email != "" && $mdp1 != ""){
            //verification si les identifiants sont justes
            $req = mysqli_query($con , "SELECT * FROM utilisateurs WHERE email = '$email' AND mdp = '$mdp1'");
            if(mysqli_num_rows($req) > 0){
                //si les ids sont justes
                //création d'une session qui contient l'email
                $_SESSION['user'] = $email;
                //redirection vers la page chat
                header("location:chat.php");
                //destruction de la variable contenant le message d'inscription
                unset($_SESSION['message']);
            }else {
                //sinon 
                $error = "Email ou mot de passe incorrecte(s) !";
            }
        }else {
            //si les champs sont vides 
            $error = "Veuillez remplir tous les champs !";
        }
    }
    ?>
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


</body>

</html>