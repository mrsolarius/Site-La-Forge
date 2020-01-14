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

//recupération des envoie du poste
$nomArt = filter_input(INPUT_POST, 'NomArticle');
$addCat = filter_input(INPUT_POST, 'addCat');

//on test si c'est un ajout d'article et de cathegorie ou si c'est juste un aticle
if ($addCat === 'oui') {
    //recupération d'autre envoie
    $nomCat = filter_input(INPUT_POST, 'nomCat');
    $desciptCat = filter_input(INPUT_POST, 'desCat');
    $alt = filter_input(INPUT_POST, 'altImgCat');
    //set up des variable non obligatoire
    if (isset($desciptCat)) {
        
    } else {
        $desciptCat = "";
    }
    //ajout de la cathegorie
    //verification des variable
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

    //recupération des variable poste de l'article
    $nomArt = filter_input(INPUT_POST, 'nomArt');
    $descriptionArt = filter_input(INPUT_POST, 'descriptionArt');

    //caste des string qui doive être des int
    $stockArt = (int) filter_input(INPUT_POST, 'stockArt');
    $prixArt = (int) filter_input(INPUT_POST, 'prixArt');


    //setup des variable inutile
    if (isset($descriptionArt)) {
        
    } else {
        $descriptionArt = "";
    }

    // verification des variable
    if (isset($nomArt)) {
        if (strlen($nomArt) < 101) {
            if (isset($stockArt)) {

                if (is_int($stockArt)) {
                    if (isset($prixArt)) {
                        if (is_int($prixArt)) {

                            //insertion de l'artile
                            $ArtInsertQ = "Insert into article (id_cat,label_article,desc_article,prix_article,stock_article) values('" . $idCat['id_cat'] . "','" . pg_escape_string($nomArt) . "','" . pg_escape_string($descriptionArt) . "','" . $prixArt . "','" . $stockArt . "') RETURNING id_article";
                            $resultat = pg_query($ArtInsertQ) or die('Échec de la requête : ' . pg_last_error());
                            //recupération de l'id de l'article grasse au retuning de la requete 
                            $idArt = pg_fetch_array($resultat, null, PGSQL_ASSOC);

                            echo $idArt['id_article'];
                            echo '<br>';
                            if (isset($_FILES['imgArt'])) {
                                //Contage du nombre de fichier
                                $total_fichier_uploade = count($_FILES['imgArt']['tmp_name']);

                                //creation du dossier de l'article                                
                                mkdir(ROOT . "/img/article/{$idArt['id_article']}", 0777, true);

                                //parcours des image
                                for ($i = 0; $i < $total_fichier_uploade; $i++) {
                                    if ($_FILES['imgArt']['error'][$i] > 0) {
                                        echo 'Il y a eu une erreur lors de l\'upload des images de l\'artcile';
                                    } else {
                                        //Extention valider
                                        $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
                                        //recupération de l'image 
                                        $extension_upload = strtolower(substr(strrchr($_FILES['imgArt']['name'][$i], '.'), 1));

                                        // verification des extention 
                                        if (in_array($extension_upload, $extensions_valides)) {

                                            //definition de la destination de l'image
                                            $destination = "/img/article/{$idArt['id_article']}/{$i}.{$extension_upload}";

                                            //deplacement de l'image du repertoir temporaire vers le repertoir definitif
                                            $resultat = move_uploaded_file($_FILES['imgArt']['tmp_name'][$i], ROOT . $destination);

                                            if ($resultat) {
                                                // insertion de l'image
                                                $insertPhoto = "Insert Into Photo (chemin_photo) Values('" . $destination . "')RETURNING id_photo;";
                                                $data = pg_query($insertPhoto) or die('Échec de la requête : ' . pg_last_error());
                                                $dbimg = pg_fetch_array($data, null, PGSQL_ASSOC);
                                                if ($dbimg['id_photo']) {
                                                    //Association des image sur l'article
                                                    $insetArticleQ = "Insert into montrer (id_photo,id_article) values('" . $dbimg['id_photo'] . "','" . $idArt['id_article'] . "');";
                                                    $insetArticle = pg_query($insetArticleQ) or die('Échec de la requête : ' . pg_last_error());
                                                    
                                                    
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            //affichage des erreur
                        } else {
                            echo 'Votre prix n\'est pas un nombre entier';
                            exit();
                        }
                    } else {
                        echo 'Vous n\'avez pas indiquer le prix';
                        exit();
                    }
                } else {
                    echo 'Votre stock n\'est pas un nombre entier';
                    exit();
                }
            } else {
                echo 'Vous n\'avez pas indique le stock';
                exit();
            }
        } else {
            echo 'Le nom de votre article fait plus de 100 caracther';
            exit();
        }
    } else {
        echo 'Vous\'avez pas indiquer le nom de votre article';
        exit();
    }
    header('Location: http://localhost/dashboard/Article.php?action=success&type=addCataddArt');
} else {
    
    //recupération des variable poste de l'article
    $nomArt = filter_input(INPUT_POST, 'nomArt');
    $descriptionArt = filter_input(INPUT_POST, 'descriptionArt');
    $idCat = filter_input(INPUT_POST, 'ArtCat');
    

    //caste des string qui doive être des int
    $stockArt = (int) filter_input(INPUT_POST, 'stockArt');
    $prixArt = (int) filter_input(INPUT_POST, 'prixArt');


    //setup des variable inutile
    if (isset($descriptionArt)) {
        
    } else {
        $descriptionArt = "";
    }

    // verification des variable
    if (isset($nomArt)) {
        if (strlen($nomArt) < 101) {
            if (isset($stockArt)) {

                if (is_int($stockArt)) {
                    if (isset($prixArt)) {
                        if (is_int($prixArt)) {

                            //insertion de l'artile
                            $ArtInsertQ = "Insert into article (id_cat,label_article,desc_article,prix_article,stock_article) values('" . $idCat . "','" . pg_escape_string($nomArt) . "','" . pg_escape_string($descriptionArt) . "','" . $prixArt . "','" . $stockArt . "') RETURNING id_article";
                            $resultat = pg_query($ArtInsertQ) or die('Échec de la requête : ' . pg_last_error());
                            //recupération de l'id de l'article grasse au retuning de la requete 
                            $idArt = pg_fetch_array($resultat, null, PGSQL_ASSOC);

                            echo $idArt['id_article'];
                            echo '<br>';
                            if (isset($_FILES['imgArt'])) {
                                //Contage du nombre de fichier
                                $total_fichier_uploade = count($_FILES['imgArt']['tmp_name']);

                                //creation du dossier de l'article                                
                                mkdir(ROOT . "/img/article/{$idArt['id_article']}", 0777, true);

                                //parcours des image
                                for ($i = 0; $i < $total_fichier_uploade; $i++) {
                                    if ($_FILES['imgArt']['error'][$i] > 0) {
                                        echo 'Il y a eu une erreur lors de l\'upload des images de l\'artcile';
                                    } else {
                                        //Extention valider
                                        $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
                                        //recupération de l'image 
                                        $extension_upload = strtolower(substr(strrchr($_FILES['imgArt']['name'][$i], '.'), 1));

                                        // verification des extention 
                                        if (in_array($extension_upload, $extensions_valides)) {

                                            //definition de la destination de l'image
                                            $destination = "/img/article/{$idArt['id_article']}/{$i}.{$extension_upload}";

                                            //deplacement de l'image du repertoir temporaire vers le repertoir definitif
                                            $resultat = move_uploaded_file($_FILES['imgArt']['tmp_name'][$i], ROOT . $destination);

                                            if ($resultat) {
                                                // insertion de l'image
                                                $insertPhoto = "Insert Into Photo (chemin_photo) Values('" . $destination . "')RETURNING id_photo;";
                                                $data = pg_query($insertPhoto) or die('Échec de la requête : ' . pg_last_error());
                                                $dbimg = pg_fetch_array($data, null, PGSQL_ASSOC);
                                                if ($dbimg['id_photo']) {
                                                    //Association des image sur l'article
                                                    $insetArticleQ = "Insert into montrer (id_photo,id_article) values('" . $dbimg['id_photo'] . "','" . $idArt['id_article'] . "');";
                                                    $insetArticle = pg_query($insetArticleQ) or die('Échec de la requête : ' . pg_last_error());
                                                    
                                                    
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            //affichage des erreur
                        } else {
                            echo 'Votre prix n\'est pas un nombre entier';
                            exit();
                        }
                    } else {
                        echo 'Vous n\'avez pas indiquer le prix';
                        exit();
                    }
                } else {
                    echo 'Votre stock n\'est pas un nombre entier';
                    exit();
                }
            } else {
                echo 'Vous n\'avez pas indique le stock';
                exit();
            }
        } else {
            echo 'Le nom de votre article fait plus de 100 caracther';
            exit();
        }
    } else {
        echo 'Vous\'avez pas indiquer le nom de votre article';
        exit();
    }
    header('Location: http://localhost/dashboard/Article.php?action=success&type=addArt');
}