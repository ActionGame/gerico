<?php
$db_host = 'localhost';       // Adresse du serveur
$db_port = '3306';            // Port du serveur MySQL
$db_name = 'gerico';            // Nom de la base de données
$db_user = 'root';            // Nom d'utilisateur MySQL
$db_password = '';            // Mot de passe MySQL

$dsn = "mysql:host=$db_host;port=$db_port;dbname=$db_name;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $db_user, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Échec de la connexion : ' . $e->getMessage();
}
