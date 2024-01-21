

<?php 
    session_start();
    if(isset($_SESSION['user'])) {
        //si l'utilisateur est connecté
        include "connexion_bdd.php";
        //requete pour afficher les messages
        $req = mysqli_query($con, "SELECT * FROM messages ORDER BY id_m DESC");
        if(mysqli_num_rows($req) == 0){
            echo "Messagerie vide !";
        }else {
            //si oui
            while($row = mysqli_fetch_assoc($req)) {
                //si c'est vous qui avez envoyé le message on utilise ce format : 
                if($row['email'] == $_SESSION['user']){
                    ?>
                        <div class="message your_message">
                            <span>Vous</span>
                            <p><?=$row['msg']?></p>
                            <p class="date"><?=$row['date']?></p>
                        </div><!--message your_message-->
                    <?php
                }else {
                    //si vous n'etes pas l'auteur du message, on affiche le message sous ce format :
                        ?>
                            <div class="message others_message">
                                <span><?=$row['email']?></span>
                                <p><?=$row['msg']?></p>
                                <p class="date"><?=$row['date']?></p>
                            </div><!--message others_message-->  
                        <?php      
                }
            }
        }
    }
?>
        