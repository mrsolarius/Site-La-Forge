<?php

setcookie("accept_cookie",'Vous_avez_un_cookie,miam.😋',time()+31556926 ,'/');
header('Location: ' . $_SERVER['HTTP_REFERER']);