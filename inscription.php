<?php
// Démarrage de la session
session_start();

    include "header.html";
    if(isset($_POST['button_inscription'])){
    // Si le formulaire est envoyé
    // Se connecter à la BDD
    include "connexion_bdd.php";
    
    // Extraire les infos du formulaire
    extract($_POST);
    
    if(isset($email) && isset($mdp1) && $email != "" && $mdp1 != "" && isset($mdp2) && $mdp2 != ""){
        // Vérification que les mots de passe sont conformes
        if($mdp2 != $mdp1){
            // Si ils sont différents
            $error = "Les mots de passe ne sont pas identiques !";
        } else {
            // Sinon, vérification si l'email est existant
            $stmt = mysqli_prepare($con, "SELECT * FROM utilisateurs WHERE email = ?");
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            
            if(mysqli_stmt_num_rows($stmt) == 0){
                // Si l'email n'existe pas, création d'un compte
                $hashed_password = password_hash($mdp1, PASSWORD_DEFAULT);
                $stmt = mysqli_prepare($con, "INSERT INTO utilisateurs VALUES (NULL, ?, ?, ?)");
                mysqli_stmt_bind_param($stmt, "sss", $email, $hashed_password, $pseudo);
                mysqli_stmt_execute($stmt);

                if(mysqli_stmt_affected_rows($stmt) > 0){
                    // Si le compte a été créé avec succès
                    $_SESSION['message'] = "<p class='message_success'>Votre compte a été créé avec succès !</p>" ;
                    // Redirection vers la page de connexion
                    header("Location:index.php");
                } else {
                    // Sinon
                    $error = "Inscription échouée !";
                }
            } else {
                // Si l'email existe
                $error = "Cet email est déjà utilisé !";
            }
        }
    } else {
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
                <p class="text-center mt-3">Vous avez un compte? <a href="forum.php" class="link">Se connecter</a></p>
            </form>
        </div>
    </div>
</div>


    <script src="script.js"></script>
</body>

</html>