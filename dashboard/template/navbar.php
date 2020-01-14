
<div id="barTop">
    <a class="icon" onclick="">
        <div id="userInfo">
            <div style="float: right;margin: 16px;font-size: x-large;">Site La Forge</div>
            <div id="nav-icon">
                <span></span>
                <span></span>
                <span></span>
            </div>

        </div>
    </a>
    <?php
    echo('<h2 id="tabTitle">' . substr($location, 0, -4) . '</h2>');
    ?>
    <!--<div id="topSearchBox" style="display: inline-block;">
        <div class="icon icons_search"></div>
        <input type="text" class="searchBox" placeholder="Search..." data-bind="textInput: query">
        <div id="searchResults" style="display:none;" data-bind="visible: resultsVisible,foreach: results"></div>-->
</div>
</div>
<div id="bodypagpush" class="pushmenu-push">
    <nav class="pushmenu pushmenu-vertical pushmenu-left" id="pushmenu">
        <?php
        echo ('<h3>Bienvenue ' . $_SESSION['prenom'] . '</h3>');
        ?>
        <a href="./dashboard.php">📋 Dashboard</a>
        <a href="./article.php">📦 Gestion Des Article</a>
        <a href="./utilisateur.php">👥 Gestion Des Clients</a>
        <a href="#">📃 Facture</a>
        <a href="#">📥 Gestion Des Comentaires</a>
        <a href="../" class="downmenu">🌐 Retour Au Site</a>
        <a href="?disconect">🚪 Se deconnecter</a>
        <?php
        if (isset($_GET["disconect"])) {
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
                );
            }

            session_destroy();

            header("location:http://laforge.louisvolat.fr/");
        }
        ?>
    </nav>
    <div class="container">
        <script src="js/classie.js"></script>
        <script>
            var menuLeft = document.getElementById('pushmenu'),
                    icon = document.getElementById('nav-icon');
            pushpage = document.getElementById('bodypagpush');

            icon.onclick = function () {
                classie.toggle(this, 'active');
                classie.toggle(pushpage, 'pushmenu-push-toright');
                classie.toggle(menuLeft, 'pushmenu-open');
                disableOther('showLeftPush');
                if (icon.className === "open") {
                    icon.className = "";
                } else {
                    icon.className += " open";

                }

            };

            function disableOther(button) {
                if (button !== 'showLeftPush') {
                    classie.toggle(icon, 'disabled');
                }
            }
        </script>