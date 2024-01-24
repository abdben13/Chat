<?php 
    //démarrage de la session
    session_start();

    include "header.html";
    if(isset($_POST['button_con'])){
        //si le formulaire est envoyé
        //se connecter à la bdd
        include "connexion_bdd.php";
        //extraire les infos du formulaire
        extract($_POST);
        //verification si les champs sont vides 
        if (isset($email) && isset($mdp1) && $email != "" && $mdp1 != "") {
            // création de la requête préparée
            $stmt = mysqli_prepare($con, "SELECT email, mdp, pseudo FROM utilisateurs WHERE email = ?");
            
            // vérification de la préparation de la requête
            if ($stmt) {
                // liaison du paramètre à la requête préparée
                mysqli_stmt_bind_param($stmt, "s", $email);
    
                // exécution de la requête préparée
                mysqli_stmt_execute($stmt);
    
                // récupération du résultat
                mysqli_stmt_store_result($stmt);
    
                // liaison des résultats aux variables
                mysqli_stmt_bind_result($stmt, $result_email, $result_mdp, $result_pseudo);
    
                // vérification si la requête a retourné une ligne
                if (mysqli_stmt_fetch($stmt)) {
                    // les identifiants sont corrects
                    if (password_verify($mdp1, $result_mdp)) {
                        // mémoriser l'utilisateur avec un cookie
                        if (isset($_POST['rememberMe']) && $_POST['rememberMe'] == 'on') {
                            $cookie_name = 'remember_user';
                            $cookie_value = base64_encode($email); // Vous pouvez également stocker d'autres informations
                            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // Cookie valable pendant 30 jours
                        }
    
                        $_SESSION['user'] = $email;
                        $_SESSION['pseudo'] = $result_pseudo;
                        $req_update = mysqli_query($con, "UPDATE utilisateurs SET en_ligne = 1 WHERE email = '$email'");
                        header("location:chat.php");
                        unset($_SESSION['message']);
                    } else {
                        // le mot de passe est incorrect
                        $error = "Email ou mot de passe incorrect(s) !";
                    }
                } else {
                    // l'email n'a pas été trouvé
                    $error = "Email non trouvé !";
                }
    
                // fermeture de la requête préparée
                mysqli_stmt_close($stmt);
            } else {
                // erreur lors de la préparation de la requête
                $error = "Erreur lors de la préparation de la requête !";
            }
        } else {
            // si les champs sont vides
            $error = "Veuillez remplir tous les champs !";
        }
    
        // fermeture de la connexion à la base de données
        mysqli_close($con);
    }
    ?>

    <div class="title">
        <h1>Dans ma bulle</h1>
        <img src="img/bulle.png" alt="bulle" class="img">
    </div>
    <div class="presentation">
        <p>Un espace dédié à l'autisme. Nous sommes ici pour partager, informer et soutenir. Explorez nos ressources, échangez des expériences et découvrez une communauté bienveillante prête à accompagner chacun dans son parcours unique. Ensemble, nous cultivons la compréhension et la sensibilisation à l'autisme.</p>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="" method="POST" class="bg-light p-4 rounded">
                    
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

