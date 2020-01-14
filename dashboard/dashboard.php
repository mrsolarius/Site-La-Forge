<?php
$location = basename(__FILE__);
?>
<!DOCTYPE html>
<?php
session_start();
include ('../settings.php');
?>
<html>
    <head>
        <?php include ('./template/head.php'); ?>
    </head>
    <body>
        <?php include ('./template/navbar.php'); ?>
        

        <div class="card topbuttonaction" style="width: 100%;">
            <div class="subcard" style="display: flex; width: 100%;">
                <div class="card statinfo card__dark card__dark--blue">
                    <div class="primary-title">
                        <div class="primary-text">Nombre de client</div>
                        <?php
                        $dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
                        or die('Connexion impossible : ' . pg_last_error());
                        
                        $nbArt = 'select count(*) from client';
                        $nbArtRes = pg_query($nbArt) or die('Échec de la requête : ' . pg_last_error());
                        $nbart = pg_fetch_array($nbArtRes, null, PGSQL_ASSOC);
                        echo'<div class="big primary-text ">'.$nbart['count'].'</div>'
                        ?>
                        
                    </div>
                </div>
                <div class="card statinfo card__dark card__dark--blue">
                    <div class="primary-title">
                        <div class="primary-text">Gain Des Comande</div>
                        <?php
                                               
                        $nbCat = 'select sum(prix_unite*qte_article_facture) from commande inner join composer on composer.id_comende = commande.id_comende';
                        $nbCatRes = pg_query($nbCat) or die('Échec de la requête : ' . pg_last_error());
                        $nbCat = pg_fetch_array($nbCatRes, null, PGSQL_ASSOC);
                        echo'<div class="big primary-text ">'.$nbCat['sum'].'</div>'
                        ?>
                    </div>
                </div>
                <div class="card statinfo card__dark card__dark--blue">
                    <div class="primary-title">
                        <div class="primary-text">Nombre d'article</div>
                        <?php
                                               
                        $nbCat = 'select count(*) from article';
                        $nbCatRes = pg_query($nbCat) or die('Échec de la requête : ' . pg_last_error());
                        $nbCat = pg_fetch_array($nbCatRes, null, PGSQL_ASSOC);
                        echo'<div class="big primary-text ">'.$nbCat['count'].'</div>'
                        ?>
                    </div>
                </div>
                
                <div class="card statinfo card__dark card__dark--blue">
                    <div class="primary-title">
                        <div class="primary-text">Nombre de Categorie</div>
                        <?php
                                               
                        $nbCat = 'select count(*) from categorie';
                        $nbCatRes = pg_query($nbCat) or die('Échec de la requête : ' . pg_last_error());
                        $nbCat = pg_fetch_array($nbCatRes, null, PGSQL_ASSOC);
                        echo'<div class="big primary-text ">'.$nbCat['count'].'</div>'
                        ?>
                    </div>
                </div>
                <div class="card statinfo card__dark card__dark--blue">
                    <div class="primary-title">
                        <div class="primary-text">Stock Total</div>
                        <?php
                        
                        $sumArt = 'select sum(stock_article) from article';
                        $sumRes = pg_query($sumArt) or die('Échec de la requête : ' . pg_last_error());
                        $sumArt = pg_fetch_array($sumRes, null, PGSQL_ASSOC);
                        echo'<div class="big primary-text ">'.$sumArt['sum'].'</div>'
                        ?>
                    </div>
                </div>
                <div class="card statinfo card__dark card__dark--blue">
                    <div class="primary-title">
                        <div class="primary-text">Valeur du Stock</div>
                        <?php
                        
                        $prixtot = 'select sum(stock_article*prix_article) from article';
                        $prixtotres = pg_query($prixtot) or die('Échec de la requête : ' . pg_last_error());
                        $prix = pg_fetch_array($prixtotres, null, PGSQL_ASSOC);
                        echo'<div class="big primary-text ">'.$prix['sum'].'</div>'
                        ?>
                    </div>
                </div>
            </div>
        </div>

        

    </div>

</div>
</body>
</html>
