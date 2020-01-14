<?php
$location = basename(__FILE__);
include ($_SERVER['DOCUMENT_ROOT'] . '/settings.php');
?>

<head>
    <?php include ('./template/head.php'); ?>
    <link href="css/cartebleu.css" rel="stylesheet" type="text/css"/>
    <link href="css/form.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <?php include ('./template/navbar.php'); ?>
    <?php include ('./template/panier.php'); ?>
    <table class="shop_table" cellspacing="0">
        <thead>
            <tr>
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
                                ' . $ArtRow['label_article'] . '						
                            </td>
                            <td>
                                <span>'.$ArtRow['prix_article'].'</span>						
                            </td>
                            <td>
                            '. $ArtRow['qte'] .'
                            </td>
                            <td>
                                <span class="Price-amount amount">'.$total.'</span>€</span>						
                            </td>
                        </tr>
                    ';
                }
            }?>
            <tr>
                <td colspan="3">
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

        </tbody>
    </table>
    <div style="margin-top: 64px;">
        <div class="articleConteneur" style="margin: auto;display: block;max-width: 1024px;">
            <form method="post" action="/checkoutstep3.php">
                <?php
                $selectQ = "select * from client where id_client =" . $idCli;
                $selectRes = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
                $Cli = pg_fetch_array($selectRes, null, PGSQL_ASSOC);
                echo '
                <label>Prenoms
                <input type="text" name="Prenom" value="'.$Cli['prenom_client'].'" required=""/>
                </label>
                <label>Noms
                <input type="text" name="Noms" value="'.$Cli['nom_client'].'" required=""/>
                </label>
                <label>EMail
                <input type="email" name="EMail" value="'.$Cli['mail_client'].'" />
                </label>
                <label>Telephone
                <input type="tel" name="Telephone" value="'.$Cli['tel_client'].'" />
                </label>
                <fieldset><h3> Adresse de facturation et de livraison</h3>
                <label>Rue
                <input type="text" name="Rue" value="'.$Cli['rue_client'].'" required=""/>
                </label>
                <label>Ville
                <input type="text" name="Ville" value="'.$Cli['ville_client'].'" required=""/>
                </label>
                <label>Code Postal
                <input type="text" name="Cpostal" value="'.$Cli['cp_client'].'" required=""/>
                </label>
                </fieldset>
                ';?>
                <label style="float: none;">J’ai lu et j’accepte les 
                    <a href="/legal/condition-general-de-vente.php">
                        conditions générales de vente
                    </a>
                </label>
                <div style='float: left;width:30px'><input type="checkbox" name="CG" value="ON" required="" style=""></div>
                <button type="submit" style="display: block;">Comander</button>
            </form>
        </div>
    </div>
    <?php include ('./template/footer.php'); ?>
</body>
