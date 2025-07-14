<?php
function db_connect() {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=emprunt_objet;charset=utf8", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur connexion DB: " . $e->getMessage());
    }
}
?>