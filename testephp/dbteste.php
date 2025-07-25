<?php
$host = "localhost:3306";
$db = "Hospital";
$user = "root";
$pass = "root";

try{
    $pdo = new PDO(dsn:"mysql:host=$host;dbname=$db", username: $user, password: $pass);

    $pdo->setAttribute(attribute: PDO::ATTR_ERRMODE, value: PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e){
    echo 'Erro: ' . $e->getMessage();
}
?>
