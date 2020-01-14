<?php
include ($_SERVER['DOCUMENT_ROOT'] . '/settings.php');

function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir . "/" . $object) === "dir") {
                    rrmdir($dir . "/" . $object);
                } else {
                    unlink($dir . "/" . $object);
                }
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

if (isset($_POST['ArtCat'])) {
    $idCat = filter_input(INPUT_POST, 'ArtCat');

    $dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
            or die('Connexion impossible : ' . pg_last_error());


    $selectQ = "Select * from article inner join categorie on categorie.id_cat = article.id_cat where article.id_cat =" . $idCat;
    $selectRes = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
    
    while ($row = pg_fetch_array($selectRes, null, PGSQL_ASSOC)) {
        
        $idphotoQ = "select id_photo from montrer where id_article =" . $row['id_article'];
        $idphotores = pg_query($idphotoQ) or die('Échec de la requête : ' . pg_last_error());
        $idphoto = pg_fetch_array($idphotores, null, PGSQL_ASSOC);

        $delMQ = "Delete from montrer where id_article =" . $row['id_article'];
        pg_query($delMQ) or die('Échec de la requête : ' . pg_last_error());


        $delFQ = "Delete from photo where id_photo =" . $idphoto['id_photo'];
        pg_query($delFQ) or die('Échec de la requête : ' . pg_last_error());

        $delAQ = "Delete from article where id_article =" . $row['id_article'];
        pg_query($delAQ) or die('Échec de la requête : ' . pg_last_error());


        rrmdir(ROOT . '/img/article/' . $row['id_article']);
    }
    
    $catphotoQ = "select * from categorie inner join photo on categorie.id_photo =  photo.id_photo where id_cat =" . $idCat;
    $catphotoStore = pg_query($catphotoQ) or die('Échec de la requête : ' . pg_last_error());
    $catphoto = pg_fetch_array($catphotoStore, null, PGSQL_ASSOC);
    
    unlink(ROOT . $catphoto['chemin_photo']);
    
    $delCatQ = "Delete from categorie where id_cat =" . $idCat;
    pg_query($delCatQ) or die('Échec de la requête : ' . pg_last_error());
    
    $idphoto = pg_fetch_array($selectRes, null, PGSQL_ASSOC);
    $delFQ = "Delete from photo where id_photo =" . $catphoto['id_photo'];
    pg_query($delFQ) or die('Échec de la requête : ' . pg_last_error());
    
    header('Location: http://localhost/dashboard/Article.php?action=success&type=delcat');
    
    
}



