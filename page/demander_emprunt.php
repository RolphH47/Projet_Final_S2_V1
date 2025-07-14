<?php
session_start();
require '../inc/function.php';

if (!isset($_SESSION['membre'])) {
    header('Location: ../index.php');
    exit;
}

if (!isset($_POST['id_objet'])) {
    header('Location: liste_objets.php');
    exit;
}

$id_objet = (int)$_POST['id_objet'];
$id_membre = $_SESSION['membre']['id_membre'];
$pdo = dbconnect();
$stmt = $pdo->prepare("SELECT * FROM objet WHERE id_objet = ? AND NOT EXISTS (
    SELECT 1 FROM emprunt 
    WHERE id_objet = ? AND date_retour > CURRENT_DATE()
)");
$stmt->execute([$id_objet, $id_objet]);
$objet = $stmt->fetch();

if (!$objet) {
    $_SESSION['erreur'] = "Cet objet n'est pas disponible pour le moment";
    header('Location: liste_objets.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['date_emprunt'], $_POST['date_retour'])) {
    $date_emprunt = DateTime::createFromFormat('Y-m-d', $_POST['date_emprunt']);
    $date_retour = DateTime::createFromFormat('Y-m-d', $_POST['date_retour']);
    $aujourdhui = new DateTime();

    if (!$date_emprunt || !$date_retour) {
        $_SESSION['erreur'] = "Format de date invalide (YYYY-MM-DD requis)";
    } elseif ($date_emprunt < $aujourdhui) {
        $_SESSION['erreur'] = "La date d'emprunt ne peut pas être dans le passé";
    } elseif ($date_retour <= $date_emprunt) {
        $_SESSION['erreur'] = "La date de retour doit être après la date d'emprunt";
    } else {
        $date_emprunt_mysql = $date_emprunt->format('Y-m-d');
        $date_retour_mysql = $date_retour->format('Y-m-d');

        $stmt = $pdo->prepare("INSERT INTO emprunt (id_objet, id_membre, date_emprunt, date_retour, statut) 
                              VALUES (?, ?, ?, ?, 'en_attente')");
        if ($stmt->execute([$id_objet, $id_membre, $date_emprunt_mysql, $date_retour_mysql])) {
            $_SESSION['success'] = "Demande d'emprunt envoyée avec succès!";
            header('Location: mes_emprunts.php');
            exit;
        } else {
            $_SESSION['erreur'] = "Erreur lors de l'enregistrement";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demande d'emprunt</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .date-picker-container {
            max-width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<?php include('navbar.php'); ?>

<div class="container mt-4">
    <div class="date-picker-container">
        <h2 class="mb-4">Demande d'emprunt</h2>
        
        <?php if (isset($_SESSION['erreur'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['erreur'] ?></div>
            <?php unset($_SESSION['erreur']); ?>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-body">
                <h4><?= htmlspecialchars($objet['nom_objet']) ?></h4>
                <p class="text-muted">Propriétaire: <?= htmlspecialchars(getProprietaireObjet($objet['id_objet'])['nom']) ?></p>
                
                <form method="post" id="form-emprunt">
                    <input type="hidden" name="id_objet" value="<?= $id_objet ?>">
                    
                    <div class="mb-3">
                        <label class="form-label">Date d'emprunt</label>
                        <input type="date" name="date_emprunt" id="date_emprunt" 
                               class="form-control" required
                               min="<?= date('Y-m-d') ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Date de retour</label>
                        <input type="date" name="date_retour" id="date_retour" 
                               class="form-control" required
                               min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">
                            Confirmer l'emprunt
                        </button>
                        <a href="liste_objets.php" class="btn btn-outline-secondary">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>