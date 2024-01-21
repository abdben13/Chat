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
                        $hashed_password = password_hash($mdp1, PASSWORD_DEFAULT);
                        $req = mysqli_query($con, "INSERT INTO utilisateurs VALUES (NULL, '$email', '$hashed_password', '$pseudo') ");

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
   <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="" method="POST" class="bg-light p-4 rounded">
                <h1 class="text-center mb-4">INSCRIPTION</h1>
                <p class="text-danger mb-4">
                    <?php 
                        //affichage de l'erreur
                        if(isset($error)){
                            echo $error;
                        }
                    ?>
                </p>
                <div class="mb-3">
                    <label for="inputEmail" class="form-label">Adresse Mail</label>
                    <input type="email" class="form-control" id="inputEmail" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="inputPseudo" class="form-label">Pseudo</label>
                    <input type="text" class="form-control" id="inputPseudo" name="pseudo" required>
                </div>
                <div class="mb-3">
                    <label for="inputPassword" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control mdp1" id="inputPassword" name="mdp1" required>
                </div>
                <div class="mb-3">
                    <label for="inputConfirmPassword" class="form-label">Confirmation du mot de passe</label>
                    <input type="password" class="form-control mdp2" id="inputConfirmPassword" name="mdp2" required>
                </div>
                <button type="submit" class="btn btn-primary w-100" name="button_inscription">Inscription</button>
                <p class="text-center mt-3">Vous avez un compte? <a href="index.php" class="link">Se connecter</a></p>
            </form>
        </div>
    </div>
</div>


    <script src="script.js"></script>
</body>

</html>