<?php
include ('./settings.php');

session_start();

$dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
    or die('Connexion impossible : ' . pg_last_error());

$email = strtolower(filter_input(INPUT_POST, 'email'));
$mdp = md5(filter_input(INPUT_POST, 'psw'));

$query = "Select id_client, prenom_client,administrateur, mail_client, mdp_client from client where mail_client='$email'";
$result = pg_query($query) or die('Échec de la requête : ' . pg_last_error());

$data = pg_fetch_array($result, null, PGSQL_ASSOC);

if($data['mail_client']==$email){
    if($data['mdp_client']==$mdp){
        $_SESSION['idclient']=$data['id_client'];
        $_SESSION['email']=$email;
        $_SESSION['prenom']=$data['prenom_client']; 
        $_SESSION['admin']=$data['administrateur'];
        print_r($_SESSION);
        header('Location: index.php');
    }else{
        echo 'votre mot de passe est invalide';
        exit();
    }
}else{
    echo 'Votre compte n\'existe pas';
    exit();
}




