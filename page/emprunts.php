 <?php include('../inc/function.php'); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des Emprunts</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="accueil.php">Emprunt Objets</a>
        </div>
    </nav>
    <div class="container mt-4">
        <h1>Liste des Emprunts</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Objet</th>
                    <th>Emprunteur</th>
                    <th>Date Emprunt</th>
                    <th>Date Retour</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (getEmprunts() as $row) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nom_objet']) ?></td>
                        <td><?= htmlspecialchars($row['nom_membre']) ?></td>
                        <td><?= htmlspecialchars($row['date_emprunt']) ?></td>
                        <td><?= htmlspecialchars($row['date_retour']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>