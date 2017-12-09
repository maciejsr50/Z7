<?php
session_start();

$username = $_SESSION["login_user"];;
$fileName = $_GET["file"];

$file_url = 'http://mboguszpas.pl/Z7/' . $username . '/' . $fileName;
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
readfile($file_url);
exit(); 
?>