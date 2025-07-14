<?php
function db_connect() {
    try {
        $pdo = new PDO("mysql:host=172.60.0.11;dbname=db_s2_ETU004148;charset=utf8", "ETU004148", "AUhOIZIa");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur connexion DB: " . $e->getMessage());
    }
}
?>