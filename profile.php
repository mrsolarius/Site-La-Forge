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
                    <img id="profile" src="http://lorempixel.com/400/200" />
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
                    <div style="display: grid;grid-template-columns: max-content auto;grid-gap: 10px;">
                        <label>Nom</label>
                        <label>'.$profile['nom_client'].'</label>
                        <label>Prénom</label>
                        <label>'.$profile['prenom_client'].'</label>
                        <label>Télephone</label>
                        <label>'.$profile['tel_client'].'</label>
                        <label>Email</label>
                        <label>'.$profile['mail_client'].'</label>
                        <label>Rue</label>
                        <label>'.$profile['rue_client'].'</label>
                        <label>Ville</label>
                        <label>'.$profile['ville_client'].'</label>
                        <label>Cpostal</label>
                        <label>'.$profile['cp_client'].'</label>
                        
                    </div>
                    <button onclick="location.href=\'editprofile.php\'" class="button modifier">Modifier mes information</button>
                    <button onclick="location.href=\'editpasword.php\'" class="button modifier">Changer de mot de passe</button>
                </div>
            </div>
        </div>
    </div>';
    }else{
        echo 'vous n\'ête pas connecté';
    } ?>
    <div class="bgimg-3"></div>
    <form >
    <?php include ('./template/footer.php'); ?>  
</body>

