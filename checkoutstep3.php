<?php
$location = basename(__FILE__);
include ($_SERVER['DOCUMENT_ROOT'] . '/settings.php');

$idCli = $_SESSION['idclient'];

$dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
        or die('Connexion impossible : ' . pg_last_error());

$Prenom = strtolower(filter_input(INPUT_POST, 'Prenom'));
$Noms = strtolower(filter_input(INPUT_POST, 'Noms'));
$EMail = strtolower(filter_input(INPUT_POST, 'EMail'));
$Tel = strtolower(filter_input(INPUT_POST, 'Telephone'));
$Rue = strtolower(filter_input(INPUT_POST, 'Rue'));
$Ville = strtolower(filter_input(INPUT_POST, 'Ville'));
$Cpostal = strtolower(filter_input(INPUT_POST, 'Cpostal'));

$selectQ = "select * from client where id_client =" . $idCli;
$selectRes = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
$ArtRow = pg_fetch_array($selectRes, null, PGSQL_ASSOC);


echo '====' . $Tel . '====';

if ($Prenom != "") {
    if ($Noms != "") {
        if ($Rue != "") {
            if ($Ville != "") {
                if ($Cpostal != "") {
                    $_SESSION['run']=true;
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
            <div class=wrap>


                <form name="form" autocomplete="on" action="/checkoutvalide.php" method="post" >

                    <div class="form-container">

                        <div class="personal-information">
                            <h1>Validation Du Paiement</h1>
                        </div>

                        <div id="input-field">
                            <?php
                            $selectQ = "select * from client where id_client =" . $idCli;
                            $selectRes = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
                            $ArtRow = pg_fetch_array($selectRes, null, PGSQL_ASSOC);

                            echo ' <input name="name" id="name" type="text" value="' . $ArtRow['nom_client'] . ' ' . $ArtRow['prenom_client'] . '" required minlength="3" maxlength="20" autocomplete="cc-name" placeholder="Vos Nom & Prénom"/>';
                            ?>
                        </div>

                        <div class="card-background">
                            <div class="container preload">
                                <div class="creditcard">
                                    <div class="front">
                                        <div id="ccsingle"></div>
                                        <svg version="1.1" id="cardfront" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                             x="0px" y="0px" viewBox="0 0 750 471" style="enable-background:new 0 0 750 471;" xml:space="preserve">
                                            <g id="Front">
                                                <g id="CardBackground">
                                                    <g id="Page-1_1_">
                                                        <g id="amex_1_">
                                                            <path id="Rectangle-1_1_" class="lightcolor grey" d="M40,0h670c22.1,0,40,17.9,40,40v391c0,22.1-17.9,40-40,40H40c-22.1,0-40-17.9-40-40V40
                                                                  C0,17.9,17.9,0,40,0z" />
                                                        </g>
                                                    </g>
                                                    <path class="darkcolor greydark" d="M750,431V193.2c-217.6-57.5-556.4-13.5-750,24.9V431c0,22.1,17.9,40,40,40h670C732.1,471,750,453.1,750,431z" />
                                                </g>
                                                <text transform="matrix(1 0 0 1 60.106 295.0121)" id="svgnumber" class="credit-font st2 st3">1234 5678 9012 3456</text>
                                                <text transform="matrix(1 0 0 1 54.1064 428.1723)" id="svgname" class="credit-font st2 st4">Nom & Prenom</text>
                                                <text transform="matrix(1 0 0 1 563.7754 388.8793)" class="st2 st5 st8">MONTH/YEAR</text>
                                                <g>
                                                    <text transform="matrix(1 0 0 1 574.4219 433.8095)" id="svgexpire" class="credit-font st2 st9">12/34</text>
                                                    <text transform="matrix(1 0 0 1 479.3848 417.0097)" class="st2 st10 st11">GOOD</text>
                                                    <text transform="matrix(1 0 0 1 479.3848 435.6762)" class="st2 st10 st11">THRU</text>
                                                    <polygon class="st2" points="554.5,421 540.4,414.2 540.4,427.9 		" />
                                                </g>
                                                <g id="cchip">
                                                    <g>
                                                        <path class="st2" d="M168.1,143.6H82.9c-10.2,0-18.5-8.3-18.5-18.5V74.9c0-10.2,8.3-18.5,18.5-18.5h85.3
                                                              c10.2,0,18.5,8.3,18.5,18.5v50.2C186.6,135.3,178.3,143.6,168.1,143.6z" />
                                                    </g>
                                                    <g>
                                                        <g>
                                                            <rect x="82" y="70" class="st12" width="1.5" height="60" />
                                                        </g>
                                                        <g>
                                                            <rect x="167.4" y="70" class="st12" width="1.5" height="60" />
                                                        </g>
                                                        <g>
                                                            <path class="st12" d="M125.5,130.8c-10.2,0-18.5-8.3-18.5-18.5c0-4.6,1.7-8.9,4.7-12.3c-3-3.4-4.7-7.7-4.7-12.3
                                                                  c0-10.2,8.3-18.5,18.5-18.5s18.5,8.3,18.5,18.5c0,4.6-1.7,8.9-4.7,12.3c3,3.4,4.7,7.7,4.7,12.3
                                                                  C143.9,122.5,135.7,130.8,125.5,130.8z M125.5,70.8c-9.3,0-16.9,7.6-16.9,16.9c0,4.4,1.7,8.6,4.8,11.8l0.5,0.5l-0.5,0.5
                                                                  c-3.1,3.2-4.8,7.4-4.8,11.8c0,9.3,7.6,16.9,16.9,16.9s16.9-7.6,16.9-16.9c0-4.4-1.7-8.6-4.8-11.8l-0.5-0.5l0.5-0.5
                                                                  c3.1-3.2,4.8-7.4,4.8-11.8C142.4,78.4,134.8,70.8,125.5,70.8z" />
                                                        </g>
                                                        <g>
                                                            <rect x="82.8" y="82.1" class="st12" width="25.8" height="1.5" />
                                                        </g>
                                                        <g>
                                                            <rect x="82.8" y="117.9" class="st12" width="26.1" height="1.5" />
                                                        </g>
                                                        <g>
                                                            <rect x="142.4" y="82.1" class="st12" width="25.8" height="1.5" />
                                                        </g>
                                                        <g>
                                                            <rect x="142" y="117.9" class="st12" width="26.2" height="1.5" />
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                            <g id="Back">
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="back">
                                        <svg version="1.1" id="cardback" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                             x="0px" y="0px" viewBox="0 0 750 471" style="enable-background:new 0 0 750 471;" xml:space="preserve">
                                            <g id="Front">
                                                <line class="st0" x1="35.3" y1="10.4" x2="36.7" y2="11" />
                                            </g>
                                            <g id="Back">
                                                <g id="Page-1_2_">
                                                    <g id="amex_2_">
                                                        <path id="Rectangle-1_2_" class="darkcolor greydark" d="M40,0h670c22.1,0,40,17.9,40,40v391c0,22.1-17.9,40-40,40H40c-22.1,0-40-17.9-40-40V40
                                                              C0,17.9,17.9,0,40,0z" />
                                                    </g>
                                                </g>
                                                <rect y="61.6" class="st2" width="750" height="78" />
                                                <g>
                                                    <path class="st3" d="M701.1,249.1H48.9c-3.3,0-6-2.7-6-6v-52.5c0-3.3,2.7-6,6-6h652.1c3.3,0,6,2.7,6,6v52.5
                                                          C707.1,246.4,704.4,249.1,701.1,249.1z" />
                                                    <rect x="42.9" y="198.6" class="st4" width="664.1" height="10.5" />
                                                    <rect x="42.9" y="224.5" class="st4" width="664.1" height="10.5" />
                                                    <path class="st5" d="M701.1,184.6H618h-8h-10v64.5h10h8h83.1c3.3,0,6-2.7,6-6v-52.5C707.1,187.3,704.4,184.6,701.1,184.6z" />
                                                </g>
                                                <text transform="matrix(1 0 0 1 621.999 227.2734)" id="svgsecurity" class="st6 st7">1234</text>
                                                <g class="st8">
                                                    <text transform="matrix(1 0 0 1 575.083 280.0879)" class="st9 st6 st10">CVV2 / CVC2</text>
                                                </g>
                                                <rect x="58.1" y="378.6" class="st11" width="375.5" height="13.5" />
                                                <rect x="58.1" y="405.6" class="st11" width="421.7" height="13.5" />
                                                <text transform="matrix(1 0 0 1 59.5073 228.6099)" id="svgnameback" class="st12 st13">Nom & Prenom</text>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div id="input-field">
                            <input name="cardNumber" id="cc-number" class="cc-number" type="tel" inputmode="numeric" required novalidate autocomplete="cc-number" placeholder=" Card Number"/>
                            <input type="hidden" id="ccicon" class= "ccicon" width="750" height="471" viewBox="0 0 750 471" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"/>
                        </div>

                        <div id="column-expiry">
                            <input name="cardExpiry" id="expirationdate" class="cc-exp" type="tel" inputmode="numeric" required novalidate autocomplete="cc-exp" placeholder=" Expiration (MM/YY)"/>
                        </div>

                        <div id="column-cvc">
                            <input name="cardCVC" id="cc-cvc" class="cc-cvc" type="tel" inputmode="numeric" required novalidate autocomplete="cc-csc" placeholder="Code de Securité"/>
                        </div>

                        <div id="input-button">
                            <button class="btn" type="submit">Payer</button>
                        </div>

                    </div>

                </form>
            </div>
        </div>
    </div>

    <?php include ('./template/footer.php'); ?>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/3.0.0/jquery.payment.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/imask/3.4.0/imask.min.js'></script>
    <script  src="js/cartebleu.js"></script>
</body>
