<?php
include 'dao.php';
// Jesli wypelnione sa wszystkie pola to zapisuje uzytkownika do bazy
if (isset($_POST['username']) && isset($_POST['psw']) && isset($_POST['psw-repeat'])){
    
    
    $username = $_POST['username'];
    $password = $_POST['psw'];
    $password2 = $_POST['psw-repeat'];
    
    if ($password == $password2) {
        $result = addUserToDb($username, $password);
    }
    
    if(!$result){
        echo "Rejestracja nie powiodła się";
    } else{
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    
}
?>