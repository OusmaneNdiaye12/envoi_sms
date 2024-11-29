<?php
$host = 'localhost';
$dbname = 'bd_sms';
$username = 'root'; // Utilisateur par défaut de XAMPP
$password = ''; // Le mot de passe est vide par défaut pour XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>
