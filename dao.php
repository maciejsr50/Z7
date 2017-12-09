<?php

//Nawiązuje połączenie z bazą danych
function createConnection()
{
    $servername = "mbogusz.nazwa.pl";
    $username = "mbogusz_z7";
    $password = "***";
    $dbname = "mbogusz_z7";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    return $conn;
}

function addUserToDb($login, $password) {
    $conn = createConnection();
    $sql = "INSERT INTO `users` (login, password) VALUES ('$login', '$password')";
    $result = mysqli_query($conn, $sql);
    $conn->close();
    
    return $result;
}

function addUserLogToDatabase($fault_login, $count_fault, $user_id)
{
    $conn = createConnection();
    $sql = "INSERT INTO `logi` (fault_login, count_fault, user_id) VALUES ('$fault_login', '$count_fault', '$user_id')";
    $result = mysqli_query($conn, $sql);
    $conn->close();
    
    return $result;
}

function getUserFromDb($login, $password)
{
    $conn = createConnection();
    $sql = "SELECT * FROM `users` WHERE login = '$login' and password = '$password'";
    $result = mysqli_query($conn, $sql);
    $conn->close();
    
    return $result;
}

function getUserId($login)
{
    $conn = createConnection();
    $sql = "SELECT `user_id` FROM `users` WHERE login = '$login'";
    $result = mysqli_query($conn, $sql);
    $conn->close();
    
    return $result;
}

function getUserLoginInfoForUserId($user_id) {
    $conn = createConnection();
    $sql = "SELECT * FROM `logi` WHERE user_id = '$user_id' ORDER BY `timestamp` DESC";
    $result = mysqli_query($conn, $sql);
    $conn->close();
    
    return $result;
}

function getLastFaultLogin($user_id) {
    $conn = createConnection();
    $sql = "SELECT `timestamp` FROM `logi` WHERE user_id = '$user_id' and fault_login = true ORDER BY `timestamp` DESC";
    $result = mysqli_query($conn, $sql);
    $conn->close();
    
    return $result;
}

?>