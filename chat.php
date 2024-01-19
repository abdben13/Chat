<?php 
    //demarrage de la session
    session_start();
    if(!isset($_SESSION['user'])) {
        //si l'utilisateur n'est pas connecté, redirection vers la page d'acceuil
        header("Location:index.php");
    }
    $user = $_SESSION['user'] //email de l'utilisateur
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?=$user?> | Chat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="chat">
        <div class="button-email">
            <span><?=$user?></span>
            <a href="deconnexion.php" class="Deconnexion_btn">Déconnexion</a>
        </div><!--button-email-->
        <!--messages-->
        <div class="messages_box">Chargement ...</div><!--message_box-->
        <!--Fin messages-->
        <?php 
            //envoi des messages
            if(isset($_POST['send'])) {
                //recuperons le message 
                $message = $_POST['message'] ;
                //connexion à la bdd
                include("connexion_bdd.php");
                //verifions si le champs n'est pas vide
                if(isset($message) && $message != "") {
                    //inserer le message dans la bdd
                    $req = mysqli_query($con, "INSERT INTO messages VALUES (NULL,'$user', '$message',NOW())");
                    //actualisation de la page 
                    header('Location:chat.php');
                }else {
                    //si le message est vide on actualise la page 
                    header('Location:chat.php');
                }

            }
        ?>
        <form action="" class="send_message" method="POST">
            <textarea name="message" cols="30" rows="2" placeholder="Votre message"></textarea>
            <input type="submit" value="Envoyer" name="send">
        </form>
    </div><!--chat--> >

    <script> 
        //actualisation de la page en utilisant AJAX
        var message_box = document.querySelector('.messages_box');
        setInterval(function(){
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    message_box.innerHTML = this.responseText
                }
            };
            xhttp.open("GET","messages.php", true); //recuperation de la page message
            xhttp.send()
        },500) //actualisation du chat toutes les 500 ms
    </script>
</body>
</html>