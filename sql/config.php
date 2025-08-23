<?php
    $dbname = 'sms';
    $host = 'localhost';
    $username = 'root';
    $password = '';
    
    $conn = new mysqli('p:'.$host, $username, $password, $dbname);
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    if($conn->connect_error){
        die("Connection Error".$conn->connect_error);
    }
    $secret_key = 'MY_SUPER_SECRET_KEY_123';
?>