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
    <?php include ('./template/head.php'); ?>
    <link href="css/Nos_couteaux.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <?php include ('./template/navbar.php'); ?>
    <?php include ('./template/panier.php'); ?>
    <div>
    <div class = "articleConteneur" style="flex-wrap: wrap;" >
    <h1>Récaptitulatif de votre Comande</h1>
    <table style="width: 100%" cellspacing="0">
        <thead>
            <tr>
                <th class="product-remove">&nbsp;</th>
                <th class="product-thumbnail">&nbsp;</th>
                <th class="product-name">Produit</th>
                <th class="product-price">Prix</th>
                <th class="product-quantity">Quantité</th>
                <th class="product-subtotal">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $idCli = $_SESSION['idclient'];
            
            $dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
            or die('Connexion impossible : ' . pg_last_error());
            
            if(isset($idCli)){
     
                $selectQ = "select * from panier inner join article on panier.id_article = article.id_article where id_client =" . $idCli;
                $selectRes = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
                while ($ArtRow = pg_fetch_array($selectRes, null, PGSQL_ASSOC)) {

                    $PictQ = 'Select * from photo inner join montrer on montrer.id_photo = photo.id_photo where id_article = ' . $ArtRow['id_article'] . ' LIMIT 1';
                    $PictRes = pg_query($PictQ) or die('Échec de la requête : ' . pg_last_error());
                    $Pict = pg_fetch_array($PictRes, null, PGSQL_ASSOC);
                    
                    $priart = (int)$ArtRow['prix_article'];
                    $qte = (int)$ArtRow['qte'];
                    $total = $qte*$priart;
                    
                    echo '
                        <tr>
                            <td>
                                <a href="/checkout.php?'.addpanier().'&action=remall&pid='.$ArtRow['id_article'].'" class="remove" aria-label="Enlever cet élément">×</a>						
                            </td>
                            <td>
                                <a href="/produit.php?id='.$ArtRow['id_article'].'">
                                    <img class="checkoutimg" width="300" height="376" src="'.$Pict['chemin_photo'].'">
                                </a>						
                            </td>
                            <td>
                                <a href="/produit.php?id='.$ArtRow['id_article'].'">' . $ArtRow['label_article'] . '</a>						
                            </td>
                            <td>
                                <span>'.$ArtRow['prix_article'].'</span>						
                            </td>
                            <td>
                                <div style="width: 100%;height: 100%;">
                                    <div style="width: -moz-fit-content;height: -moz-fit-content;margin: auto;">
                                        <a href="/checkout.php?'.addpanier().'&action=rempanier&pid='.$ArtRow['id_article'].'" class="minus">-</a>
                                        <input class="addarticle" type="number" value="'. $ArtRow['qte'] .'" title="Qté" size="4" pattern="[0-9]*" inputmode="numeric">
                                        <a href="/checkout.php?'.addpanier().'&action=addpanier&pid='.$ArtRow['id_article'].'" class="minus">+</a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="Price-amount amount">'.$total.'</span>€</span>						
                            </td>
                        </tr>
                    ';
                }
            }?>
            <tr>
                <td colspan="5">
                </td>
                <td>
                    <?php
                    if(isset($idCli)){
                        $selectQ = "select sum(qte*prix_article) from panier inner join article on panier.id_article = article.id_article where id_client =" . $idCli;
                        $selectRes = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
                        $total = pg_fetch_array($selectRes, null, PGSQL_ASSOC);
                        echo 'TOTAL : '. $total['sum'];
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="6">
                    <button onclick="location.href='checkoutstep2.php'" class="button modifier" value="Valider La Comande">Valider La Comande</button>	
                </td>
            </tr>

        </tbody>
    </table>
    <div class="bgimg-3"></div>
    </div>
    </div>
    <?php include ('./template/footer.php'); ?>

</body>