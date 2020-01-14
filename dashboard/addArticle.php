<?php

session_start();
include ($_SERVER['DOCUMENT_ROOT'] . '/settings.php');

$dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
        or die('Connexion impossible : ' . pg_last_error());

$nomArt = filter_input(INPUT_POST, 'NomArticle');
$addCat = filter_input(INPUT_POST, 'addCat');

if ($addCat === 'oui') {
    $nomCat = filter_input(INPUT_POST, 'nomCat');
    $desciptCat = filter_input(INPUT_POST, 'desCat');
    $alt = filter_input(INPUT_POST, 'altImgCat');
    if (isset($desciptCat)) {
        
    } else {
        $desciptCat = "";
    }
    if (isset($nomCat)) {
        if (strlen($nomCat) < 51) {
            if (strlen($desciptCat) < 281) {
                if (isset($_FILES['imgCat'])) {
                    if ($_FILES['imgCat']['error'] > 0) {
                        echo 'Il y a eu une erreur lors de l\'upload de l\'image de la cathegorie';
                        exit();
                    } else {

                        $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
                        $extension_upload = strtolower(substr(strrchr($_FILES['imgCat']['name'], '.'), 1));
                        if (in_array($extension_upload, $extensions_valides)) {
                            $destination = "/img/categorie/{$nomCat}.{$extension_upload}";
                            $resultat = move_uploaded_file($_FILES['imgCat']['tmp_name'], ROOT . $destination);
                            echo (ROOT . $destination);

                            if ($resultat) {
                                if (isset($alt)) {
                                    
                                } else {
                                    $alt = "";
                                }
                                if (strlen($alt) < 51) {
                                    $insertPhoto = "Insert Into Photo (chemin_photo,alt_photo) Values('" . $destination . "','" . $alt . "');";
                                    echo $insertPhoto;
                                    $data = pg_query($insertPhoto) or die('Échec de la requête : ' . pg_last_error());
                                    if ($data) {
                                        $SelectIdImg = "Select id_photo from photo where chemin_photo = '" . $destination . "';";
                                        $qresult = pg_query($SelectIdImg) or die('Échec de la requête : ' . pg_last_error());
                                        $dbimg = pg_fetch_array($qresult, null, PGSQL_ASSOC);
                                        if ($dbimg) {
                                            $insertCat = "Insert Into categorie (id_photo,label_cat,description_cat) Values ('" . $dbimg['id_photo'] . "','" . $nomCat . "','" . $desciptCat . "');";
                                            pg_query($insertCat) or die('Échec de la requête : ' . pg_last_error());
                                        }
                                    }
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
        echo 'vous n\'avez pas indiquer de titre';
    }
    $nomArt = filter_input(INPUT_POST, 'nomArt');
    $stockArt = (int) filter_input(INPUT_POST, 'stockArt');
    $prixArt = (int) filter_input(INPUT_POST, 'prixArt');
    $descriptionArt = filter_input(INPUT_POST, 'descriptionArt');
    if (isset($descriptionArt)) {
        
    } else {
        $descriptionArt = "";
    }
    if (isset($nomArt)) {
        if (strlen($nomArt) < 101) {
            if (isset($stockArt)) {

                if (is_int($stockArt)) {
                    if (isset($prixArt)) {
                        if (is_int($prixArt)) {
                            $idCatQ = "Select id_cat from categorie where label_cat='".$nomCat."' LIMIT 1;"; 
                            echo '<br>';
                            echo $idCatQ;
                            echo '<br>';
                            $idCatStart = pg_query($idCatQ) or die('Échec de la requête : ' . pg_last_error());
                            $idCat = pg_fetch_array($idCatStart, null, PGSQL_ASSOC);
                            echo '<br>';
                            echo ('Ici la valeur : '.$idCat['id_cat']);
                            echo '<br>';
                            
                            //insertion de l'
                            $ArtInsertQ = "Insert into article (id_cat,label_article,desc_article,prix_article,stock_article) values('".$idCat['id_cat'][0]."','".pg_escape_string($nomArt)."','".pg_escape_string($descriptionArt)."','".$prixArt."','".$stockArt."')";
                            echo '<br>';
                            echo $ArtInsertQ;
                            echo '<br>';
                            $resultat = pg_query($ArtInsertQ) or die('Échec de la requête : ' . pg_last_error());
                            
                            echo '<br>';
                            $ArtIdQ = "Select label_article from article where label_article = '".pg_escape_string($nomArt)." LIMIT 1';";
                            echo $ArtIdQ;
                            echo '<br>';
                            $ArtId = pg_query($ArtIdQ) or die('Échec de la requête : ' . pg_last_error());
                        
                            
                            if (isset($_FILES['imgArt'])) {
                                //Contage du nombre de fichier
                                $total_fichier_uploade = count($_FILES['imgArt']['tmp_name']);
                                
                                //creation du dossier de l'article
                                mkdir(ROOT."/img/article/{$nomArt}", 0777, true);
                                
                                //parcours des image
                                for ($i = 0; $i < $total_fichier_uploade; $i++) {
                                    if ($_FILES['imgCat']['error'] > 0) {
                                        echo 'Il y a eu une erreur lors de l\'upload de l\'image de la cathegorie';
                                    } else {
                                        //Extention valider
                                        $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
                                        //recupération de l'image 
                                        $extension_upload = strtolower(substr(strrchr($_FILES['imgCat']['name'], '.'), 1));
                                        
                                        // verification des extention 
                                        if (in_array($extension_upload, $extensions_valides)) {
                                            
                                            //definition de la destination de l'image
                                            $destination = "/img/article/{$nomArt}/{$i}.{$extension_upload}";
                                            
                                            echo $destination;
                                            echo '<br>';
                                            
                                            //deplacement de l'image du repertoir temporaire vers le repertoir definitif
                                            $resultat = move_uploaded_file($_FILES['imgCat']['tmp_name'], ROOT . $destination);

                                            if ($resultat) {
                                                    // insertion de l'image
                                                    $insertPhoto = "Insert Into Photo (chemin_photo) Values('" . $destination . "');";
                                                    $data = pg_query($insertPhoto) or die('Échec de la requête : ' . pg_last_error());
                                                    
                                                    if ($data) {
                                                        //Selection de l'id de l'image précédament inseret
                                                        $SelectIdImg = "Select id_photo from photo where chemin_photo = '" . $destination . "';";
                                                        $qresult = pg_query($SelectIdImg) or die('Échec de la requête : ' . pg_last_error());
                                                        $dbimg = pg_fetch_array($qresult, null, PGSQL_ASSOC);
                                                        
                                                        
                                                        //Association des image sur l'article
                                                        $insetArticleQ = "Insert into montrer (id_photo,id_article) values('".$dbimg['id_photo']."','".$ArtId['label_article']."';";
                                                        $insetArticle = pg_fetch_array($qresult, null, PGSQL_ASSOC);
                                                        
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            } else {
                                echo 'Votre prix n\'est pas un nombre entier';
                            }
                        } else {
                            echo 'Vous n\'avez pas indiquer le prix';
                        }
                    } else {
                        echo 'Votre stock n\'est pas un nombre entier';
                    }
                } else {
                    echo 'Vous n\'avez pas indique le stock';
                }
            } else {
                echo 'Le nom de votre article fait plus de 100 caracther';
            }
        } else {
            echo 'Vous\'avez pas indiquer le nom de votre article';
        }
    } else {
        echo'non';
    }
    