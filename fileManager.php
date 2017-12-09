<?php 
session_start();
include 'dao.php';
$username = $_SESSION["login_user"];
if(is_null($username)) {
    session_destroy();
    header('Location: http://mboguszpas.pl/Z7/login.html');
}

$resultId = getUserId($username);
$rowId = mysqli_fetch_array ($resultId);
$userId = $rowId[0];

$resultFault = getLastFaultLogin($userId);
$rowFault = mysqli_fetch_array ($resultFault);
$faultTimestamp = $rowFault[0];
if (is_null($faultTimestamp))
    $faultTimestamp = "Brak";
?>
<link rel="stylesheet" href="style.css">
<body>

<div class="faultLogin">
	<label><b>Ostatnie błędne logowanie: <?php echo $faultTimestamp?></b></label>
</div>
 
<div class="addfile">
<form action="recive.php" method="POST" ENCTYPE="multipart/form-data"> 
<input type="file" size="200px" name="plik"/> 
<input type="submit" value="Wyślij plik"/> 
</form> 
</div>

<?php

$username = $_SESSION["login_user"];

$dir = '/home/mbogusz/ftp/pas/Z7/' . $username;

$files1 = scandir($dir);
$fileListSize = sizeof($files1);

echo '<div class="wrapper">';

for ($x = 2; $x < $fileListSize; $x++) {
    echo '<button class="filebtn" onclick="document.location.href=\'getFile.php?file=';
    echo $files1[$x];
    echo '\'">';
    echo $files1[$x];
    echo "</button><br>";
} 

echo '</div>';
?>

<div class="wrapper">
<button id="logout" class="logoutbtn" onclick="document.location.href='logout.php'">Wyloguj</button>
</div>
</body>