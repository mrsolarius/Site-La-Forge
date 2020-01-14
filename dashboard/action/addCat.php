<?php


//fonction pour suprimer les acsent
function stripAccents($stripAccents) {
    return strtr($stripAccents, 'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ', 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
}

session_start();

//recupération des setting pour ce connecter à la db et avoir un chemain relatif
include ($_SERVER['DOCUMENT_ROOT'] . '/settings.php');

$dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
        or die('Connexion impossible : ' . pg_last_error());

    $nomCat = filter_input(INPUT_POST, 'nomCat');
    $desciptCat = filter_input(INPUT_POST, 'desCat');
    $alt = filter_input(INPUT_POST, 'altImgCat');
    //set up des variable non obligatoire
    if (isset($desciptCat)) {
        
    } else {
        $desciptCat = "";
    }
if (isset($nomCat)) {
        if (strlen($nomCat) < 51) {
            if (strlen($desciptCat) < 281) {
                //verification de la présence d'une image
                if (isset($_FILES['imgCat'])) {
                    if ($_FILES['imgCat']['error'] > 0) {
                        echo 'Il y a eu une erreur lors de l\'upload de l\'image de la cathegorie';
                        exit();
                    } else {

                        $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
                        //récupération de l'extention du fichier
                        $extension_upload = strtolower(substr(strrchr($_FILES['imgCat']['name'], '.'), 1));
                        //verification des extention
                        if (in_array($extension_upload, $extensions_valides)) {

                            //definistion de la destionation de l'image de la categorie 
                            $destination = "/img/categorie/" . stripAccents($nomCat) . "." . $extension_upload;
                            //deplacement de l'image de sont emplacement temporaire vers sont emplacement definitif
                            $resultat = move_uploaded_file($_FILES['imgCat']['tmp_name'], ROOT . $destination);

                            //set up des variable non obligatoire
                            if ($resultat) {
                                if (isset($alt)) {
                                    
                                } else {
                                    $alt = "";
                                }
                                //verification de la variable alt
                                if (strlen($alt) < 51) {

                                    //insertion de la photo
                                    $insertPhoto = "Insert Into Photo (chemin_photo,alt_photo) Values('" . $destination . "','" . $alt . "') RETURNING id_photo;";
                                    $data = pg_query($insertPhoto) or die('Échec de la requête : ' . pg_last_error());
                                    //recupération de l'id de la photo grasse au RETURNING de la requet
                                    $dbimg = pg_fetch_array($data, null, PGSQL_ASSOC);


                                    if ($dbimg) {
                                        //insertion de la cathegorie
                                        $insertCatQ = "Insert Into categorie (id_photo,label_cat,description_cat) Values ('" . $dbimg['id_photo'] . "','" . pg_escape_string($nomCat) . "','" . pg_escape_string($desciptCat) . "')RETURNING id_cat;";
                                        $insertCat = pg_query($insertCatQ) or die('Échec de la requête : ' . pg_last_error());
                                        //recupération de l'id de la categorie grasse au RETURNING de la requet
                                        $idCat = pg_fetch_array($insertCat, null, PGSQL_ASSOC);
                                        echo $idCat['id_cat'];
                                    }
                                    //affichage de toute les erreur
                                } else {
                                    echo 'Votre description d\'image est trop longue';
                                    exit();
                                }
                            } else {
                                echo'Erreur lors de la copy';
                                exit();
                            }
                        } else {
                            echo 'Extension incorect';
                            exit();
                        }
                    }
                } else {
                    echo 'Veuiller ajouter une image à votre cathegorie';
                    exit();
                }
            } else {
                echo 'la description de votre cathegorie et trop longue';
                exit();
            }
        } else {
            echo 'le titre de votre categorie et trop long';
            exit();
        }
    } else {
        echo 'vous n\'avez pas indiquer de titre de la cathegorie';
        exit();
    }

header('Location: http://localhost/dashboard/Article.php?action=success&type=addcat');