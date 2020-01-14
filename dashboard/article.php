<<?php
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
        <div id="mainModal" class="modalbg" style="background-image: url(&quot;Images/SemiEscl.png&quot;); display: block;">
            <div id="modalpanel" class="modalpanel visible">
                <div class="modalcontents">
                    <?php
                    if (isset($_GET['action'])) {
                        $dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
                        or die('Connexion impossible : ' . pg_last_error());
                        switch ($_GET['action']) {
                            case 'success':
                                switch ($_GET['type']){
                                    case 'addCataddArt':
                                        echo '
                                            <h1>Votre Article ainsi que votre catégorie ont bien été ajoutés</h1>
                                            <p>Votre article et sa catégorie sont désormais en ligne 👏</p>
                                            <button onclick="div_show();"class="button valider" type="button">Continuer</button>'
                                        ;
                                        break;
                                    case 'delArt':
                                        echo '
                                            <h1>Votre Article a bien été Supprimé</h1>
                                            <p>C\'est bon, cet article a disparu ouf... Allez donc vous prendre un café ☕</p>
                                            <button onclick="div_show();"class="button valider" type="button">Continuer</button>'
                                        ;
                                        break;
                                    case 'addArt':
                                        echo '
                                            <h1>Votre Article à bien été ajouté</h1>
                                            <p>L\'ajout de votre article a bien abouti, il est maintenant en ligne 👏</p>
                                            <button onclick="div_show();"class="button valider" type="button">Continuer</button>'
                                        ;
                                        break;
                                    case 'addcat':
                                        echo '
                                            <h1>Votre catégorie a bien été ajouté</h1>
                                            <p>L\'ajout de votre catégorie a bien abouti, elle et maintenant en ligne 👏</p>
                                            <button onclick="div_show();"class="button valider" type="button">Continuer</button>';
                                        break;
                                    case 'delbulk':
                                        echo '
                                            <h1>Vos '.$_GET['nombre'].' Article ont tous été supprimé</h1>
                                            <p>Impeccable vous avez bien supprimé '.$_GET['nombre'] .' vos articles</p>
                                            <button onclick="div_show();"class="button valider" type="button">SUPER !</button>'
                                            ;
                                        break;
                                    case 'delcat':
                                        echo '
                                            <h1>Votre Catégorie a bien été supprimer</h1>
                                            <p>C\'est tout bon, la catégorie ainsi que tous les articles de celle-ci ont bien été supprimer. C\'est bon vous pouvez souffler... Allez prendre un café ☕</p>
                                            <button onclick="div_show();"class="button valider" type="button">SUPER !</button>'
                                            ;
                                        break;
                                    case 'editart':
                                        echo '
                                            <h1>Votre Article a bien était modifier</h1>
                                            <p>C\'est tout bon toute à fonctioner taper m\'en 5 😉 👏</p>
                                            <button onclick="div_show();"class="button valider" type="button">Impec !</button>'
                                            ;
                                        break;
                                    case 'editcat':
                                        echo '
                                            <h1>Votre Categorie a bien était modifier</h1>
                                            <p>C\'est tout bon toute à fonctioner taper m\'en 5 😉 👏</p>
                                            <button onclick="div_show();"class="button valider" type="button">Impec !</button>'
                                            ;
                                        break;
                                    case 'defaut':
                                        echo '
                                            <h1>Votre action est un succès</h1>
                                            <p>L\'action que vous venez d\'effectuer et un succès (apparament)</p>
                                            <button onclick="div_show();"class="button valider" type="button">SUPER !</button>'
                                        ;
                                    
                                        
                                }
                                break;
                            case 'del':
                                
                                if(isset($_GET['artnom'])){
                                    if(isset($_GET['id'])){
                                        echo '
                                            <h1>Confirmer la suppression</h1>
                                            <p>Êtes vous sûr de bien vouloir supprimer l\'article : ' . $_GET['artnom'] . '</p>
                                            <form method="post" action="action/delArt.php">
                                            <input name="id" type="hidden" value="'.$_GET['id'].'">
                                            <div class="action-buttons" >
                                                <button type="submit" class="button valider"  type="button">Oui</button>
                                                <button onclick="div_show();"class="button supprimer" type="button">Non</button>
                                            </div>
                                            </form>';
                                    }else{
                                         echo '
                                            <h1>La Supprssion et annuler</h1>
                                            <p>En effet, notre système de détection d\'erreur ne connais pas l\id de cette article il ne peut donc pas le supprimer</p>
                                            <div class="action-buttons" >
                                                <button onclick="div_show();"class="button valider" type="button">Continuer</button>
                                            </div>';
                                    }
                                
                                }else{
                                    echo '
                                            <h1>La Suppression et annulée</h1>
                                            <p>En effet, nous ne voulons pas supprimer un article dont vous ne connaisser pas le nom</p>
                                            <div class="action-buttons" >
                                                <button onclick="div_show();"class="button valider" type="button">Continuer</button>
                                            </div>';
                                }
                                break;
                            case 'addcat':
                                
                                echo '
                                    <form method="post" action="action/addCat.php" enctype="multipart/form-data">
                                        <h1>Ajouter Une Nouvelle Catégorie</h1>
                                        <label><g>Nom de la catégorie</g></label>
                                        <input id="nomCat" type="text" name="nomCat" required/>
                                        
                                        <label><g>Description de la catégorie</g></label>
                                        <textarea name="desCat" rows="4" cols="20"></textarea>
                                        
                                        <label><g>Ajouter une image à la catégorie</g></label>
                                        <input id="imgCat" type="file" name="imgCat" accept="image/x-png,image/gif,image/jpeg,.jpeg,.jpg" required/>
                                        
                                        <label><g>Description de l\'image</g></label>
                                        <textarea name="altImgCat" rows="2" cols="20"></textarea>
                                        
                                        <div class="action-buttons" >
                                            <button type="submit" class="button valider">Envoyer</button>
                                            <button onclick="div_show();"class="button supprimer" type="button">Annuler</button>
                                        </div>
                                    </form>
                                        ';
                                break;
                            case 'addart':
                                                               
                                echo '
                                    <form method="post" action="action/addArticle.php" enctype="multipart/form-data">
                                        <h1>Ajouter un nouvel article</h1>
                                        <label><g>Nom de l\'article</g></label>
                                        <input type="text" name="nomArt" value="" required/>
                                        
                                        <label><g>Ajouter Un Catégorie</g></label>
                                        <group class="inline-radio">
                                        <div><input id="oui" type="radio" name="addCat" value="oui"><label>Oui</label></div>
                                        <div><input id="non" type="radio" name="addCat" checked="" value="non"><label>Non</label></div>
                                        </group>
                                        
                                        <fieldset id="addcat" class="removablefiled"style="display:none">
                                        <label><g>Nom de la catégorie</g></label>
                                        <input id="nomCat" type="text" name="nomCat"/>
                                        
                                        <label><g>Description de la categorie</g></label>
                                        <textarea name="desCat" rows="4" cols="20"></textarea>
                                        
                                        <label><g>Ajouter une image à la catégorie</g></label>
                                        <input id="imgCat" type="file" name="imgCat" accept="image/x-png,image/gif,image/jpeg,.jpeg,.jpg"/>
                                        
                                        <label><g>Description de l\'image</g></label>
                                        <textarea name="altImgCat" rows="2" cols="20"></textarea>
                                        </fieldset>
                                        
                                        
                                        <group class="inline-input">
                                            <div>
                                                <label><g>Stock</g></label>
                                                <input type="number" name="stockArt" value="" required/>
                                            </div>
                                            
                                            <div style="margin-left: 50px;">
                                                <label><g>Prix</g></label>
                                                <input type="number" name="prixArt" value="" required/>
                                            </div>
                                            
                                            <div id="selectcat" style="margin-left: 50px;">
                                                <label><g>Choisir La Catégorie</g></label>
                                                <select id="ArtCat" name="ArtCat">';
                                
                                $CatQuery = 'Select * from categorie';
                                $catRes = pg_query($CatQuery) or die('Échec de la requête : ' . pg_last_error());
                                if (!$catRes) {
                                    echo "<option>Une erreur s'est produite</option>";
                                }
                                if (pg_num_rows($catRes) == 0) {
                                    echo "<option>Veuillez ajouter une catégorie</option>";
                                } else {
                                    while ($row = pg_fetch_array($catRes, null, PGSQL_ASSOC)) {
                                        echo '<option value="'.$row['id_cat'].'">'.$row['label_cat'].'</option>';
                                    }
                                }

                                echo '          </select>
                                            </div>   
                                        
                                        </group>
                                        
                                        
                                        <label><g>Description</g></label>
                                        <textarea name="descriptionArt" rows="6" cols="20"></textarea>
                                        
                                        <label><g>Ajouter des images à l\'article</g></label>
                                        
                                        <input type="file" name="imgArt[]" value="" multiple required/>
                                        <div class="action-buttons" >
                                            <button type="submit" class="button valider">Envoyer</button>
                                            <button onclick="div_show();"class="button supprimer" type="button">Annuler</button>
                                        </div>
                                       

                                    </form>
                                    <script>
                                    document.getElementById("oui").addEventListener("click", function(){
                                        document.getElementById("addcat").style.display="block";
                                        document.getElementById("selectcat").style.display="none";
                                        document.getElementById("nomCat").required=true;
                                        document.getElementById("imgCat").required=true;
                                        document.getElementById("ArtCat").required=false;
                                        
                                    });
                                    document.getElementById("non").addEventListener("click", function(){
                                        document.getElementById("addcat").style.display="none";
                                        document.getElementById("selectcat").style.display="block";
                                        document.getElementById("nomCat").required=false;
                                        document.getElementById("imgCat").required=false;
                                        document.getElementById("ArtCat").required=true;
                                    }); 
                                    </script>
                                    ';
                                    
                                break;
                            case 'delbulk':
                                
                                $ArtQ = 'Select * from article inner join categorie on article.id_cat = categorie.id_cat';
                                $ArtRes = pg_query($ArtQ) or die('Échec de la requête : ' . pg_last_error());
                                if (!$ArtRes) {
                                    echo "<h1>Impossible de récupérer la liste des articles</h1>";
                                } else {
                                    
                                
                                    echo
                                    '<h1>Confirmer la suppression</h1>
                                     <p>Veuillez cocher les cases pour supprimer les articles</p>
                                        <form action="action/delbulk.php" method="POST">
                                            <table border="0" cellpadding="5">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                        Votre Selection
                                                        </th>
                                                        <th>Nom Article </th>
                                                        <th>Catégorie</th>
                                                        <th>Stock</th>
                                                        <th>Prix</th>
                                                        </label>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                    while ($ArtRow = pg_fetch_array($ArtRes, null, PGSQL_ASSOC)) {
                                        echo '
                                                <tr>
                                                    <th>
                                                    <label class="check-container">
                                                    <input class="float-right" type="checkbox" name="id[]" value="'.$ArtRow['id_article'].'">
                                                    <span class="checkmark"></span>
                                                    </th>
                                                    <th>'.$ArtRow['label_article'].'</th>
                                                    <th>'.$ArtRow['label_cat'].'</th>
                                                    <th>'.$ArtRow['stock_article'].'</th>
                                                    <th>'.$ArtRow['prix_article'].'</th>
                                                    </label>
                                                </tr>';
                                        }
                                        echo '
                                            </tbody>
                                        </table>
                                        
                                    <div class="action-buttons" >
                                        <button type="submit" class="button valider"  type="button">Supprimer</button>
                                        <button onclick="div_show();"class="button supprimer" type="button">Annuler</button>
                                        
                                    </div>
                                    <p>Attention Cette Action et irreversible</p>
                                    </form>';
                                            
                                    }
                                    
                                    
                                break;
                            case 'delcat':
                                echo '
                                    <h1>Supprimer une catégorie</h1>
                                    <form action="action/delCat.php" method="POST">
                                    <div id="selectcat" style="margin-left: 50px;">
                                        <label><g>Choisir la catégorie à supprimer</g></label>
                                    <select id="ArtCat" name="ArtCat" required>';
                                $CatQuery = 'Select * from categorie';
                                $catRes = pg_query($CatQuery) or die('Échec de la requête : ' . pg_last_error());
                                if (!$catRes) {
                                    echo "<option>Une erreur s'est produite</option>";
                                }
                                if (pg_num_rows($catRes) == 0) {
                                    echo "<option>Veuillez ajouter une catégorie</option>";
                                } else {
                                    while ($row = pg_fetch_array($catRes, null, PGSQL_ASSOC)) {
                                        echo '<option value="'.$row['id_cat'].'">'.$row['label_cat'].'</option>';
                                    }
                                }
                                echo '
                                    </select>
                                    </div>
                                    <div class="action-buttons" >
                                        <button type="submit" class="button supprimer"  type="button">Supprimer</button>
                                        <button onclick="div_show();"class="button modifier" type="button">Annuler</button>
                                        
                                    </div>
                                    </form>';
                                
                                break;
                            case 'choosecat':
                                 echo '
                                    <h1>Choisir une catégorie</h1>
                                    <form action="Article.php" method="get">
                                    <input name="action" type="hidden" value="editcat">
                                    <div id="selectcat" style="margin-left: 50px;">
                                        <label><g>Choisir la catégorie à éditer</g></label>
                                    <select id="ArtCat" name="ArtCat" required>';
                                $CatQuery = 'Select * from categorie';
                                $catRes = pg_query($CatQuery) or die('Échec de la requête : ' . pg_last_error());
                                if (!$catRes) {
                                    echo "<option>Une erreur s'est produite</option>";
                                }
                                if (pg_num_rows($catRes) == 0) {
                                    echo "<option>Veuillez ajouter une catégorie</option>";
                                } else {
                                    while ($row = pg_fetch_array($catRes, null, PGSQL_ASSOC)) {
                                        echo '<option value="'.$row['id_cat'].'">'.$row['label_cat'].'</option>';
                                    }
                                }
                                echo '
                                    
                                    </select>
                                    </div>
                                    <div class="action-buttons" >
                                        <button type="submit" class="button modifier"  type="button">Modifier</button>
                                        <button onclick="div_show();"class="button supprimer" type="button">Anuler</button>
                                        
                                    </div>
                                    </form>';
                                
                                break;
                            case 'editcat':
                                if(isset($_GET['ArtCat'])){
                                    $selectQ = "Select * from categorie where id_cat = ".$_GET['ArtCat'];
                                    $selectRes = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());                                   
                                    if (pg_num_rows($selectRes) == 0) {
                                        echo '
                                            <h1>Une erreur s\'est produite</h1>
                                            <p>En effet, notre système de détection d\'erreur a remarqué que l\'id de la catégorie n\'existait pas dans la base de donnée</p>
                                            <p>Je vous invite à ne pas modifier l\'url pour eviter ce genre d\'erreur</p>
                                            <div class="action-buttons" >
                                                <button onclick="div_show();"class="button valider" type="button">Ok</button>
                                            </div>';
                                 
                                    }else{
                                        $cat = pg_fetch_array($selectRes, null, PGSQL_ASSOC);
                                        echo '
                                             <h1>Modifier Une Catégorie</h1>
                                            <form action="action/editeCat.php" method="post">
                                                <label><g>Nom de la catégorie</g></label>
                                                <input name="IdCat" type="hidden" value="'.$_GET['ArtCat'].'">
                                                <input type="text" name="nomCat" value ="'.$cat['label_cat'].'"/>

                                                <label><g>Description de la catégorie</g></label>
                                                <textarea name="desCat" rows="4" cols="20">'.$cat['description_cat'].'</textarea>
                                            </div>
                                            <div class="action-buttons" >
                                                <button type="submit" class="button modifier"  type="button">Modifier</button>
                                                <button onclick="div_show();"class="button supprimer" type="button">Annuler</button>

                                            </div>
                                        </form>';
                                    }
                                }
                                
                                break;
                            case 'edite':
                                if(isset($_GET['id'])){
                                    $selectQ = "Select * from article where id_article = ".$_GET['id'];
                                    $selectRes = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());                                   
                                    if (pg_num_rows($selectRes) == 0) {
                                        echo '
                                            <h1>Une erreur c\'est produite</h1>
                                            <p>En effet, notre système de détection d\'erreur à remarquer que l\'id de l\'article n\'existait pas dans la base de donnée</p>
                                            <p>Je vous invite à ne pas modifier l\'url pour eviter ce genre d\'erreur</p>
                                            <div class="action-buttons" >
                                                <button onclick="div_show();"class="button valider" type="button">Ok</button>
                                            </div>';
                                    }else{
                                        $art = pg_fetch_array($selectRes, null, PGSQL_ASSOC);
                                        $prix = (int)$art['prix_article'];
                                        echo '
                                            <form method="post" action="action/editeArticle.php">
                                                <h1>Modifier l\'article</h1>
                                                <input name="IdArt" type="hidden" value="'.$_GET['id'].'">
                                                <label><g>Nom de l\'article</g></label>
                                                <input type="text" name="nomArt" value="'.$art['label_article'].'" required/>
                                                
                                                <group class="inline-input">
                                                    <div>
                                                        <label><g>Stock</g></label>
                                                        <input type="number" name="stockArt" value="'.$art['stock_article'].'" required/>
                                                    </div>

                                                    <div style="margin-left: 50px;">
                                                        <label><g>Prix</g></label>
                                                        <input type="number" name="prixArt" value="'.$prix.'" required/>
                                                    </div>

                                                    <div id="selectcat" style="margin-left: 50px;">
                                                        <label><g>Choisir La Catégorie</g></label>
                                                        <select id="ArtCat" name="ArtCat">';

                                        $CatQuery = 'Select * from categorie';
                                        $catRes = pg_query($CatQuery) or die('Échec de la requête : ' . pg_last_error());
                                        if (!$catRes) {
                                            echo "<option>Une erreur s'est produite</option>";
                                        }
                                        if (pg_num_rows($catRes) == 0) {
                                            echo "<option>Veuillez ajouter une catégorie</option>";
                                        } else {
                                            while ($row = pg_fetch_array($catRes, null, PGSQL_ASSOC)) {
                                                if($row['id_cat']==$art['id_cat']){
                                                    echo '<option selected="selected" value="'.$row['id_cat'].'">'.$row['label_cat'].'</option>';
                                                }else{
                                                    echo '<option value="'.$row['id_cat'].'">'.$row['label_cat'].'</option>';
                                                }
                                                
                                            }
                                        }

                                        echo '          </select>
                                                    </div>   

                                                </group>


                                                <label><g>Description</g></label>
                                                <textarea name="descriptionArt" rows="6" cols="20">'.$art['desc_article'].'</textarea>

                                                <div class="action-buttons" >
                                                    <button type="submit" class="button valider">Envoyer</button>
                                                    <button onclick="div_show();"class="button supprimer" type="button">Annuler</button>
                                                </div>
                                            </form>';
                                
                                    }
                                }else{
                                    echo '
                                            <h1>L\'edition de l\'article et anuler</h1>
                                            <p>En effet, notre système de détection d\'erreur ne connais pas l\'id de cet article il ne peut donc pas l\'éditer</p>
                                            <div class="action-buttons" >
                                                <button onclick="div_show();"class="button valider" type="button">Ok</button>
                                            </div>';
                                }
                                break;
                            default :
                                echo 'Il y a une erreur <button onclick="div_show();"class="button supprimer float-right" type="button">retour</button>';
                        }
                        
                    }
                    
                    ?>
                    
                    
                </div>
            </div>
        </div>
        
        <div class="card topbuttonaction" style="width: 100%;">
            <div class="action-buttons" >
                <button onclick="location.href='?action=addart'" class="button valider"  type="button">Ajouter un Article</button>
                <button onclick="location.href='?action=addcat'" class="button valider"  type="button">Ajouter une Catégorie</button>
                <button onclick="location.href='?action=choosecat'" class="button modifier"  type="button">Modifier une Catégorie</button>
                <button onclick="location.href='?action=delbulk'"class="button supprimer" type="button">Supprimer plusieurs Articles</button>
                <button onclick="location.href='?action=delcat'"class="button supprimer" type="button">Supprimer une catégorie</button>
            </div>
        </div>
        <div class="card topbuttonaction" style="width: 100%;">
            <div class="subcard" style="display: flex; width: 100%;">
                <div class="card statinfo card__dark card__dark--blue">
                    <div class="primary-title">
                        <div class="primary-text">Nombre d'Article</div>
                        <?php
                        $dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
                        or die('Connexion impossible : ' . pg_last_error());
                        
                        $nbArt = 'select count(*) from article';
                        $nbArtRes = pg_query($nbArt) or die('Échec de la requête : ' . pg_last_error());
                        $nbart = pg_fetch_array($nbArtRes, null, PGSQL_ASSOC);
                        echo'<div class="big primary-text ">'.$nbart['count'].'</div>'
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
            <div class="subcard" style="display: flex; width: 100%;">
                <div class="card subcard">
                    <div class="primary-title">
                    <div class="primary-text">Article en stock</div>
                    </div>
                    <br>
                    <?php
                    $dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
                    or die('Connexion impossible : ' . pg_last_error());
                    
                    $ArtQ = 'Select * from article inner join categorie on article.id_cat = categorie.id_cat where stock_article > 0';
                    $ArtRes = pg_query($ArtQ) or die('Échec de la requête : ' . pg_last_error());
                    if (!$ArtRes) {
                        echo "<div>Aucun produit n'est encore ajouté</div>";
                    } else {
                        while ($ArtRow = pg_fetch_array($ArtRes, null, PGSQL_ASSOC)) {
                            $PictQ = 'Select * from photo inner join montrer on montrer.id_photo = photo.id_photo where id_article = '.$ArtRow['id_article'].' LIMIT 1';
                            $PictRes = pg_query($PictQ) or die('Échec de la requête : ' . pg_last_error());
                            $Pict = pg_fetch_array($PictRes, null, PGSQL_ASSOC);
                            echo '
                                <div class="card">
                                    <div class="media media--16-9"> <img src="'.$Pict['chemin_photo'].'" alt="" width="640" height="426"> </div>
                                    <div class="primary-title">
                                        <div class="primary-text ">'.$ArtRow['label_article'].'</div>
                                        <br>
                                        <hr>
                                        <div class="secondary-text float-left">Cathegorie</div>
                                        <div class="secondary-text float-right">'.$ArtRow['label_cat'].'</div>
                                        <br>
                                        <hr>
                                        <div class="secondary-text float-left">Stock</div>
                                        <div class="secondary-text float-right">'.$ArtRow['stock_article'].'</div>
                                        <br>
                                        <hr>
                                        <div class="secondary-text float-left">Prix</div>
                                        <div class="secondary-text float-right">'.$ArtRow['prix_article'].'</div>
                                        <br>
                                        <hr>
                                    </div>
                                    <div class="actions">
                                        <div class="action-buttons">

                                            <div class="button drop modifier" type="button">Modifier
                                                <div>
                                                <ul>
                                                    <li><a href="?id='.$ArtRow['id_article'].'&action=edite">Article</a></li>
                                                    <li><a href="?id='.$ArtRow['id_article'].'&action=stock">Stock</a></li>
                                                    <li><a href="?id='.$ArtRow['id_article'].'&action=prix">Prix</a></li>  
                                                </ul>
                                                </div>
                                            </div>
                                            </a>
                                            <button onclick="location.href=\'?id='.$ArtRow['id_article'].'&action=del&artnom='.$ArtRow['label_article'].'\'" class="button supprimer" type="button">Supprimer</button>
                                        </dv>
                                    </div>
                                </div>
                                </div><br>';
                        }
                    }
                    ?>
                </div>
        <div class="card subcard">
            <div class="primary-title">
                <div class="primary-text">Article épuisé</div>
                <br>
                <?php
                    $dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
                    or die('Connexion impossible : ' . pg_last_error());
                    
                    $ArtQ = 'Select * from article inner join categorie on article.id_cat = categorie.id_cat where stock_article < 0';
                    $ArtRes = pg_query($ArtQ) or die('Échec de la requête : ' . pg_last_error());
                    if (pg_num_rows($ArtRes)===0) {
                        echo "<div>Aucun produit n'est épuisé</div>";
                    } else {
                        while ($ArtRow = pg_fetch_array($ArtRes, null, PGSQL_ASSOC)) {
                            $PictQ = 'Select * from photo inner join montrer on montrer.id_photo = photo.id_photo where id_article = '.$ArtRow['id_article'].' LIMIT 1';
                            $PictRes = pg_query($PictQ) or die('Échec de la requête : ' . pg_last_error());
                            $Pict = pg_fetch_array($PictRes, null, PGSQL_ASSOC);
                            echo '
                                <div class="card">
                                    <div class="media media--16-9"> <img src="'.$Pict['chemin_photo'].'" alt="" width="640" height="426"> </div>
                                    <div class="primary-title">
                                        <div class="primary-text ">'.$ArtRow['label_article'].'</div>
                                        <br>
                                        <hr>
                                        <div class="secondary-text float-left">Cathegorie</div>
                                        <div class="secondary-text float-right">'.$ArtRow['label_cat'].'</div>
                                        <br>
                                        <hr>
                                        <div class="secondary-text float-left">Stock</div>
                                        <div class="secondary-text float-right">'.$ArtRow['stock_article'].'</div>
                                        <br>
                                        <hr>
                                        <div class="secondary-text float-left">Prix</div>
                                        <div class="secondary-text float-right">'.$ArtRow['prix_article'].'</div>
                                        <br>
                                        <hr>
                                    </div>
                                    <div class="actions">
                                        <div class="action-buttons">

                                            <div class="button drop modifier" type="button">Modifier
                                                <div>
                                                <ul>
                                                    <li><a href="?id='.$ArtRow['id_article'].'&action=edite">Article</a></li>
                                                    <li><a href="?id='.$ArtRow['id_article'].'&action=stock">Stock</a></li>
                                                    <li><a href="?id='.$ArtRow['id_article'].'&action=prix">Prix</a></li>  
                                                </ul>
                                                </div>
                                            </div>
                                            </a>
                                            <button onclick="location.href=\'?id='.$ArtRow['id_article'].'&action=del&artnom='.$ArtRow['label_article'].'\'" class="button supprimer" type="button">Supprimer</button>
                                        </dv>
                                    </div>
                                </div>
                                </div><br>';
                        }
                    }
                    ?>
            </div>
            </div>
            
</body>

<?php
if (isset($_GET['action'])){
    echo '<script src="../dashboard/js/popup.js" type="text/javascript"></script>';
}
else{
    echo '<script onload="div_show(); "src="../dashboard/js/popup.js" type="text/javascript"></script>';
}
?>
</html>
