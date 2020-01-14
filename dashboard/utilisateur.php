<?php
$location = basename(__FILE__);
?>
<!DOCTYPE html>
<?php
include ('../settings.php');
?>

<html>
    <head>
        <?php include ('./template/head.php'); ?>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css" rel="stylesheet" type="text/css"/>
        <?php
        if(isset($_GET['search'])){
            $qresquest = "select * from client where nom_client='".$_GET['search']."';";
        }else{
            switch ($_GET['order']){
                    case'name':
                        $qresquest = "select * from client order by nom_client";
                        break;
                    case 'surname':
                        $qresquest = "select * from client order by prenom_client";
                        break;
                    case 'admin':
                        $qresquest = "select * from client order by administrateur desc";
                        break;
                    default :
                        $qresquest = "select * from client";
                        break;
                
                    
            }
        }
        
            
        
        ?>
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
                        echo'<div class="big primary-text ">' . $nbart['count'] . '</div>'
                        ?>

                    </div>
                </div>
                <div class="card statinfo card__dark card__dark--blue">
                    <div class="primary-title">
                        <div class="primary-text">Nombre d'administrateur</div>
                        <?php
                        $nbCat = 'select count(*) from client where administrateur = true';
                        $nbCatRes = pg_query($nbCat) or die('Échec de la requête : ' . pg_last_error());
                        $nbCat = pg_fetch_array($nbCatRes, null, PGSQL_ASSOC);
                        echo'<div class="big primary-text ">' . $nbCat['count'] . '</div>'
                        ?>
                    </div>
                </div>
                <div class="card statinfo card__dark card__dark--blue">
                    <div class="primary-title">
                        <div class="primary-text">Nombre de consommateur</div>
                        <?php
                        $nbCat = 'select count(distinct client.id_client) from client inner join commande on commande.id_client = client.id_client';
                        $nbCatRes = pg_query($nbCat) or die('Échec de la requête : ' . pg_last_error());
                        $nbCat = pg_fetch_array($nbCatRes, null, PGSQL_ASSOC);
                        echo'<div class="big primary-text ">' . $nbCat['count'] . '</div>'
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card topbuttonaction" style="width: 100%;">
            <div style="z-index: 1;" class="button drop modifier" type="button">Trier par
                <div>
                    <ul>
                        <li><a href="?order=">Pertinance</a></li> 
                        <li><a href="?order=name">Nom</a></li>
                        <li><a href="?order=surname">Prenom</a></li>
                        <li><a href="?order=admin">Admin</a></li>  
                    </ul>
                </div>
            </div>
            <div style="display: inline-block;position: relative;float: right;">
                <div>
                    <form method="get" action="./utilisateur.php">
                        <input id="searchinput" name="search" type="search">
                        <button id="search" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card topbuttonaction" style="width: 100%;">
            <table style="width: 100%" border="0" cellpadding="0">
                <thead>
                    <tr>
                        <th>Supr</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Admin</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        
                        $resultQ = pg_query($qresquest) or die('Échec de la requête : ' . pg_last_error());
                        if(pg_num_rows($resultQ)!=0){
                        while ($cli = pg_fetch_array($resultQ, null, PGSQL_ASSOC)){
                            ?>
                        <tr>
                            <td>
                                <form method="post" action="action/remUser.php">
                                    <input type="hidden" name="id" value="<?php echo $cli['id_client']; ?>">
                                    <button  type="submit"class="remove" aria-label="Enlever cet élément">×</button>
                                </form>
                                </td>
                            <td><?php echo $cli['nom_client']?></td>
                            <td><?php echo $cli['prenom_client']?></td>
                            <td>
                                <?php
                                if($cli['administrateur'] === "t"){
                                    echo 'Oui';
                                }else{
                                    echo 'Non';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if($cli['administrateur'] === "t"){
                                    
                                    ?>
                                        <form method="post" action="action/toUsers.php">
                                            <input type="hidden" name="id" value="<?php echo $cli['id_client']?>">
                                            <button type="submit" class="button supprimer">Passer Utilisateur</button>
                                        </form><?php
                                }else{
                                    ?>
                                     <form method="post" action="action/toAdmin.php">
                                        <input type="hidden" name="id" value="<?php echo $cli['id_client']?>">
                                        <button type="submit" class="button valider">Passer Admin</button>
                                    </form><?php
                                }
                                ?>
                                
                            </td>
                        </tr>
                        <?php }?>
                </tbody>
            </table>
            <?php }
            else{
                echo '<h3> Pas de résultat</h3>';
            }
            ?>
        </div>
    </div>
</body>
</html>
