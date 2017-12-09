<?php
include 'dao.php';
session_start();

$error='';
if (empty($_POST['uname']) || empty($_POST['psw'])) {
    $error="Proszę podać login i hasło";
} else {
    $username=$_POST['uname'];
    $password=$_POST['psw'];
    // Chroni przed sql injection
    $username = stripslashes($username);
    $password = stripslashes($password);
    
    $resultId = getUserId($username);
    $rowId = mysqli_fetch_array ($resultId);
    $userId = $rowId[0];
    
    if (!is_null($userId)) {
        $resultLoginInfo = getUserLoginInfoForUserId($userId);
        $rowLoginInfo = mysqli_fetch_array($resultLoginInfo);
        $fault_login = $rowLoginInfo[2];
        $count_fault = $rowLoginInfo[3];
        
        $resultUser = getUserFromDb($username, $password);
        $rowUser = mysqli_fetch_array ($resultUser);
        
        $user = $rowUser[1];
        $pass = $rowUser[2];
        
        if(is_null($fault_login)) {
            firstLoginAction($user, $pass, $userId);
        } else {
            loginAction($user, $pass, $fault_login, $count_fault, $userId);
        }
    } else{
      //W bazie nie ma takiego użytkownika więc nie wpisuję loga  
    }
}

// Pierwsza akcja logowania gdy nie ma jeszcze wpisu w tabeli logi
function firstLoginAction($user, $pass, $userId) {
    if ($_POST['uname'] == $user) {
        if ($_POST['psw'] == $pass) {
            
            $cookie_name = "name";
            setcookie($cookie_name, $user, 2147483647);
            
            $_SESSION["login_user"] = $_POST['uname'];  
            addUserLogToDatabase(false, 0, $userId);
            createDirIfNotExist($user);
            header('Location: http://mboguszpas.pl/Z7/fileManager.php');
            break;
        } else {
            addUserLogToDatabase(true, 1, $userId);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            break;
        }
    } else {
        addUserLogToDatabase(true, 1, $userId);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        break;
    }
}

//Metoda logowania jesli uzytkownik posiada juz chociaz jeden wpis w tabeli logi
function loginAction($user, $pass, $fault_login, $count_fault, $userId)
{
    if ($count_fault < 3) {
        if ($_POST['uname'] == $user) {
            if ($_POST['psw'] == $pass) {
                
                $cookie_name = "name";
                setcookie($cookie_name, $user, 2147483647);
                
                $_SESSION["login_user"] = $_POST['uname'];
                addUserLogToDatabase(false, 0, $userId);
                createDirIfNotExist($user);
                header('Location: http://mboguszpas.pl/Z7/fileManager.php');
                break;
            } else {
                $count_fault = $count_fault + 1;
                addUserLogToDatabase(true, $count_fault, $userId);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                break;
            }
        } else {
            $count_fault = $count_fault + 1;
            addUserLogToDatabase(true, $count_fault, $userId);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            break;
        }
    } else {
        echo "Konto zostało zablokowane, skontaktuj się z administratorem: mbogusz@pas.pl";
    }
}

//Tworzy katalog dla użytkownika, jęsli jeszcze go  nie posiada
function createDirIfNotExist($username) {
    $dir = '/home/mbogusz/ftp/pas/Z7/' . $username;
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
}

?>