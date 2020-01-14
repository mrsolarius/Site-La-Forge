<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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

session_start();

//recupération des setting pour ce connecter à la db et avoir un chemain relatif
include ($_SERVER['DOCUMENT_ROOT'] . '/settings.php');

$dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
        or die('Connexion impossible : ' . pg_last_error());

foreach($_POST['id']  as $id)
{
     $idphotoQ = "select id_photo from montrer where id_article =".$id;
     $idphotores = pg_query($idphotoQ) or die('Échec de la requête : ' . pg_last_error());
     $idphoto = pg_fetch_array($idphotores, null, PGSQL_ASSOC);

     $delMQ = "Delete from montrer where id_article =".$id;
     pg_query($delMQ) or die('Échec de la requête : ' . pg_last_error());


     $delFQ = "Delete from photo where id_photo =".$idphoto['id_photo'];
     pg_query($delFQ) or die('Échec de la requête : ' . pg_last_error());

     $delAQ = "Delete from article where id_article =".$id;
     pg_query($delAQ) or die('Échec de la requête : ' . pg_last_error());


     rrmdir(ROOT.'/img/article/'.$id);
}

header('Location: http://localhost/dashboard/Article.php?action=success&type=delbulk&nombre='.sizeof($_POST['id']));