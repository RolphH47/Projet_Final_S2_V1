<?php include('../inc/function.php'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Objets</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1>Liste des Objets</h1>
    
    <form method="get" class="mb-4 p-3 bg-light rounded">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Catégorie</label>
                <select name="categorie" class="form-select">
                    <option value="">Toutes catégories</option>
                    <?php foreach (getCategories() as $cat): ?>
                        <option value="<?= $cat['id_categorie'] ?>" <?= ($_GET['categorie'] ?? '') == $cat['id_categorie'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['nom_categorie']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Nom de l'objet</label>
                <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($_GET['nom'] ?? '') ?>">
            </div>
            <div class="col-md-4">
                <div class="form-check mt-4 pt-3">
                    <input class="form-check-input" type="checkbox" name="disponible" id="disponible" <?= isset($_GET['disponible']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="disponible">Disponible uniquement</label>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Rechercher</button>
                <a href="liste_objets.php" class="btn btn-secondary">Réinitialiser</a>
            </div>
        </div>
    </form>

    <div class="row">
        <?php 
        $objets = getObjets(
            $_GET['categorie'] ?? null,
            $_GET['nom'] ?? '',
            isset($_GET['disponible'])
        );
        
        foreach ($objets as $obj): 
        ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <a href="fiche_objet.php?id=<?= $obj['id_objet'] ?>">
                        <?php if(!empty($obj['nom_image'])): ?>
                            <img src="../assets/image/<?= htmlspecialchars($obj['nom_image']) ?>" class="card-img-top obj-img" alt="<?= htmlspecialchars($obj['nom_objet']) ?>">
                        <?php else: ?>
                            <img src="../assets/image/default.jpg" class="card-img-top obj-img" alt="Image par défaut">
                        <?php endif; ?>
                    </a>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($obj['nom_objet']) ?></h5>
                        <p class="card-text">Catégorie: <?= htmlspecialchars($obj['nom_categorie']) ?></p>
                        <?php if($obj['retour']): ?>
                            <p class="text-danger">Disponible après: <?= htmlspecialchars($obj['retour']) ?></p>
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