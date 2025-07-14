<?php // index.php ?>
<?php include('../inc/function.php'); session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Emprunt d'Objets</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="../index.php">Emprunt Objets</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <?php if (!isset($_SESSION['membre'])): ?>
                    <li class="nav-item"><a href="login.php" class="nav-link">Connexion</a></li>
                    <li class="nav-item"><a href="inscription.php" class="nav-link">Inscription</a></li>
                <?php else: ?>
                    <li class="nav-item"><a href="liste_objets.php" class="nav-link">Objets</a></li>
                    <li class="nav-item"><a href="fiche_membre.php" class="nav-link">Fiche</a></li>
                    <li class="nav-item"><a href="mes_emprunts.php" class="nav-link">Mes emprunts</a></li>
                    <li class="nav-item"><a href="ajout_objet.php" class="nav-link">Ajouter Objet</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link">Déconnexion</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5">
    <h1 class="mb-4 text-center">Bienvenue sur le site d'emprunt d'objets</h1>
    <div class="text-center">
        <?php if (!isset($_SESSION['membre'])): ?>
            <a href="../index.php" class="btn btn-primary me-3">Connexion</a>
            <a href="inscription.php" class="btn btn-success">Inscription</a>
        <?php else: ?>
            <a href="liste_objets.php" class="btn btn-outline-primary me-3">Voir les objets disponibles</a>
            <a href="mes_emprunts.php" class="btn btn-outline-success">Mes emprunts</a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
