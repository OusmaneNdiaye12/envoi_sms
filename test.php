<?php
use Twilio\Rest\Client;
require __DIR__ . "/vendor/autoload.php";
require 'connect_bd.php'; // Inclure la connexion à la base de données

// Variables Twilio
$account_sid = "";
$auth_token = "";
$twilio_number = "";
$client = new Client($account_sid, $auth_token);

// Ajouter un numéro
if (isset($_POST["add_number"])) {
    $new_number = $_POST["new_number"];
    $stmt = $pdo->prepare("INSERT INTO contact (number) VALUES (:number)");
    $stmt->bindParam(':number', $new_number);
    $stmt->execute();
}

// Supprimer un numéro
if (isset($_POST["delete_number"])) {
    $delete_number = $_POST["delete_number"];
    $stmt = $pdo->prepare("DELETE FROM contact WHERE number = :number");
    $stmt->bindParam(':number', $delete_number);
    $stmt->execute();
}

// Envoyer un message
if (isset($_POST["send_message"])) {
    $message = $_POST["message"];
    
    // Récupérer tous les numéros de téléphone depuis la base de données
    $stmt = $pdo->query("SELECT number FROM numero");
    $numbers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($numbers as $row) {
        $client->messages->create(
            $row['number'],  // Numéro du destinataire
            [
                "from" => $twilio_number,
                "body" => $message
            ]
        );
    }
    echo "Message envoyé à tous les destinataires.";
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des numéros</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Style global */
body {
    font-family: Arial, sans-serif;
    background-color: #f0f8ff; /* Bleu clair */
    margin: 0;
    padding: 0;
}

/* Conteneur principal */
.container {
    width: 90%;
    max-width: 800px;
    margin: 20px auto;
    background: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Titre principal */
.container h1 {
    text-align: center;
    color: #0056b3;
}

/* Sections */
section {
    margin-bottom: 20px;
}

section h2 {
    color: #003d80;
    margin-bottom: 10px;
}

/* Formulaires */
form {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

form input,
form textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid #cccccc;
    border-radius: 5px;
    font-size: 1rem;
    box-sizing: border-box;
}

form input:focus,
form textarea:focus {
    border-color: #0056b3;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 86, 179, 0.5);
}

/* Boutons */
form button {
    background-color: #0056b3;
    color: #ffffff;
    padding: 10px;
    font-size: 1rem;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #003d80;
}

/* Liste des numéros */
ul {
    list-style-type: none;
    padding: 0;
}

ul li {
    background: #e6f2ff;
    margin: 5px 0;
    padding: 10px;
    border-radius: 5px;
    color: #0056b3;
}

    </style>
</head>
<body>

<div class="container">
    <h1>Gestion des numéros et Envoi de SMS</h1>

    <section>
        <h2>Ajouter un numéro de téléphone</h2>
        <form method="POST" action="test.php">
            <input type="text" name="new_number" placeholder="Numéro à ajouter (ex: +221XXXXXXXXX)" required>
            <button type="submit" name="add_number">Ajouter</button>
        </form>
    </section>

    <section>
        <h2>Supprimer un numéro de téléphone</h2>
        <form method="POST" action="test.php">
            <input type="text" name="delete_number" placeholder="Numéro à supprimer (ex: +221XXXXXXXXX)" required>
            <button type="submit" name="delete_submit">Supprimer</button>
        </form>
    </section>

    <section>
        <h2>Envoyer un message à tous les numéros</h2>
        <form method="POST" action="test.php">
            <textarea name="message" placeholder="Entrez votre message ici..." required></textarea>
            <button type="submit" name="send_message">Envoyer</button>
        </form>
    </section>

 









</div>

<section>
        
        <form method="POST" action="liste_etudiants.php">  
            <button type="submit" name="liste_etudiants.php">LA LISTE DES ETUDIANTS</button>
        </form>
    </section>

</body>
</html>

