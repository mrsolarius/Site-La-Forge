<?php
 $location = basename(__FILE__);
 include ('./settings.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="css/form.css" rel="stylesheet" type="text/css"/>
        <?php include ('./template/head.php');?>
        
    </head>
    <body>
        <?php include ('./template/navbar.php');?>

        <div class="page">
            <form id="registrationform" action="registerprocesse.php" method="post" onsubmit="return formverify();">
              <div class="container">
                <h1>Créer un compte</h1>
                <p>Merci de remplir ce formulaire pour crée un compte</p>
                <hr>
                <div>
                    <div id="ConteurPrenom">
                        <label for="prenom"><b>Prénom</b></label>
                        <input type="text" placeholder="Entrer votre prenom" name="prenom" required>
                    </div>
                    
                    <div id="ConteurNom">
                        <label for="noms"><b>Nom</b></label>
                        <input type="text" placeholder="Entrer votre noms" name="noms" required>
                    </div> 
                </div>
                <label for="email"><b>Email</b></label>
                <input type="email" placeholder="Entrer un Email" name="email" required>
                
                <div style="position: relative;">
                    <label for="psw"><b>Mot de passe</b></label>
                    <input id="psw" type="password" placeholder="Enter un mot de passe" name="psw" required>
                    <span id="passtip"></span>
                </div>

                <label for="psw-repeat"><b>Confirmation du mot de passe</b></label>
                <input id="psw-repeat" type="password" placeholder="reecrire le mot de passe" name="psw-repeat" required>
                <span id="pswerr"></span>
                <hr>

                <p>En créant ce compte vous acceptez en conséquent notre<a href="./legal/politique-de-confidentialite.php">Politique de confidentilité</a>.</p>
                <button type="submit" class="registerbtn">Crée votre compte</button>
              </div>

              <div class="container signin">
                <p>vous avez dejà un compte ? <a href="signin.php">Se connecter</a>.</p>
              </div>
        </form>
        </div>
        <br>
        <?php include ('./template/footer.php');?>
        <script src="js/registerVerif.js" type="text/javascript"></script>
    </body>
</html>
