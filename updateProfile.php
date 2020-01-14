<?php
include ($_SERVER['DOCUMENT_ROOT'] . '/settings.php');

$dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
        or die('Connexion impossible : ' . pg_last_error());

$idCli = $_SESSION['idclient'];

$Noms = filter_input(INPUT_POST, 'name');
$Prenom = filter_input(INPUT_POST, 'surname');
$Tel = filter_input(INPUT_POST, 'tel');
$EMail = filter_input(INPUT_POST, 'mail');
$Rue = filter_input(INPUT_POST, 'rue');
$Ville = filter_input(INPUT_POST, 'ville');
$Cpostal= filter_input(INPUT_POST, 'cpost');

$selectQ = "select * from client where id_client =" . $idCli;
echo $selectQ;
$selectRes = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
$ArtRow = pg_fetch_array($selectRes, null, PGSQL_ASSOC);


if ($Prenom != "") {
    if ($Noms != "") {
        if ($Rue != "") {
            if ($Ville != "") {
                if ($Cpostal != "") {
                    if ($ArtRow['prenom_client'] != $Prenom) {
                        $selectQ = "Update client set prenom_client = '" . $Prenom . "' where id_client=" . $idCli;
                        $selectRes = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
                    }



                    if ($ArtRow['nom_client'] != $Noms) {
                        $selectQ = "Update client set nom_client = '" . $Noms . "' where id_client=" . $idCli;
                        $selectRes = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
                    }



                    if ($Tel != "") {
                        if ($ArtRow['tel_client'] != $Tel) {
                            $selectQ = "Update client set tel_client = '" . $Tel . "' where id_client=" . $idCli;
                            $selectRes = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
                        }
                    }

                    if ($EMail != "") {
                        if ($ArtRow['mail_client'] != $EMail) {
                            $selectQ = "Update client set mail_client = '" . $EMail . "' where id_client=" . $idCli;
                            $selectRes = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
                        }
                    }

                    if ($ArtRow['rue_client'] != $Rue) {
                        $selectQ = "Update client set rue_client = '" . $Rue . "' where id_client=" . $idCli;
                        echo $selectQ;
                        $selectRes = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
                    }




                    if ($ArtRow['ville_client'] != $Ville) {
                        $selectQ = "Update client set ville_client = '" . $Ville . "' where id_client=" . $idCli;
                        $selectRes = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
                    }





                    if ($ArtRow['cp_client'] != $Cpostal) {
                        $selectQ = "Update client set cp_client = '" . $Cpostal . "' where id_client=" . $idCli;
                        $selectRes = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
                    }
                }
            }
        }
    }
}

header("location:profile.php");

