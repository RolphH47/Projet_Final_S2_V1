<?php
function db_connect() {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=emprunt_objet;charset=utf8", "172.60.0.11", "AUhOIZIa");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur connexion DB: " . $e->getMessage());
    }
}
?>