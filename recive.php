<?php
session_start();
?>

<body>
<label><b>Wysyłanie plików do serwera</b></label>
</body>

<?php 

$username = $_SESSION["login_user"];

if (is_uploaded_file($_FILES['plik']['tmp_name'])) {
    echo 'Odebrano plik: ' . $_FILES['plik']['name'] . '<br/>';
    $rootLocation = $_SERVER['DOCUMENT_ROOT'] . '/Z7/' . $username . '/';
    $location = $_SERVER[$rootLocation];
    echo $location;
    move_uploaded_file($_FILES['plik']['tmp_name'], $rootLocation . $_FILES['plik']['name']);
} else {
    echo 'Błąd przy przesyłaniu danych!';
}
?>