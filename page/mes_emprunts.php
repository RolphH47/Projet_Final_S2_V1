<?php
session_start();
include('../inc/function.php');

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['membre'])) {
    header('Location: login.php');
    exit;
}

$id_membre = $_SESSION['membre']['id_membre'];
$mes_emprunts = getEmpruntsByMembre($id_membre);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes emprunts</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="accueil.php">Accueil</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="liste_objets.php">Objets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="emprunts.php">Tous les emprunts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Déconnexion</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h1>Mes emprunts</h1>

    <?php if (count($mes_emprunts) === 0): ?>
        <div class="alert alert-info">Vous n'avez aucun emprunt en cours.</div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nom de l'objet</th>
                    <th>Date d'emprunt</th>
                    <th>Date de retour</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mes_emprunts as $emprunt): ?>
                    <tr>
                        <td><?= htmlspecialchars($emprunt['nom_objet']) ?></td>
                        <td><?= htmlspecialchars($emprunt['date_emprunt']) ?></td>
                        <td><?= htmlspecialchars($emprunt['date_retour']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
