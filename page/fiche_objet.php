<?php 
include('../inc/function.php');
$id_objet = $_GET['id'] ?? 0;
$objet = getFicheObjet($id_objet);
$images = getImagesObjet($id_objet);
$historique = getHistoriqueEmprunts($id_objet);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($objet['nom_objet']) ?></title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <h2><?= htmlspecialchars($objet['nom_objet']) ?></h2>
            <p>Catégorie: <?= htmlspecialchars($objet['nom_categorie']) ?></p>
            <p>Propriétaire: <?= htmlspecialchars($objet['nom_membre']) ?></p>
            
            <div class="mb-4">
                <?php if (!empty($images)): ?>
                    <img src="../assets/image/<?= htmlspecialchars($images[0]['nom_image']) ?>" class="img-main img-fluid mb-3" alt="Image principale">
                    
                    <div class="gallery d-flex flex-wrap gap-2">
                        <?php foreach ($images as $image): ?>
                            <img src="../assets/image/<?= htmlspecialchars($image['nom_image']) ?>" class="gallery-img img-thumbnail">
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <img src="../assets/image/default.jpg" class="img-main img-fluid" alt="Image par défaut">
                <?php endif; ?>
            </div>
        </div>
        
        <div class="col-md-6">
            <h3>Historique des emprunts</h3>
            <?php if (!empty($historique)): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Emprunteur</th>
                            <th>Date emprunt</th>
                            <th>Date retour</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($historique as $emprunt): ?>
                            <tr>
                                <td><?= htmlspecialchars($emprunt['nom_membre']) ?></td>
                                <td><?= htmlspecialchars($emprunt['date_emprunt']) ?></td>
                                <td><?= htmlspecialchars($emprunt['date_retour']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucun emprunt enregistré pour cet objet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>