<?php
$location = basename(__FILE__);
include ($_SERVER['DOCUMENT_ROOT'] . '/settings.php');
?>

<head>
    <meta charset="UTF-8">
    <title>Mon Profile</title>
    <?php include ('./template/head.php');?>
    <link href="css/form.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <?php include ('./template/navbar.php');?>
    <?php include ('./template/panier.php'); ?>
    <div style="margin-top: 64px;">
    <div class="articleConteneur" style="margin: auto;display: block;max-width: 500px;">        
            <?php
            if (isset($_SESSION['idclient'])) {
                if(isset($_GET['id'])){
                    $dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
                    or die('Connexion impossible : ' . pg_last_error());
                    
                    $selectQ = "select * from commande inner join composer on commande.id_comende = composer.id_comende inner join article on article.id_article = composer.id_article where composer.id_comende =".$_GET['id'];
                    $selectRes = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
                    if(pg_num_rows($selectRes)!=0){?>
                        <h1>Ma Commande</h1>
                        <hr style="border: solid 1px;">
                        <table style="width: 100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="product-thumbnail">&nbsp;</th>
                                <th class="product-name">Produit</th>
                                <th class="product-price">Prix</th>
                                <th class="product-quantity">Quantité</th>
                                <th class="product-subtotal">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($ArtRow = pg_fetch_array($selectRes, null, PGSQL_ASSOC)) {

                            $PictQ = 'Select * from photo inner join montrer on montrer.id_photo = photo.id_photo where id_article = ' . $ArtRow['id_article'] . ' LIMIT 1';
                            $PictRes = pg_query($PictQ) or die('Échec de la requête : ' . pg_last_error());
                            $Pict = pg_fetch_array($PictRes, null, PGSQL_ASSOC);

                            $priart = (int)$ArtRow['prix_unite'];
                            $qte = (int)$ArtRow['qte_article_facture'];
                            $total = $qte*$priart;

                            echo '
                                <tr>
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
                                        <span>'. $ArtRow['qte_article_facture'] .'</span>
                                    </td>
                                    <td>
                                        <span class="Price-amount amount">'.$total.'</span>€</span>						
                                    </td>
                                </tr>
                            ';
                        }
                            ?>
                            <tr>
                                <td colspan="4">
                                </td>
                                <td>
                                    <?php
                                        $selectQ = "select sum(prix_unite*qte_article_facture) from commande inner join composer on commande.id_comende = composer.id_comende where composer.id_comende =".$_GET['id'];
                                        $selectRes = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
                                        $total = pg_fetch_array($selectRes, null, PGSQL_ASSOC);
                                        echo 'TOTAL : '. $total['sum'];
                                    ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                            
                            
                            <?php
                        }else{
                            echo '<h1>Mais arrêtez de modifier l\'url, l\'id de la commande est inconnue</h1>';
                        }
                }else{
                     echo '<h1>L\'id de la commande est inconnue</h1>';
                }
            }else{
                echo '<h1>Veuillez vous connecter</h1>';
            }
            ?>

 </div>
                            </div>
    <?php include ('./template/footer.php'); ?>
</body>