<?php
include ('./settings.php');

session_start();

$dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
    or die('Connexion impossible : ' . pg_last_error());

$nom = filter_input(INPUT_POST, 'noms');
$prenom = filter_input(INPUT_POST, 'prenom');
$email = strtolower(filter_input(INPUT_POST, 'email'));
$mdp = md5(filter_input(INPUT_POST, 'psw'));

$query = "Select mail_client from client where mail_client='$email'";
$qresult = pg_query($query) or die('Échec de la requête : ' . pg_last_error());

$data = pg_fetch_array($qresult, null, PGSQL_ASSOC);

if(!$data){
    $query = "INSERT INTO client (nom_client,prenom_client,mail_client,mdp_client,administrateur) 
    VALUES ('".$nom."','".$prenom."','".$email."','".$mdp."',false)";
    $result = pg_query($query) or die('Échec de la requête : ' . pg_last_error());
    
    $query = "Select id_client, mail_client, administrateur from client where mail_client='$email'";
    $qresult = pg_query($query) or die('Échec de la requête : ' . pg_last_error());
    
    $data = pg_fetch_array($qresult, null, PGSQL_ASSOC);
    
    if($data){
        $_SESSION['idclient']=$data['id_client'];
        $_SESSION['email']=$email;
        $_SESSION['prenom']=$prenom;
        $_SESSION['admin']=$data['administrateur'];
        header('Location: index.php');
        exit();
    } else {
        echo ('Il y a eut une erreur');
        exit();
    }
    
    
}else{
    echo ('Votre compte existe déjà');
    exit();
}


?>
