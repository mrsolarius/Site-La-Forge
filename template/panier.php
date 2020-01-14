<?php

function addpanier(){
    $resquest = $_SERVER['QUERY_STRING'];
    return $resquest = preg_replace('/(&action=)\w+|(&pid=)\w+|(&show=)\w+/', '', $resquest);
}

$dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
        or die('Connexion impossible : ' . pg_last_error());

$action = filter_input(INPUT_GET, 'action');
$idArt = filter_input(INPUT_GET, 'pid');
if (isset($_SESSION['idclient'])) {
    $idCli = $_SESSION['idclient'];
    if (isset($idCli)) {
        if (isset($action)) {
            if ($action === 'addpanier') {
                if (isset($idArt)) {

                    $selectQ = "Select * from article where id_article = " . $idArt;
                    $selectres = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
                    $art = pg_fetch_array($selectres, null, PGSQL_ASSOC);
                    if ($art['id_article'] == $idArt) {

                        $selectQ = "Select * from panier where id_article = " . $idArt . " and id_client =" . $idCli;
                        $selectres = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
                        $panier = pg_fetch_array($selectres, null, PGSQL_ASSOC);

                        if ($panier['qte'] == "") {
                            $InsertPQ = "Insert into panier (id_article,id_client,qte) values('" . $idArt . "','" . $idCli . "',1);";
                            pg_query($InsertPQ) or die('Échec de la requête : ' . pg_last_error());
                        } elseif (isset($panier['qte']) && isset($art['stock_article'])) {
                            $qte = (int) $panier['qte'] + 1;
                            if ($art['stock_article'] >= $qte) {
                                $InsertPQ = "Update panier set qte=" . $qte . " where id_article = " . $idArt . " and id_client =" . $idCli;
                                pg_query($InsertPQ) or die('Échec de la requête : ' . pg_last_error());
                            }
                        }
                    } else {
                        echo "l'article n'éxiste pas";
                    }
                }
            } elseif ($action == 'rempanier') {
                if (isset($idArt)) {

                    $selectQ = "Select * from article where id_article = " . $idArt;
                    $selectres = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
                    $art = pg_fetch_array($selectres, null, PGSQL_ASSOC);

                    if ($art['id_article'] == $idArt) {
                        $selectQ = "Select * from panier where id_article = " . $idArt . " and id_client =" . $idCli;
                        $selectres = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
                        $panier = pg_fetch_array($selectres, null, PGSQL_ASSOC);

                        if ($panier['qte'] !== "") {
                            if ($panier['qte'] == "1") {
                                $dropQ = "DELETE FROM  panier where id_article = " . $idArt . " and id_client =" . $idCli;
                                $dropRes = pg_query($dropQ) or die('Échec de la requête : ' . pg_last_error());
                            } else {
                                $qte = (int) $panier['qte'] - 1;
                                $InsertPQ = "Update panier set qte=" . $qte . " where id_article = " . $idArt . " and id_client =" . $idCli;
                                pg_query($InsertPQ) or die('Échec de la requête : ' . pg_last_error());
                            }
                        }
                    }
                }
            } elseif ($action == 'remall'){
                $selectQ = "Select * from article where id_article = " . $idArt;
                $selectres = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
                $art = pg_fetch_array($selectres, null, PGSQL_ASSOC);

                if ($art['id_article'] == $idArt) {
                    $dropQ = "DELETE FROM  panier where id_article = " . $idArt . " and id_client =" . $idCli;
                    $dropRes = pg_query($dropQ) or die('Échec de la requête : ' . pg_last_error());
                }
            }
        }
    }
}
?>

<nav id="panier" role="navigation" style="display: none;">
    <?php
    
    $show = filter_input(INPUT_GET, 'show');
    
    if ($show == "t") {
        echo '<script onload="panier();" src="js/panier.js" type="text/javascript"></script>';
    } else {
        echo '<script src="js/panier.js" type="text/javascript"></script>';
    }
    if (isset($_SESSION['idclient'])) {
        echo '<h1>Mon Panier</h1>';
        $idCli = $_SESSION['idclient'];
        
        $selectQ = "select * from panier inner join article on panier.id_article = article.id_article where id_client =" . $idCli;
        $selectRes = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
        while ($ArtRow = pg_fetch_array($selectRes, null, PGSQL_ASSOC)) {

            $PictQ = 'Select * from photo inner join montrer on montrer.id_photo = photo.id_photo where id_article = ' . $ArtRow['id_article'] . ' LIMIT 1';
            $PictRes = pg_query($PictQ) or die('Échec de la requête : ' . pg_last_error());
            $Pict = pg_fetch_array($PictRes, null, PGSQL_ASSOC);

            echo '
            <div class="item">
                <a href="/produit.php?id='.$ArtRow['id_article'].'">
                <img src="../' . $Pict['chemin_photo'] . '"/>
                </a>
                <div class="infoContain">
                    <p class="noms">' . $ArtRow['label_article'] . '</p>
                    <div class="pricecontain">
                        <span class="pprix">' . $ArtRow['prix_article'] . '</span>
                        <span class="nombre">(x' . $ArtRow['qte'] . ')</span>
                    </div>
                    <div class="qte">
                        <a class="pbutton" href=\'?'. addpanier().'&action=addpanier&pid=' . $ArtRow['id_article'] . '&show=t\'><span>+</span></a>
                        <span>Qte ' . $ArtRow['qte'] . '</span>
                        <a class="pbutton" href=\'?'. addpanier().'&action=rempanier&pid=' . $ArtRow['id_article'] . '&show=t\'><span>-</span></a>
                    </div>            
                </div>
            </div>';
        }
        echo  '<a class="pross" href="/checkout.php">Passer au paiement</a>';
    } else {
        echo '<h1>Connectez vous pour commencer à remplir votre panier</h1>';
    }
    ?>
   
    


</nav>
