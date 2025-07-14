<?php 
session_start();
include('../inc/function.php');

if (!isset($_SESSION['membre'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_objet = ajouterObjet($_POST['nom_objet'], $_POST['id_categorie'], $_SESSION['membre']['id_membre']);
    
    // Gestion de l'upload des images
    if (!empty($_FILES['images']['name'][0])) {
        $uploadDir = '../assets/image/uploads/';
        
        foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
            $fileName = uniqid() . '_' . basename($_FILES['images']['name'][$key]);
            $uploadFile = $uploadDir . $fileName;
            
            if (move_uploaded_file($tmpName, $uploadFile)) {
                ajouterImage($id_objet, $fileName, $key === 0 ? 1 : 0);
            }
        }
    }
    
    header('Location: liste_objets.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un objet</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Ajouter un nouvel objet</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Nom de l'objet</label>
            <input type="text" name="nom_objet" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Catégorie</label>
            <select name="id_categorie" class="form-select" required>
                <?php foreach (getCategories() as $cat): ?>
                    <option value="<?= $cat['id_categorie'] ?>"><?= htmlspecialchars($cat['nom_categorie']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Images (première image sera l'image principale)</label>
            <input type="file" name="images[]" class="form-control" multiple accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Ajouter l'objet</button>
    </form>
</div>
</body>
</html>