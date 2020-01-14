<?php
if(isset($_SESSION['admin'])){
    if($_SESSION['admin']!='t'){
        header('Location: http://localhost/');
    }
}else{
    header('Location: http://localhost/');
}
?>

<meta charset="UTF-8" />
<title>Panel La Forge</title>
<link href="css/form.css" rel="stylesheet" type="text/css"/>

<link rel="stylesheet" type="text/css" href="css/default.css" />
<link rel="stylesheet" type="text/css" href="css/pushbar.css" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


                                    