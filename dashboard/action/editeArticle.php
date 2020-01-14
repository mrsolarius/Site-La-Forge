<?php
include ($_SERVER['DOCUMENT_ROOT'] . '/settings.php');

$dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
        or die('Connexion impossible : ' . pg_last_error());



$nomArt = filter_input(INPUT_POST, 'nomArt');
$stockArt = (int)filter_input(INPUT_POST, 'stockArt');
$prixArt = (int)filter_input(INPUT_POST, 'prixArt');
$ArtCat = filter_input(INPUT_POST, 'ArtCat');
$descriptionArt = filter_input(INPUT_POST, 'descriptionArt');
$IdArt = filter_input(INPUT_POST, 'IdArt');

if ($IdArt != "") {
    if ($nomArt !== "") {
        if (strlen($nomArt) < 101) {
            if ($stockArt !== "") {
                if (is_int($stockArt)) {
                    if ($prixArt != "") {
                        if (is_int($prixArt)) {
                            $updateQ = "Update article set id_cat=".$ArtCat.", label_article ='".pg_escape_string($nomArt)."', prix_article=".$prixArt.", desc_article='".pg_escape_string($descriptionArt)."', stock_article=".$stockArt." where id_article = ".$IdArt;
         
                            pg_query($updateQ) or die('Échec de la requête : ' . pg_last_error());
                            header('Location: http://localhost/dashboard/Article.php?action=success&type=editart');
                        }else{
                            echo 'le prix n\'est pas entier';
                        }
                    }else{
                        echo 'le prix n\'est pas indiquer';
                    }
                }else{
                    echo 'le stock n\'est pas un entier';
                }
            }else{
                echo 'le stock n\'est pas definie';
            }
        }else{
            echo 'le nom de l\'article et trop grand';
        }
    }else{
        echo 'le nom de l\'article n\'est pas definie';
    }
}else{
    echo 'l\'id de l\'article et absent';
}
