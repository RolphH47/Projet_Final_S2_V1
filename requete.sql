CREATE DATABASE IF NOT EXISTS emprunt_objet;
USE emprunt_objet;

CREATE TABLE membre (
    id_membre INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    date_naissance DATE,
    genre ENUM('Homme', 'Femme', 'Autre'),
    email VARCHAR(100),
    ville VARCHAR(100),
    mdp VARCHAR(255),
    image_profil VARCHAR(100)
);

CREATE TABLE categorie_objet (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom_categorie VARCHAR(100)
);

CREATE TABLE objet (
    id_objet INT AUTO_INCREMENT PRIMARY KEY,
    nom_objet VARCHAR(100),
    id_categorie INT,
    id_membre INT,
    FOREIGN KEY (id_categorie) REFERENCES categorie_objet(id_categorie),
    FOREIGN KEY (id_membre) REFERENCES membre(id_membre)
);

CREATE TABLE images_objet (
    id_image INT AUTO_INCREMENT PRIMARY KEY,
    id_objet INT,
    nom_image VARCHAR(100),
    FOREIGN KEY (id_objet) REFERENCES objet(id_objet)
);

CREATE TABLE emprunt (
    id_emprunt INT AUTO_INCREMENT PRIMARY KEY,
    id_objet INT,
    id_membre INT,
    date_emprunt DATE,
    date_retour DATE,
    FOREIGN KEY (id_objet) REFERENCES objet(id_objet),
    FOREIGN KEY (id_membre) REFERENCES membre(id_membre)
);

INSERT INTO membre (nom, date_naissance, genre, email, ville, mdp, image_profil) VALUES
('Jean Dupont', '1990-05-12', 'Homme', 'jean@gmail.com', 'Paris', 'mdp123', 'jean.png'),
('Alice Martin', '1995-07-22', 'Femme', 'alice@gmail.com', 'Lyon', 'mdp456', 'alice.png'),
('Paul Durand', '1992-11-03', 'Homme', 'paul@gmail.com', 'Marseille', 'mdp789', 'paul.png'),
('Rolph Dure', '2000-08-04', 'Homme', 'Rolph@gmail.com', 'Tana', '123456', 'rolph.png'),
('Emma Lefevre', '2000-01-15', 'Femme', 'emma@gmail.com', 'Bordeaux', 'mdp101', 'emma.png');

INSERT INTO categorie_objet (nom_categorie) VALUES
('Esthétique'), ('Bricolage'), ('Mécanique'), ('Cuisine');

INSERT INTO objet (nom_objet, id_categorie, id_membre) VALUES
('Sèche-cheveux', 1, 1), ('Lime à ongles', 1, 1), ('Perceuse', 2, 2), ('Tournevis', 2, 2),
('Clé à molette', 3, 3), ('Pompe à vélo', 3, 3), ('Batteur électrique', 4, 4), ('Mixeur', 4, 4),
('Fer à lisser', 1, 4), ('Scie sauteuse', 2, 3);

INSERT INTO images_objet (id_objet, nom_image) VALUES
(1, 'seche.jpg'), (2, 'lime.jpg'), (3, 'perceuse.jpeg'), (4, 'tournevis.jpeg'),
(5, 'cle.jpeg'), (6, 'pompe.jpg'), (7, 'batteur.jpg'), (8, 'mixeur.jpg'),
(9, 'fer.jpg'), (10, 'scie.jpg');

INSERT INTO emprunt (id_objet, id_membre, date_emprunt, date_retour) VALUES
(1, 2, '2025-07-01', '2025-07-05'),
(3, 1, '2025-07-02', '2025-07-06'),
(5, 4, '2025-07-03', '2025-07-07'),
(7, 3, '2025-07-04', '2025-07-08'),
(2, 3, '2025-07-05', '2025-07-09'),
(4, 1, '2025-07-06', '2025-07-10'),
(6, 2, '2025-07-07', '2025-07-11'),
(8, 4, '2025-07-08', '2025-07-12'),
(9, 1, '2025-07-09', '2025-07-13'),
(10, 2, '2025-07-10', '2025-07-14');
