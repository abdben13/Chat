<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>adel7517@hotmail.fr | Chat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="chat">
        <div class="button-email">
            <span>adel7517@hotmail.fr</span>
            <a href="#" class="Deconnexion_btn">Déconnexion</a>
        </div><!--button-email-->
        <!--messages-->
        <div class="messages_box">
            <div class="message your_message">
                <span>Vous</span>
                <p>Comment ca va?</p>
                <p class="date">17-01-04 20:31:00</p>
            </div><!--message your_message-->
            <div class="message others_message">
                <span>azerty@gmail.com</span>
                <p>Oui ca va</p>
                <p class="date">17-01-04 20:32:00</p>
            </div><!--message others_message-->
        </div><!--message_box-->
        <!--Fin messages-->
        <form action="" class="send_message" method="POST">
            <textarea name="message" cols="30" rows="2" placeholder="Votre message"></textarea>
            <input type="submit" value="Envoyer" name="Send">
        </form>
    </div><!--chat--> >
</body>
</html>