<?php
session_start();
include('../inc/function.php');

$id_membre = $_GET['id'] ?? $_SESSION['membre']['id_membre'];
$membre = getFicheMembre($id_membre);
$objets = getObjetsParMembre($id_membre);
$objetsParCategorie = [];
foreach ($objets as $objet) {
    $objetsParCategorie[$objet['nom_categorie']][] = $objet;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Profil de <?= htmlspecialchars($membre['nom']) ?></title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container md-12">
        <?php include('navbar.php'); ?>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3>Informations</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Nom:</strong> <?= htmlspecialchars($membre['nom']) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($membre['email']) ?></p>
                        <p><strong>Ville:</strong> <?= htmlspecialchars($membre['ville']) ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <h3>Objets partagés</h3>

                <?php if (empty($objetsParCategorie)): ?>
                    <div class="alert alert-info">Ce membre n'a partagé aucun objet.</div>
                <?php else: ?>
                    <?php foreach ($objetsParCategorie as $categorie => $objets): ?>
                        <div class="mb-4">
                            <h4 class="border-bottom pb-2"><?= htmlspecialchars($categorie) ?></h4>
                            <div class="row">
                                <?php foreach ($objets as $objet): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100">
                                            <a href="fiche_objet.php?id=<?= $objet['id_objet'] ?>">
                                                <?php
                                                $image = getImagesObjet($objet['id_objet']);
                                                if (!empty($image)): ?>
                                                    <img src="../assets/image/<?= htmlspecialchars($image[0]['nom_image']) ?>" class="card-img-top obj-img" alt="<?= htmlspecialchars($objet['nom_objet']) ?>">
                                                <?php else: ?>
                                                    <img src="../assets/image/default.jpg" class="card-img-top obj-img" alt="Image par défaut">
                                                <?php endif; ?>
                                            </a>
                                            <div class="card-body">
                                                <h5 class="card-title"><?= htmlspecialchars($objet['nom_objet']) ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>