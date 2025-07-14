<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="accueil.php">Accueil</a>
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