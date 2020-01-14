<?php
$location = basename(__FILE__);
include ($_SERVER['DOCUMENT_ROOT'] . '/settings.php');
?>

<head>
    <meta charset="UTF-8">
    <title>Mon Profile</title>
    <?php include ('./template/head.php');?>
    <link href="css/profile.css" rel="stylesheet" type="text/css"/>
    <link href="css/form.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <?php include ('./template/navbar.php');?>
    <?php include ('./template/panier.php'); ?>
    <?php
    if (isset($_SESSION['idclient'])) {
        $idCli = $_SESSION['idclient'];
        $dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
        or die('Connexion impossible : ' . pg_last_error());
        
        $profileQ = "select * from client where id_client = ".$idCli;
        $profileRes = pg_query($profileQ) or die('Échec de la requête : ' . pg_last_error());
        $profile = pg_fetch_array($profileRes, null, PGSQL_ASSOC);
        
        echo '
        <div style="margin-top: 64px;">
        <div class="articleConteneur" style="margin: auto;display: block;max-width: 1024px;">
            <div style="display: flex;">
                <div>
                    <img src="http://lorempixel.com/400/200" />
                </div>
                <div style="width: 100%;">
                    <h1>'.$profile['prenom_client'].' '.$profile['nom_client'].'</h1>
                    <hr>
                    <br>
                    <div>
                        <a style="padding: 10px;" href="profile.php">A Propos De Moi</a>
                        <a style="padding: 10px;">Activité</a>
                    </div>
                    <hr>
                    <form method="post" action="passwordediteprocesse.php">
                        <label><b>Mot de passe Actuel</b></label>
                        <input name="actual" type="password" required>
                        <div style="position: relative;">
                            <label for="psw"><b>Mot de passe</b></label>
                            <input id="psw" type="password" placeholder="Enter un mot de passe" name="psw" required>
                        <span id="passtip"></span>
                        </div>

                        <label for="psw-repeat"><b>Confirmation du mot de passe</b></label>
                        <input id="psw-repeat" type="password" placeholder="reecrire le mot de passe" name="psw-repeat" required>
                        <span id="pswerr"></span>
                        <button type="submit" class="button modifier">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>';
    }else{
        echo 'vous n\'ête pas conecter';
    } ?>
    <div class="bgimg-3"></div>
    <form >
    <?php include ('./template/footer.php'); ?>  
        <script src="js/registerVerif.js" type="text/javascript"></script>
</body>
