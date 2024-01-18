<?php 
//Connexion à la bdd
$con = mysqli_connect("localhost","root","","chat");
//gérer les accents et autres caractères francais 
$req = mysqli_query($con, "SET NAMES 'utf8'");
if(!$con){
    //si la connexion échoue, afficher :
    echo "Connexion échouée";
}



?>