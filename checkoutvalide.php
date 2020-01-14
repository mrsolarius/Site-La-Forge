<?php
$location = basename(__FILE__);
include ($_SERVER['DOCUMENT_ROOT'] . '/settings.php');

$name = filter_input(INPUT_POST, 'name');
$cardNumber = filter_input(INPUT_POST, 'cardNumber');
$cardExpiry = filter_input(INPUT_POST, 'cardExpiry');
$cardCVC = filter_input(INPUT_POST, 'cardCVC');
?>

<head>
    <?php include ('./template/head.php'); ?>
    <link href="css/cartebleu.css" rel="stylesheet" type="text/css"/>
    <link href="css/form.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <?php include ('./template/navbar.php'); ?>
    <?php include ('./template/panier.php'); ?>
    <div style="margin-top: 64px;">
        <div class="articleConteneur" style="margin: auto;display: block;max-width: 500px;">
            <?php
            if ($_SESSION['run'] === true) {
                if ($name != "") {
                    if ($cardNumber != "") {
                        if ($cardExpiry != "") {
                            if ($cardCVC != "") {
                                $dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
                                        or die('Connexion impossible : ' . pg_last_error());
                                $idCli = $_SESSION['idclient'];

                                $insertQ = "Insert into commande (id_client,DATE_COMANDE)values ('" . $idCli . "','" . date("Y-m-d H:i:s") . "') RETURNING id_comende";
                                $idres = pg_query($insertQ) or die('Échec de la requête : ' . pg_last_error());
                                $idcomm = pg_fetch_array($idres, null, PGSQL_ASSOC);

                                $selectQ = "select * from panier inner join article on panier.id_article = article.id_article where id_client =" . $idCli;
                                $selectRes = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
                                while ($ArtRow = pg_fetch_array($selectRes, null, PGSQL_ASSOC)) {
                                    $stock = (int)$ArtRow['stock_article'];
                                    $qte = (int)$ArtRow['qte'];
                                    $res = $stock-$qte;
                                    $update = "update article set stock_article = ".$res." where id_article = ".$ArtRow['id_article'];
                                    pg_query($update) or die('Échec de la requête : ' . pg_last_error());
                                    
                                    $insertQ = "Insert into composer (id_comende,id_article,prix_unite,qte_article_facture) values ('" . $idcomm['id_comende'] . "','" . $ArtRow['id_article'] . "','" . $ArtRow['prix_article'] . "','" . $ArtRow['qte'] . "');";
                                    pg_query($insertQ) or die('Échec de la requête : ' . pg_last_error());

                                    $dropQ = "DELETE FROM  panier where id_article = " . $ArtRow['id_article'] . " and id_client =" . $idCli;
                                    $dropRes = pg_query($dropQ) or die('Échec de la requête : ' . pg_last_error());
                                    
                                    
                                    
                                }
                                echo'
                                        <h1>Votre Comande A Bien était Effectuer</h1>
                                        <p>Vous recevrais bientôt vos articles</p>
                                        ';
                            } else {
                                echo 'ERROR';
                            }
                        } else {
                            echo 'ERROR';
                        }
                    } else {
                        echo '<br><br>ERROR';
                    }
                } else {
                    echo '<br><br>ERROR';
                }
            } else {
                echo'Vous ne pouvez pas repacée comande';
            }
            $_SESSION['run'] = false;
            ?>
        </div>
    </div>
    <?php include ('./template/footer.php'); ?>

</body>