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
    <link href="css/Produit.css" rel="stylesheet" type="text/css"/>
    <script src = "http://thecodeplayer.com/uploads/js/prefixfree.js" type = "text/javascript"></script>
</head>
<body>
    <?php include ('./template/navbar.php');?>
    <?php include ('./template/panier.php'); ?>
    <?php
    $dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
                    or die('Connexion impossible : ' . pg_last_error());
    
    $idArt = filter_input(INPUT_GET, 'id');

    $ArtQ = 'Select * from article inner join categorie on article.id_cat = categorie.id_cat where id_article ='.$idArt;
    echo '<br> ici : '.$ArtQ;
    
    $ArtRes = pg_query($ArtQ) or die('Échec de la requête : ' . pg_last_error());
    $Art = pg_fetch_array($ArtRes, null, PGSQL_ASSOC);
    echo '
            <div>
            <div class = "articleConteneur">
            <div class="tile1">
            <a href="/produits.php?idcat='.$Art['id_cat'].'" style="text-decoration: blink;"><h3>'.$Art['label_cat'].'</h3></a>
            <h1>'.$Art['label_article'].'</h1>
            <div style="display: flex;">
                <div style="position: relative;padding: 5px;">
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                </div>
                <h4 style="padding: 5px;">
                    2980 votes
                </h4>
            </div>
            <hr>
            </div>
            <div class = "colonededroite">
            <div class = "slider">
            ';
            $PictQ = 'Select * from photo inner join montrer on montrer.id_photo = photo.id_photo where id_article = '.$idArt;
            $PictRes = pg_query($PictQ) or die('Échec de la requête : ' . pg_last_error());
            $i=0;
            while ($PictRow = pg_fetch_array($PictRes, null, PGSQL_ASSOC)) {
            $i=$i+1;
            if($i===1){
                echo'
                <input type = "radio" name = "slide_switch" id = "'.$i.'" checked="checked"/>
                <label for = "'.$i.'">
                <img src = "'.$PictRow['chemin_photo'].'" width = "100"/>
                </label>
                <img src = "'.$PictRow['chemin_photo'].'"/>
            ';
            }else{
            echo '
                <input type = "radio" name = "slide_switch" id = "'.$i.'"/>
                <label for = "'.$i.'">
                <img src = "'.$PictRow['chemin_photo'].'" width = "100"/>
                </label>
                <img src = "'.$PictRow['chemin_photo'].'"/>
            ';
            }
            
            }
            echo '
            </div>
        </div>
        <div class="colonedegauche">
            <div class="tile">
            <a href="/produits.php?idcat='.$Art['id_cat'].'" style="text-decoration: blink;"><h3>'.$Art['label_cat'].'</h3></a>
            <h1>'.$Art['label_article'].'</h1>
            <div style="display: flex;">
                <div style="position: relative;padding: 5px;">
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star checked"></span>
                    <span class="fa fa-star"></span>
                    <span class="fa fa-star"></span>
                </div>
                <h4 style="padding: 5px;">
                    2980 votes
                </h4>
            </div>
            <hr>
            </div>
            <div style="margin: 20px auto;">
                '.nl2br ($Art['desc_article']).'
            </div>
            <div>
                <h2 style="padding: 10px;float: left;font: 40px &quot;Lato&quot;, sans-serif;">'.$Art['prix_article'].'</h2>
                <button onclick="location.href=\'produit.php?'. addpanier() .'&action=addpanier&pid=' . $Art['id_article'] . '&show=t\'" class="button modifier" style="padding: 5px;margin: 12px 20px;">ajouter au panier</button>
            </div>


        </div>
        </div>
        </div>';?>
        <div class="bgimg-3"></div>
        <?php include ('./template/footer.php'); ?>  
</body>