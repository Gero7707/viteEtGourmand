CREATE DATABASE IF NOT EXISTS vite_et_gourmand_test;
USE vite_et_gourmand_test;

CREATE TABLE  role(
    role_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    libelle VARCHAR(50) NOT NULL
);

CREATE TABLE theme(
    theme_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    libelle VARCHAR(50) NOT NULL
);

CREATE TABLE regime(
    regime_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    libelle VARCHAR(50) NOT NULL
);

CREATE TABLE allergene(
    allergene_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    libelle VARCHAR(100) NOT NULL
);

CREATE TABLE horaire(
    horaire_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    jour VARCHAR(10) NOT NULL,
    heure_ouverture TIME NOT NULL,
    heure_fermeture TIME NOT NULL
);

CREATE TABLE utilisateur (
    utilisateur_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    reset_token VARCHAR(255) NULL,
    reset_token_expires_at DATETIME NULL,
    nom VARCHAR(100)  NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    gsm VARCHAR(20),
    ville VARCHAR(100),
    adresse VARCHAR(255),
    code_postal VARCHAR(10),
    actif TINYINT(1)  DEFAULT 1,
    role_id INT NOT NULL,
    FOREIGN KEY (role_id) REFERENCES role(role_id)
);

CREATE TABLE menu(
    menu_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    regime_id INT,
    theme_id INT,
    titre VARCHAR(255) NOT NULL,
    nombre_personne_minimum INT NOT NULL,
    prix_par_personne DECIMAL(10,2) NOT NULL,
    description TEXT NOT NULL,
    quantite_restante INT,
    conditions_delai TEXT,
    conditions_stockage TEXT,
    conditions_infos TEXT, 
    FOREIGN KEY (regime_id) REFERENCES regime(regime_id),
    FOREIGN KEY (theme_id)REFERENCES theme(theme_id)
);

CREATE TABLE plat(
    plat_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    titre_plat VARCHAR(255) NOT NULL,
    type_plat ENUM('entree' , 'plat' , 'dessert') NOT NULL,
    chemin_photo VARCHAR(255)
);

CREATE TABLE image_menu(
    image_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    menu_id INT NOT NULL,
    chemin VARCHAR(255) NOT NULL,
    FOREIGN KEY (menu_id) REFERENCES menu(menu_id)
);

CREATE TABLE commande(
    commande_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    utilisateur_id INT NOT NULL,
    menu_id INT,
    adresse_livraison VARCHAR(255) NOT NULL,
    ville varchar(100) DEFAULT NULL,
    code_postal varchar(10) DEFAULT NULL,
    distance_km DECIMAL(10,2),
    numero_commande VARCHAR(50) UNIQUE NOT NULL,
    date_commande DATETIME NOT NULL,
    date_prestation DATE NOT NULL,
    heure_livraison TIME,
    prix_menu DECIMAL(10,2) NOT NULL,
    nombre_personne INT NOT NULL,
    prix_livraison DECIMAL(10,2),
    statut VARCHAR(50) NOT NULL,
    pret_materiel TINYINT(1)  DEFAULT 0,
    restitution_materiel TINYINT(1)  DEFAULT 0,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(utilisateur_id),
    FOREIGN KEY (menu_id) REFERENCES menu(menu_id)  ON DELETE SET NULL
);

CREATE TABLE historique_statut(
    historique_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    commande_id INT NOT NULL,
    commentaires TEXT,
    statut VARCHAR(50) NOT NULL,
    date_modification DATETIME NOT NULL,
    FOREIGN KEY (commande_id)REFERENCES commande(commande_id)
);

CREATE TABLE avis(
    avis_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    commande_id INT NOT NULL,
    utilisateur_id INT NOT NULL,
    note INT NOT NULL,
    description TEXT,
    statut VARCHAR(20) NOT NULL,
    date_avis DATETIME NOT NULL,
    deleted_at DATETIME DEFAULT NULL,
    FOREIGN KEY (commande_id) REFERENCES commande(commande_id),
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(utilisateur_id)
);

CREATE TABLE menu_plat (
    menu_id INT NOT NULL,
    plat_id INT NOT NULL,
    PRIMARY KEY (menu_id, plat_id),
    FOREIGN KEY (menu_id) REFERENCES menu(menu_id),
    FOREIGN KEY (plat_id) REFERENCES plat(plat_id)
);


CREATE TABLE plat_allergene(
    plat_id INT NOT NULL,
    allergene_id INT NOT NULL, 
    PRIMARY KEY (plat_id, allergene_id),
    FOREIGN KEY (plat_id) REFERENCES plat(plat_id),
    FOREIGN KEY (allergene_id) REFERENCES allergene(allergene_id)
);

CREATE TABLE login_attempts (
    attempt_id INT NOT NULL AUTO_INCREMENT,
    ip VARCHAR(45) NOT NULL,
    email VARCHAR(255) NOT NULL,
    attempted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (attempt_id)
);



