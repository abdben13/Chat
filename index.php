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
                 // Mémoriser l'utilisateur avec un cookie
            if(isset($_POST['rememberMe']) && $_POST['rememberMe'] == 'on') {
                $cookie_name = 'remember_user';
                $cookie_value = base64_encode($email); 
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // Cookie valable pendant 30 jours
            }
                $_SESSION['user'] = $email;
                header("location:chat.php");
                unset($_SESSION['message']);
            } else {
                // Les identifiants sont incorrects
                $error = "Email ou mot de passe incorrect(s) !";
            }
        } else {
            //si les champs sont vides 
            $error = "Veuillez remplir tous les champs !";
        }
    }
    ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="" method="POST" class="bg-light p-4 rounded">
                    <h1 class="text-center mb-4">CONNEXION</h1>
                    <?php 
                        //affichage du message de succes
                        if(isset($_SESSION['message'])) {
                            echo $_SESSION['message'];
                        }
                    ?>
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
                        <label for="inputPassword" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="inputPassword" name="mdp1" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Se souvenir de moi</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="button_con">Connexion</button>
                    <p class="text-center mt-3">Vous n'avez pas de compte? <a href="inscription.php" class="link">Créer un compte</a></p>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
