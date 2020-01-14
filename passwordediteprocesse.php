 <?php
 include ('/settings.php');


$idCli = $_SESSION['idclient'];

$dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
    or die('Connexion impossible : ' . pg_last_error());

$actual = md5(filter_input(INPUT_POST, 'actual'));
$mdp = md5(filter_input(INPUT_POST, 'psw'));
$mdpConfirm = md5(filter_input(INPUT_POST, 'psw-repeat'));

$query = "Select id_client, prenom_client,administrateur, mail_client, mdp_client from client where id_client=".$idCli;
$result = pg_query($query) or die('Échec de la requête : ' . pg_last_error());
$data = pg_fetch_array($result, null, PGSQL_ASSOC);

if($actual!=""){
    if($mdp!=""){
        if($mdpConfirm!=""){
            if($data['mdp_client']==$actual){
                if($mdp===$mdpConfirm){
                    $query = "Update client set mdp_client='".$mdp."' where id_client=".$idCli;
                    $result = pg_query($query) or die('Échec de la requête : ' . pg_last_error());
                    header("location:profile.php");
                }else{
                    echo 'vos deux nouveux mot de passe ne coressponde pas';
                }    
            }else{
                echo 'votre mot de passe actuel et eroner';
            }
        }else{
            echo 'Vous n\'avez pas indiquer de confiramation du mdp';
        }
    }else{
        echo 'Vous n\'avez pas indiquer de nouveau mdp';
    }
}else{
    echo 'Vous n\'avez pas indiquer votre mot de passe actuelle';
}


