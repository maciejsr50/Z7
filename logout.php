<?php
session_start();

$username = $_SESSION["login_user"];
setcookie('name', $username, time()-3600);
session_destroy();

$home_url = 'http://mboguszpas.pl/Z7/login.php';
header('Location: ' . $home_url);
?>