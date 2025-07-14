<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Emprunt Objets</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Accueil</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['membre'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link text-warning">Bonjour <?= htmlspecialchars($_SESSION['membre']['nom']) ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="liste_objets.php">Objets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="emprunts.php">Tous les emprunts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mes_emprunts.php">Mes emprunts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="inscription.php">Inscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout.php">Déconnexion</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Connexion</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="text-center">Bienvenue sur le site d'emprunt d'objets</h1>
    <p class="text-center">Partagez et empruntez facilement des objets entre membres.</p>
    <div class="text-center mt-4">
        <?php if (isset($_SESSION['membre'])) : ?>
            <a href="liste_objets.php" class="btn btn-primary btn-lg">Voir les objets disponibles</a>
        <?php else : ?>
            <a href="login.php" class="btn btn-primary btn-lg">Se connecter</a>
            <a href="inscription.php" class="btn btn-success btn-lg">Créer un compte</a>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
