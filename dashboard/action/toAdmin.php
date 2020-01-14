<?php
include ($_SERVER['DOCUMENT_ROOT'] . '/settings.php');

$dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
        or die('Connexion impossible : ' . pg_last_error());

if(isset($_POST['id'])){
    $rem = "update client set administrateur = true where id_client=".$_POST['id'];
    pg_query($rem) or die('Échec de la requête : ' . pg_last_error());
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}else{
    echo 'il y à une erreur';
}