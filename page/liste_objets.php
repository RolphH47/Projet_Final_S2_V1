<?php
session_start();
require '../inc/function.php';

// Récupération des paramètres de recherche
$categorie = $_GET['categorie'] ?? null;
$nom = $_GET['nom'] ?? '';
$disponible = isset($_GET['disponible']);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des Objets</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <style>
        .card {
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .obj-img {
            height: 200px;
            object-fit: cover;
        }

        .disponible-badge {
            position: absolute;
            top: 10px;
            right: 10px;
        }
    </style>
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="container mt-4">
        <h1 class="mb-4">Liste des Objets</h1>
        <div class="card mb-4">
            <div class="card-body">
                <form method="get" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Catégorie</label>
                        <select name="categorie" class="form-select">
                            <option value="">Toutes catégories</option>
                            <?php foreach (getCategories() as $cat): ?>
                                <option value="<?= $cat['id_categorie'] ?>"
                                    <?= ($categorie == $cat['id_categorie']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['nom_categorie']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nom de l'objet</label>
                        <input type="text" name="nom" class="form-control"
                            value="<?= htmlspecialchars($nom) ?>"
                            placeholder="Rechercher par nom...">
                    </div>
                    <div class="col-md-4">
                        <div class="form-check mt-4 pt-3">
                            <input class="form-check-input" type="checkbox"
                                name="disponible" id="disponible"
                                <?= $disponible ? 'checked' : '' ?>>
                            <label class="form-check-label" for="disponible">
                                Disponible uniquement
                            </label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Rechercher
                        </button>
                        <a href="liste_objets.php" class="btn btn-outline-secondary">
                            Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <?php
            $objets = getObjets($categorie, $nom, $disponible);

            if (empty($objets)): ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        Aucun objet trouvé avec ces critères de recherche.
                    </div>
                </div>
                <?php else:
                foreach ($objets as $obj):
                    $estDisponible = empty($obj['retour']);
                ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="position-relative">
                                <a href="fiche_objet.php?id=<?= $obj['id_objet'] ?>">
                                    <?php if (!empty($obj['nom_image'])): ?>
                                        <img src="../assets/image/<?= htmlspecialchars($obj['nom_image']) ?>"
                                            class="card-img-top obj-img"
                                            alt="<?= htmlspecialchars($obj['nom_objet']) ?>">
                                    <?php else: ?>
                                        <img src="../assets/image/default.jpg"
                                            class="card-img-top obj-img"
                                            alt="Image par défaut">
                                    <?php endif; ?>
                                </a>
                                <span class="badge bg-<?= $estDisponible ? 'success' : 'danger' ?> disponible-badge">
                                    <?= $estDisponible ? 'Disponible' : 'Indisponible' ?>
                                </span>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="fiche_objet.php?id=<?= $obj['id_objet'] ?>"
                                        class="text-decoration-none text-dark">
                                        <?= htmlspecialchars($obj['nom_objet']) ?>
                                    </a>
                                </h5>
                                <p class="card-text text-muted">
                                    Catégorie: <?= htmlspecialchars($obj['nom_categorie']) ?>
                                </p>

                                <?php if (!$estDisponible): ?>
                                    <p class="text-danger">
                                        <i class="bi bi-calendar-x"></i> Disponible après: <?= htmlspecialchars($obj['retour']) ?>
                                    </p>
                                <?php endif; ?>                          
                                <div class="mt-3">
                                    <?php if (isset($_SESSION['membre'])): ?>
                                        <?php if ($estDisponible): ?>
                                            <form method="post" action="demander_emprunt.php">
                                                <input type="hidden" name="id_objet" value="<?= $obj['id_objet'] ?>">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="bi bi-basket"></i> Emprunter
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <button class="btn btn-secondary w-100" disabled>
                                                <i class="bi bi-lock"></i> Indisponible
                                            </button>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <a href="../login.php" class="btn btn-warning w-100">
                                            <i class="bi bi-box-arrow-in-right"></i> Connectez-vous pour emprunter
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php endforeach;
            endif; ?>
        </div>
    </div>
</body>

</html>