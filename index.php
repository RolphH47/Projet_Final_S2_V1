<?php 
include('inc/function.php');
session_start(); 
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Connexion</h2>
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
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Mot de passe</label>
                <input type="password" name="mdp" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Connexion</button>
        </form>
    </div>
</body>

</html>
