<?php
include('connexion.php');


function getPDO() {
    return db_connect();
}

// Récupérer toutes les catégories
function getCategories() {
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT * FROM categorie_objet");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer objets avec ou sans filtre
function getObjets($categorie = null) {
    $pdo = getPDO();
    $where = $categorie ? " WHERE o.id_categorie = " . intval($categorie) : "";
    $sql = "SELECT o.id_objet, o.nom_objet, c.nom_categorie, i.nom_image,
                   (SELECT date_retour FROM emprunt e WHERE e.id_objet=o.id_objet AND e.date_retour > NOW() LIMIT 1) AS retour
            FROM objet o
            JOIN categorie_objet c ON o.id_categorie = c.id_categorie
            LEFT JOIN images_objet i ON o.id_objet = i.id_objet
            $where";
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

// Login : vérifier email + mot de passe
function login($email, $mdp) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("SELECT * FROM membre WHERE email = ? AND mdp = ?");
    $stmt->execute([$email, $mdp]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Inscription : ajout d'un membre
function inscrire($nom, $email, $date_naissance ,$mdp, $ville) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("INSERT INTO membre (nom, email, date_naissance, mdp, ville) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$nom, $email, $date_naissance ,$mdp, $ville]);
}
function getEmpruntsByMembre($id_membre) {
    $pdo = getPDO();
    $sql = "SELECT e.date_emprunt, e.date_retour, o.nom_objet
            FROM emprunt e
            JOIN objet o ON e.id_objet = o.id_objet
            WHERE e.id_membre = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_membre]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Récupérer liste des emprunts
function getEmprunts() {
    $pdo = getPDO();
    $sql = "SELECT e.date_emprunt, e.date_retour, o.nom_objet, m.nom as nom_membre
            FROM emprunt e
            JOIN objet o ON e.id_objet = o.id_objet
            JOIN membre m ON e.id_membre = m.id_membre";
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}
?>
