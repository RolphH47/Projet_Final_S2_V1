
<?php include('../inc/function.php'); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Inscription</h2>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (inscrire($_POST['nom'], $_POST['email'], $_POST['date_naisasnce'],$_POST['mdp'], $_POST['ville'])) {
                echo '<div class="alert alert-success">Inscription réussie</div>';
            }
        } ?>
        <form method="post">
            <div class="mb-3">
                <label>Nom</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Date de naissance</label>
                <input type="email" name="date_naissance" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Mot de passe</label>
                <input type="password" name="mdp" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Ville</label>
                <input type="text" name="ville" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">S'inscrire</button>
        </form><br>
        <button class="btn btn-danger"><a href="accueil.php">Accueil</a></button>
    </div>
</body>

</html>
