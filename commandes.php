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
        <h1>Mes Commandes</h1>
        <hr style="border: solid 1px;">
            <?php
            if (isset($_SESSION['idclient'])) {
                $idCli = $_SESSION['idclient'];
                $dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
                or die('Connexion impossible : ' . pg_last_error());
                
                $comandeQ = 'select * from commande inner join client on client.id_client =  commande.id_client where client.id_client='.$idCli;
                $comandeRes = pg_query($comandeQ) or die('Échec de la requête : ' . pg_last_error());
                if(pg_num_rows($comandeRes)!=0){
                while ($row = pg_fetch_array($comandeRes, null, PGSQL_ASSOC)) {
                    $totQ = 'select sum(qte_article_facture*prix_unite) from commande inner join composer on composer.id_comende =  commande.id_comende where commande.id_comende='.$row['id_comende'];
                    $totRes = pg_query($totQ) or die('Échec de la requête : ' . pg_last_error());
                    $tot = pg_fetch_array($totRes, null, PGSQL_ASSOC);
                    echo '
                        <div>
                            <div class="primary-title">
                                <div class="primary-text ">Commande du '.$row['date_comande'].'</div>
                                <br>
                                <hr>
                                <div class="secondary-text float-left">Commandé le</div>
                                <div class="secondary-text float-right">'.$row['date_comande'].'</div>
                                <br>
                                <hr>
                                <div class="secondary-text float-left">Livré le</div>
                                <div class="secondary-text float-right">'.$row['date_livraison'].'</div>
                                <br>
                                <hr>
                                <div class="secondary-text float-left">Prix</div>
                                <div class="secondary-text float-right">'.$tot['sum'].'</div>
                                <br>
                                <hr>
                                <div class="actions">
                                    <div class="action-buttons">
                                         <button onclick="location.href=\'recap.php?id='.$row['id_comende'].'\'" class="button modifier" type="button">Afficher La Commande</button>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <hr>
                        </div>';
                }

            }else{
                echo '<div class="primary-title">
                        <div class="primary-text ">Vous n\'avez pas encore passé de commande</div>
                      </div>';
            }
            }
            ?>
        </div>
    </div>

    <?php include ('./template/footer.php'); ?>
</body>