<?php

if(isset($_COOKIE['accept_cookie'])) {
   $showcookie = false;
} else {
   $showcookie = true;
   require_once(ROOT.'/legal/cookie/cookie-view.php');
}
