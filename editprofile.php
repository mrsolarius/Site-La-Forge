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
                    <form method="post" action="updateProfile.php" style="display: grid;grid-template-columns: max-content auto;">
                        <label>Nom</label>
                        <input name="name" value="'.$profile['nom_client'].'" type="text">
                        <label>Prenom</label>
                        <input name="surname" value="'.$profile['prenom_client'].'" type="text">
                        <label>Telephone</label>
                        <input name="tel" value="'.$profile['tel_client'].'" type="tel">
                        <label>Email</label>
                        <input name="mail" value="'.$profile['mail_client'].'" type="email">
                        <label>Rue</label>
                        <input name="rue" value="'.$profile['rue_client'].'" type="text">
                        <label>Ville</label>
                        <input name="ville" value="'.$profile['ville_client'].'" type="text">
                        <label>Cpostal</label>
                        <input name="cpost" value="'.$profile['cp_client'].'" type="text">
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
