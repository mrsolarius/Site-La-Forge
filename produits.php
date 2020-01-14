<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
$location = basename(__FILE__);
include ($_SERVER['DOCUMENT_ROOT'] . '/settings.php');
?>

<head>
    <meta charset="UTF-8">
    <title>Nos Produits</title>
    <?php include ('./template/head.php');?>
    <link href="css/Nos_couteaux.css" rel="stylesheet" type="text/css"/>
    <link href="css/produits.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <?php include ('./template/navbar.php');?>
    <?php include ('./template/panier.php'); ?>

    <?php
    $idCat = filter_input(INPUT_GET, 'idcat');
    $order = filter_input(INPUT_GET, 'order');

    $dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
            or die('Connexion impossible : ' . pg_last_error());
    $CatQ = 'Select * from categorie inner join photo on photo.id_photo = categorie.id_photo where id_cat =' . $idCat;
    $ThisCatRes = pg_query($CatQ) or die('Échec de la requête : ' . pg_last_error());
    $Cat = pg_fetch_array($ThisCatRes, null, PGSQL_ASSOC);
    $img = "url('." . $Cat['chemin_photo'] . "')";
    echo '<br>';
    echo $img;
    echo '<div class="bgimg-1" style="background-image:' . $img . '">
        <div style="position: absolute;width: 100%;height: 100%;">
            <div class="caption" style="z-index: 1; transform: translateY(-15px);">
                <span class="border">' . $Cat['label_cat'] . '</span>
            </div>
            <div class="catcaption">
                <p>' . nl2br($Cat['description_cat']) . '</p>
            </div>
        </div>
    </div>';
    ?>


    <div id="stopbar" style="color: #777;background-color:white;text-align:center !important;text-align: justify;">
        <div class="allcontant">
            <div class="AutreCat">
                <h4>Les Autre Categorie</h4>
                <?php
                $CatQ = 'Select * from categorie';
                $CatRes = pg_query($CatQ) or die('Échec de la requête : ' . pg_last_error());
                while ($CatRow = pg_fetch_array($CatRes, null, PGSQL_ASSOC)) {
                    echo '<button onclick="location.href=\'\produits.php?idcat=' . $CatRow['id_cat'] . '\'" class="button modifier" type="button">' . $CatRow['label_cat'] . '</button>';
                }
                ?>
            </div>
            <div style="width: -moz-available;width: -webkit-fill-available;">
                <h3>Les Articles</h3>
                <hr>
                <div style="width: -webkit-fill-available;padding: 5%; ">
            <?php
            
            if(isset($order)){
                
            }else{
                $ArtQ = 'Select * from article where id_cat ='.$idCat;
            }
                
                $ArtRes = pg_query($ArtQ) or die('Échec de la requête : ' . pg_last_error());
                while ($ArtRow = pg_fetch_array($ArtRes, null, PGSQL_ASSOC)) {
                    $PictQ = 'Select * from photo inner join montrer on montrer.id_photo = photo.id_photo where id_article = '.$ArtRow['id_article'];
                    $PictRes = pg_query($PictQ) or die('Échec de la requête : ' . pg_last_error());
                    $PictRow = pg_fetch_array($PictRes, null, PGSQL_ASSOC); 
                    
                    if($ArtRow['stock_article']>0){
                        $stockArt = "En Stock";
                    }else{
                        $stockArt = "Epuisée";
                    }
                    
                    echo '
                    <div class="artcontain">
                        <div class="artSubContain">
                            <div class="mobiletitre">
                                <h4 style="font-size: 20px;margin: 0;">'.$ArtRow['label_article'].'</h4>
                                <div class="Note">
                                    <div style="margin-right: 5px;float: left;">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                    </div>
                                    <span style="padding: 8px;letter-spacing: 5px;text-transform: uppercase;font: 10px &quot;Lato&quot;, sans-serif;color: #111;float: left;">2980</span>
                                    
                                </div>
                                
                            </div>
                            <a href="/produit.php?id='.$ArtRow['id_article'].'">
                            <img src="'.$PictRow['chemin_photo'].'" class="ArtPhoto">
                            </a>
                            <div class="ArtInfo">
                                <div class="desktoptitre">
                                    <h4 style="font-size: 20px;margin: 0;">'.$ArtRow['label_article'].'</h4>
                                    <div class="Note">
                                    <div style="margin-right: 5px;float: left;">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                    </div>
                                    <span style="padding: 8px;letter-spacing: 5px;text-transform: uppercase;font: 10px &quot;Lato&quot;, sans-serif;color: #111;float: left;">2980</span>
                                    
                                </div>
                                
                                </div>
                                <h4 class="stock">'.$stockArt.'</h4>
                                <h1 class="prix">'.$ArtRow['prix_article'].'</h1>
                                <button onclick="location.href=\'produits.php?'. addpanier() .'&action=addpanier&pid=' . $ArtRow['id_article'] . '&show=t\'" class="button modifier" type="button">Ajouter Au Panier</button>
                            </div>  
                        </div>
                    </div>';
                    
                }?>
            
                    
                
                </div>
                <hr>
            </div>
        </div>


    </div>
    <div class="bgimg-3"></div>
    <?php include ('./template/footer.php'); ?>  