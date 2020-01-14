<?php
 $location = basename(__FILE__);
 include ($_SERVER['DOCUMENT_ROOT'] . '/settings.php');
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
            <form action="signinprocesse.php" method="post">
              <div class="container">
                <h1>Se connecter</h1>
                <p>Merci de remplir ce formulaire pour vous connecter</p>
                <hr>
                <label for="email"><b>Email</b></label>
                <input type="email" placeholder="Entrer un Email" name="email" required>

                <label for="psw"><b>Mot de passe</b></label>
                <input type="password" placeholder="Enter un mot de passe" name="psw" required>

                <p>En continuant, vous acceptez les <a href="./legal/condition-utilisation.php">Conditions d'utilisation</a> et notre <a href="./legal/politique-de-confidentialite.php">Politique de confidentialité</a>.</p>
                <button type="submit" class="registerbtn">Se connecter</button>
              </div>

              <div class="container signin">
                  <p>vous n'avez pas encore de compte ? <a href="signup.php">Créés en un</a>.</p>
              </div>
        </form>
        </div>
        <br>
        <?php include ('./template/footer.php');?>
    </body>
</html>
