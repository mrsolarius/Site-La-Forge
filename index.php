<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
 $location = basename(__FILE__);
 include ($_SERVER['DOCUMENT_ROOT'] . '/settings.php');
 
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>La Forge Au Couteau</title>
        <link href="css/Acceuil.css" rel="stylesheet" type="text/css"/>
        <?php include ('./template/head.php');?>

    </head>
    <body>       
        <?php include ('./template/navbar.php'); ?>
        <?php include ('./template/panier.php'); ?>
        <?php 
        echo '<p>'; var_dump($_SESSION); echo '</p>';
        ?>    
        <div class="bgimg-1" >
            <div class="caption">
                <span class="border">LA FORGE AU COUTEAU</span>
            </div>
        </div>
        
        
        
        <div id="stopbar" style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
            <h3 style="text-align:center;">Couteau Forger</h3>
            <p>Tous nos couteaux sont fabriqués de manière artisanale en Savoie. Les lames sont forgées dans des aciers de qualité, et les manches sont façonnés en bois massifs ou en marqueterie de plusieurs bois. Les lames sont laissées brutes de forge sur le dos, ce qui donne un style rustique et moderne. Chaque couteau est étudié pour être le plus performant selon les utilisations. Les couteaux de cuisine sont forgés très fin et léger pour avoir une coupe exceptionnelle, tandis que les couteaux de camp sont plus lourd et plus épais. Les couteaux pliants de type piémontais sont assez polyvalent. Les couteaux utilitaires sont destinés à une utilisation quotidienne (table, cuisine, randonnée...)</p>
        </div>
        <div class="bgimg-2">
        </div>
        
    
        <div id="canava1">
            <div class="accColum">
            <h3 style="text-align:center;color:white">
                Unique</h3>
            <p style="color:#ffffffc9">Chaque couteau est réalisé de manière artisanale. Tout est entièrement fait à la main sans gabarit, ce qui rend chaque couteau unique. Les lames sont forgées et les manches sont façonnés en bois, ou en corne.</p>
            </div>
            
            <div class="accColum">
            <h3 style="text-align:center;color:white">Sur mesure</h3>
            <p style="color:#ffffffc9">Chaque couteau peut être réalisé selon vos souhait. La forme de la lame ou du manche. Du bois massif ou en marqueterie.Réalisons ensemble votre projet. </p>
            </div>
        </div>

        <div class="bgimg-3">
            
        </div>

        <div style="position:relative;">
            <h3 style="text-align:center;">Nos Lames</h3>
            <div style="color:#777;background-color:white;text-align:center;padding:0 80px 50px;text-align: justify;">
                <p>Différents aciers sont utilisés pour la création des couteaux: XC75, XC100, 100C6, 14C28N (inoxydable)...
                Ce sont des aciers à haute teneur en carbone spécialement étudié pour la coutellerie et qui garantissent un excellent pouvoir de coupe sur le long terme. 
                Toutes les lames sont laissées brutes de forge sur le haut, et sont polies au niveau du tranchant.</p>
            </div>
        </div>

        <div class="bgimg-1">
            <div class="caption">
                <span class="border">COOL!</span>
            </div>
        </div>
        
        <?php include ('./template/footer.php'); ?>

    </body>
</html>
