

<nav class="topnav" id="bardenavigation" role="navigation">
    <a class="active" id="titre" href="/index.php">La Forge Au <span>Couteau</span></a>
  <a <?php if($location==='index.php'){ echo 'class="active"';} ?> href="/index.php">Accueil</a>
  <a <?php if($location==='Presentation.php'){ echo 'class="active"';} ?> href="/Presentation.php">Présentation</a>
  <a <?php if($location==='Nos_couteaux.php'){ echo 'class="active"';} ?> href="/Nos_couteaux.php">Nos couteaux</a>
  <a onclick="panier();" id="toogle-panier">
      <span>
          <?php 
            if (isset($_SESSION['idclient'])) {
                $idCli = $_SESSION['idclient'];
                if (isset($idCli)) {
                    $dbconn = pg_connect("host=$dbhost dbname=$dbbd user=$dbuser password=$dbpassword")
                    or die('Connexion impossible : ' . pg_last_error());
                    $selectQ = "Select sum(qte) from panier where id_client =" . $idCli;
                    $selectres = pg_query($selectQ) or die('Échec de la requête : ' . pg_last_error());
                    $panier = pg_fetch_array($selectres, null, PGSQL_ASSOC);
                    $sum = (int)$panier['sum'];
                    if($sum>=1){
                        echo $panier['sum'];
                    }                    
                }
            }
          ?>
      </span>🛒
      </a>
  <?php
  if(isset($_SESSION['prenom'])){
      if($_SESSION['admin']=='t'){
           echo '<div class="dropdown">
                <button class="dropbtn"><a>Bonjour  '.$_SESSION['prenom'].
                    '</a> <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                    <a href="/dashboard/dashboard.php">Dashboard</a>
                    <a href="/profile.php">Profil</a>
                    <a href="/commandes.php">Mes Commandes</a>
                    <a href="disconectprosse.php" id="disconect">Se déconnecter</a>
                </div>
            </div>';     
      }else{
          echo '<div class="dropdown">
                    <button class="dropbtn">Bonjour  '.$_SESSION['prenom'].
                        ' <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="/profile.php">Profil</a>
                        <a href="/commandes.php">Mes Commandes</a>
                        <a href="disconectprosse.php" id="disconect">Se déconnecter</a>
                    </div>
                </div>';
      }
  }else{
      if($location==='signin.php' || $location==='signup.php'){ 
          $actif = 'class="active"';
      }else{
          $actif="";
      } 
      echo '<a style="float: right;"'.$actif.' href="/signin.php">Se connecter</a>';
  }
  ?>
  <a onclick="menuResponsive();" class="icon">
      <div id="nav-icon">
        <span></span>
        <span></span>
        <span></span>
      </div>
  </a>
</nav>