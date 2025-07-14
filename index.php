<?php include('inc/function.php');
session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="mb-4 text-center">Connexion</h2>
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user = login($_POST['email'], $_POST['mdp']);
                if ($user) {
                    $_SESSION['membre'] = $user;
                    header('Location: page/accueil.php');
                } else {
                    echo '<div class="alert alert-danger">Email ou mot de passe incorrect</div>';
                }
            } ?>
            <form method="post">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="mdp" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Connexion</button>
            </form>
            <button class="btn btn-warning w-100"> <a href="page/inscription.php">Inscription</a></button>
        </div>
    </div>
</body>

</html>