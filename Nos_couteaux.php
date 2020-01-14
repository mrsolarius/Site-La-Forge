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
        <?php include ('./template/head.php');?>
        <link href="css/Nos_couteaux.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php include ('./template/navbar.php');?>
        <?php include ('./template/panier.php'); ?>
        
            <div class="bgimg-1" >
            <div class="caption">
                <span class="border">NOS COUTEAUX</span>
            </div>
        </div>
        
        
        
        <div id="stopbar" style="color: #777;background-color:white;text-align:center;text-align: justify;">
            <h3 style="text-align:center;">CATEGORIES</h3>
            <p>Tous nos couteaux sont fabriqués de manière artisanale en Savoie. Les lames sont forgées dans des aciers de qualité, et les manches sont façonnés en bois massifs ou en marqueterie de plusieurs bois. Les lames sont laissées brutes de forge sur le dos, ce qui donne un style rustique et moderne. Chaque couteau est étudié pour être le plus performant selon les utilisations. Les couteaux de cuisine sont forgés très fin et léger pour avoir une coupe exceptionnelle, tandis que les couteaux de camp sont plus lourd et plus épais. Les couteaux pliants de type piémontais sont assez polyvalent. Les couteaux utilitaires sont destinés à une utilisation quotidienne (table, cuisine, randonnée...)</p>
        </div>
        
        <?php
        
        $dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
        or die('Connexion impossible : ' . pg_last_error());
        $CatQuery = 'Select * from categorie inner join photo on categorie.id_photo = photo.id_photo';
        $catRes = pg_query($CatQuery) or die('Échec de la requête : ' . pg_last_error());
        if (!$catRes) {
            echo '
                <div id="stopbar" style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
                <h3 style="text-align:center;">Il y a un probléme</h3>
                <p>Veuiller contacter le créateur du site pour régler ce souci</p>
                </div>';
            
        }elseif (pg_num_rows($catRes) == 0) {
            echo '
                <div id="stopbar" style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
                <h3 style="text-align:center;">Il N\'Y A PAS ENCORE DE CATEGORIE</h3>
                </div>';
        } else {
            $i = 0;
            while ($row = pg_fetch_array($catRes, null, PGSQL_ASSOC)) {
                $i = $i+1;
                $img = "url('..".$row['chemin_photo']."')";
                
                if((pg_num_rows($catRes)%2 == 1) && ($i ==pg_num_rows($catRes))){
                    echo '
                    <div style="min-height: 451px">
                        <a href="produits.php?idcat='.$row['id_cat'].'">
                            <div class="CatContainer" style="background-image: '.$img.'; width:100%"> 
                                <div class="caption">
                                    <span class="border">'.$row['label_cat'].'</span>
                                </div>
                                <div class="overlay otop">
                                    <div class="text">
                                        <h3 style="color:white">'.$row['label_cat'].'</h3>
                                        <p>'.$row['description_cat'].'</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    ';
                }elseif($i%2 ===1){
                    echo '
                        <div style="min-height: 451px">
                        <a href="produits.php?idcat='.$row['id_cat'].'">
                            <div class="CatContainer" style="background-image: '.$img.';"> 
                                <div class="caption">
                                    <span class="border">'.$row['label_cat'].'</span>
                                </div>
                                <div class="overlay oleft">
                                    <div class="text">
                                        <h3 style="color:white">'.$row['label_cat'].'</h3>
                                        <p>'.$row['description_cat'].'</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        
                    ';
                }elseif($i%2 ===0){
                    echo '
                        <a href="produits.php?idcat='.$row['id_cat'].'">
                            <div class="CatContainer" style="background-image: '.$img.';"> 
                                <div class="caption">
                                    <span class="border">'.$row['label_cat'].'</span>
                                </div>
                                <div class="overlay oright">
                                    <div class="text">
                                        <h3 style="color:white">'.$row['label_cat'].'</h3>
                                        <p>'.$row['description_cat'].'</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        </div>
                    ';
                }
            }

       }
        ?>
        <div class="bgimg-3"></div>

        <?php include ('./template/footer.php'); ?>
        
    </body>
