<?php
function dbconnect() {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=emprunt_objet', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}

function login($email, $mdp) {
    $pdo = dbconnect();
    $stmt = $pdo->prepare("SELECT * FROM membre WHERE email=? AND mdp=?");
    $stmt->execute([$email, $mdp]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function inscrire($nom, $email, $date_naissance, $mdp, $ville) {
    $pdo = dbconnect();
    $mdp_hash = password_hash($mdp, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO membre (...) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$nom, $email, $date_naissance, $mdp_hash, $ville]);
}

function getCategories() {
    $pdo = dbconnect();
    return $pdo->query("SELECT * FROM categorie_objet")->fetchAll(PDO::FETCH_ASSOC);
}

function getObjets($categorie = null, $nom = '', $disponible = false) {
    $pdo = dbconnect();
    $sql = "SELECT o.*, c.nom_categorie,
            (SELECT nom_image FROM images_objet WHERE id_objet = o.id_objet AND est_principale = 1 LIMIT 1) as nom_image,
            (SELECT date_retour FROM emprunt WHERE id_objet = o.id_objet AND date_retour > CURRENT_DATE ORDER BY date_retour DESC LIMIT 1) as retour
            FROM objet o JOIN categorie_objet c ON o.id_categorie = c.id_categorie WHERE 1=1";

    $params = [];

    if ($categorie) {
        $sql .= " AND o.id_categorie=?";
        $params[] = $categorie;
    }
    if (!empty($nom)) {
        $sql .= " AND o.nom_objet LIKE ?";
        $params[] = "%".$nom."%";
    }
    if ($disponible) {
        $sql .= " AND NOT EXISTS (SELECT 1 FROM emprunt e WHERE e.id_objet = o.id_objet AND e.date_retour > CURRENT_DATE)";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function ajouterObjet($nom_objet, $id_categorie, $id_membre) {
    $pdo = dbconnect();
    $stmt = $pdo->prepare("INSERT INTO objet (nom_objet, id_categorie, id_membre) VALUES (?, ?, ?)");
    $stmt->execute([$nom_objet, $id_categorie, $id_membre]);
    return $pdo->lastInsertId();
}

function ajouterImage($id_objet, $nom_image, $est_principale = 0) {
    $pdo = dbconnect();
    $stmt = $pdo->prepare("INSERT INTO images_objet (id_objet, nom_image, est_principale) VALUES (?, ?, ?)");
    return $stmt->execute([$id_objet, $nom_image, $est_principale]);
}

function getFicheObjet($id_objet) {
    $pdo = dbconnect();
    $stmt = $pdo->prepare("SELECT o.*, c.nom_categorie, m.nom AS nom_membre FROM objet o 
                           JOIN categorie_objet c ON o.id_categorie = c.id_categorie 
                           JOIN membre m ON o.id_membre = m.id_membre
                           WHERE o.id_objet=?");
    $stmt->execute([$id_objet]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getImagesObjet($id_objet) {
    $pdo = dbconnect();
    $stmt = $pdo->prepare("SELECT * FROM images_objet WHERE id_objet=?");
    $stmt->execute([$id_objet]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getHistoriqueEmprunts($id_objet) {
    $pdo = dbconnect();
    $stmt = $pdo->prepare("SELECT e.*, m.nom AS nom_membre FROM emprunt e 
                           JOIN membre m ON e.id_membre = m.id_membre 
                           WHERE e.id_objet=? ORDER BY e.date_emprunt DESC");
    $stmt->execute([$id_objet]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getEmprunts() {
    $pdo = dbconnect();
    $stmt = $pdo->query("SELECT e.*, o.nom_objet, m.nom AS nom_membre 
                         FROM emprunt e 
                         JOIN objet o ON e.id_objet = o.id_objet 
                         JOIN membre m ON e.id_membre = m.id_membre");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getEmpruntsByMembre($id_membre) {
    $pdo = dbconnect();
    $stmt = $pdo->prepare("SELECT e.*, o.nom_objet FROM emprunt e 
                           JOIN objet o ON e.id_objet = o.id_objet 
                           WHERE e.id_membre=?");
    $stmt->execute([$id_membre]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getFicheMembre($id_membre) {
    $pdo = dbconnect();
    $stmt = $pdo->prepare("SELECT * FROM membre WHERE id_membre=?");
    $stmt->execute([$id_membre]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function getObjetsParMembre($id_membre): array {
    $pdo = dbconnect();
    $stmt = $pdo->prepare("SELECT o.*, c.nom_categorie FROM objet o
                          JOIN categorie_objet c ON o.id_categorie = c.id_categorie
                          WHERE o.id_membre = ?");
    $stmt->execute([$id_membre]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function demanderEmprunt($id_objet, $id_membre, $date_debut, $date_fin) {
    $pdo = dbconnect();
    $stmt = $pdo->prepare("INSERT INTO emprunt (...) VALUES (?, ?, ?, ?, 'demande')");
    return $stmt->execute([$id_objet, $id_membre, $date_debut, $date_fin]);
}
function supprimerImage($id_image) {
    $pdo = dbconnect();
    $stmt = $pdo->prepare("DELETE FROM images_objet WHERE id_image=?");
    return $stmt->execute([$id_image]);
}
?>
