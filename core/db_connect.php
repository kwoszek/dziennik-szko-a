<?php
$host = "localhost";
$db_name = "dziennik_szkolny";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host={$host};dbname={$db_name};charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $exception){
    echo "Błąd połączenia z bazą danych: " . $exception->getMessage();
    exit();
}
?>