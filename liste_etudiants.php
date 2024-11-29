<?php
// Inclure l'autoloader de Composer
require 'vendor/autoload.php';

// Connexion à la base de données
$host = 'localhost';
$dbname = 'bd_sms';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Utiliser PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Gestion de la liste des étudiants
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_query = !empty($search) ? "WHERE nom LIKE '%$search%' OR prenom LIKE '%$search%' OR numero LIKE '%$search%'" : '';

$etudiant_par_page = 10;
$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$offset = ($page - 1) * $etudiant_par_page;

// Requête principale avec recherche
$sql = "SELECT * FROM etudiant $search_query LIMIT $offset, $etudiant_par_page";
$result = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// Total des étudiants pour pagination
$total_etudiant = $pdo->query("SELECT COUNT(*) AS total FROM etudiant $search_query")->fetch()['total'];
$total_pages = ceil($total_etudiant / $etudiant_par_page);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste Des Étudiants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 20px;
        }
        .form-container, .table-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .form-container h2, .table-container h2 {
            color: #004aad;
        }
        button {
            background: #004aad;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 15px;
            cursor: pointer;
        }
        button:hover {
            background: #003580;
        }
        .pagination .active .page-link {
            background-color: #004aad;
            border-color: #004aad;
        }
    </style>
</head>
<body>


        <!-- Liste des étudiants -->
        <div class="table-container">
            <h2>Liste des étudiants</h2>
            <form class="mb-3" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Rechercher..." value="<?= htmlspecialchars($search) ?>">
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                </div>
            </form>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr class="table-primary">
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>numero</th>
                        <th>Classe</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $row): ?>
                        <tr>
                            <td><?= $row['id_etudiant'] ?></td>
                            <td><?= $row['nom'] ?></td>
                            <td><?= $row['prenom'] ?></td>
                            <td><?= $row['numero'] ?></td>
                            <td><?= $row['classe'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <section>
        
        <form method="POST" action="test.php">  
            <button type="submit" name="test.php">Gestion des numéros et Envoi de SMS</button>
        </form>
    </section>


            <body>
                
           