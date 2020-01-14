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
        <?php include ('./template/head.php');?>
        <link href="css/Presentation.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <?php include ('./template/navbar.php');?>
        <?php include ('./template/panier.php'); ?>
        
        <div class="bgimg-1" >
            <div class="caption">
                <span class="border">PRESENTATION</span>
            </div>
        </div>
        
        
        
        <div id="stopbar" style="color: #777;background-color:white;text-align:center;text-align: justify;">
            <h3 style="text-align:center;">Notre Forge</h3>
            <p>La Forge au couteaux a été créée en 1926 par Albert Forga. Tous nos couteaux sont fabriqués de manière artisanale en Savoie. 
                Les lames sont forgées dans des aciers de qualité,
                et les manches sont façonnés en bois massifs ou en marqueterie de plusieurs bois par nos 4 salarier qui possede un savoir faire unique au monde.
                Les lames sont laissées brutes de
                forge sur le dos, ce qui donne un style rustique et moderne. Chaque couteau est étudié pour être le plus performant
                selon les utilisations. Les couteaux de cuisine sont forgés très fin et léger pour avoir une coupe exceptionnelle, 
                tandis que les couteaux de camp sont plus lourd et plus épais. Les couteaux pliants de type piémontais sont assez polyvalent.
                Les couteaux utilitaires sont destinés à une utilisation quotidienne (table, cuisine, randonnée...)</p>
        </div>

        <?php include ('./template/footer.php'); ?>
        
    </body>
