//Confirmation du mot de passe
//Verification si mdp et confirmation mdp sont identiques
var mdp1 = document.querySelector('.mdp1');
var mdp2 = document.querySelector('.mdp2');
mdp2.onkeyup = function(){
    //événement lorsqu'on écrit dans le champs : confirmation du mot de passe
    message_error = document.querySelector('.message_error');
    if(mdp1.value != mdp2.value){ //si ils ne sont pas égaux
        //on affiche un message d'erreur 
        message_error.innerText = "Les mots de passe ne sont pas conformes";
    }else {
        message_error.innerText = ""
    }
}