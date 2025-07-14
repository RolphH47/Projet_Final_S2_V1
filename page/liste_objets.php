<?php include('../inc/function.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Objets</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="accueil.php">Emprunt Objets</a>
    </div>
</nav>
<div class="container mt-4">
    <h1>Liste des Objets</h1>
    <form method="get" class="mb-3">
        <select name="categorie" class="form-select" onchange="this.form.submit()">
            <option value="">-- Toutes catégories --</option>
            <?php foreach (getCategories() as $cat) : ?>
                <option value="<?= $cat['id_categorie'] ?>" <?= isset($_GET['categorie']) && $_GET['categorie'] == $cat['id_categorie'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['nom_categorie']) ?></option>
            <?php endforeach; ?>
        </select>
    </form>
    <div class="row">
    <?php foreach (getObjets($_GET['categorie'] ?? null) as $obj) : ?>
        <div class="col-md-4 mb-3">
            <div class="card">
                <img src="../assets/image/<?= htmlspecialchars($obj['nom_image']) ?>" class="card-img-top" alt="Image Objet">
                <div class="card-body">
                    <h5 class="card-title"> <?= htmlspecialchars($obj['nom_objet']) ?> </h5>
                    <p class="card-text">Catégorie : <?= htmlspecialchars($obj['nom_categorie']) ?></p>
                    <?php if($obj['retour']): ?>
                        <p class="text-danger">Disponible après : <?= htmlspecialchars($obj['retour']) ?></p>
                    <?php else: ?>
                        <p class="text-success">Disponible maintenant</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>
</body>
</html>