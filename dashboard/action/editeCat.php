<?php

include ($_SERVER['DOCUMENT_ROOT'] . '/settings.php');

$dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
        or die('Connexion impossible : ' . pg_last_error());

$nomCat = filter_input(INPUT_POST, 'nomCat');
$desCat = filter_input(INPUT_POST, 'desCat');
$IdCat = filter_input(INPUT_POST, 'IdCat');

if ($IdCat!=""){
    if ($nomCat != "") {
        if ($desCat != "") {
            $updateQ = "Update categorie set label_cat='" . pg_escape_string($nomCat) . "', description_cat ='" . pg_escape_string($desCat)."' where id_cat = " . $IdCat;
            echo $updateQ;
            pg_query($updateQ) or die('Échec de la requête : ' . pg_last_error());
            header('Location: http://localhost/dashboard/Article.php?action=success&type=editcat');
        }
    }
}