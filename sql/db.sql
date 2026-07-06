CREATE DATABASE IF NOT EXISTS vite_et_gourmand;
USE vite_et_gourmand;

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

CREATE TABLE login_attempts (
    attempt_id INT PRIMARY KEY AUTO_INCREMENT,
    ip VARCHAR(45) NOT NULL,
    email VARCHAR(255) NOT NULL,
    attempted_at DATETIME DEFAULT CURRENT_TIMESTAMP
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
    menu_id INT NOT NULL,
    adresse_livraison VARCHAR(255) NOT NULL,
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
    FOREIGN KEY (menu_id) REFERENCES menu(menu_id)
);

CREATE TABLE historique_statut(
    historique_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    commande_id INT NOT NULL,
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



#Données pour tests


INSERT INTO role (libelle) VALUES ('utilisateur'),('employé'),('administrateur');


INSERT INTO regime (libelle) VALUES ('Classique');    -- regime_id = 1
INSERT INTO regime (libelle) VALUES ('Végétarien');   -- regime_id = 2
INSERT INTO regime (libelle) VALUES ('Vegan');        -- regime_id = 3


INSERT INTO theme (libelle) VALUES ('Classique');     -- theme_id = 1
INSERT INTO theme (libelle) VALUES ('Noël');          -- theme_id = 2
INSERT INTO theme (libelle) VALUES ('Pâques');        -- theme_id = 3
INSERT INTO theme (libelle) VALUES ('Événement');     -- theme_id = 4


INSERT INTO allergene (libelle) VALUES ('gluten'),('lait'),('oeufs'),('fruits à coque'),('soja'),('sulfites'),('crustacés');


INSERT INTO horaire (jour,heure_ouverture,heure_fermeture) VALUES('Mardi' , '13:00' , '18:00'),('Mercredi' , '09:00' , '18:00'),('Jeudi' , '09:00' , '18:00'),('Vendredi' , '09:00' , '18:00'),('Samedi' , '09:00' , '14:00'),('Dimanche' , '09:00' , '14:00');


-- Administrateur (José, le patron)
-- role_id : 1 = utilisateur, 2 = employé, 3 = administrateur
INSERT INTO utilisateur (email, password, nom, prenom, gsm, ville, adresse, code_postal, actif, role_id) VALUES
('jose@viteetgourmand.fr', '$2y$10$DxunKO6UYBNm4qiTvhseGOT30pxciUkGWqmkUSh/CY/xLlqoJWa8u', 'Martinez', 'José', '0556123456', 'Bordeaux', '15 rue Sainte-Catherine', '33000', 1, 3),
('julie@viteetgourmand.fr', '$2y$10$DxunKO6UYBNm4qiTvhseGOT30pxciUkGWqmkUSh/CY/xLlqoJWa8u', 'Martinez', 'Julie', '0556789012', 'Bordeaux', '15 rue Sainte-Catherine', '33000', 1, 2),
('sophie.martin@email.fr', '$2y$10$DxunKO6UYBNm4qiTvhseGOT30pxciUkGWqmkUSh/CY/xLlqoJWa8u', 'Martin', 'Sophie', '0612345678', 'Bordeaux', '42 cours Victor Hugo', '33000', 1, 1),
('laurent.dubois@email.fr', '$2y$10$DxunKO6UYBNm4qiTvhseGOT30pxciUkGWqmkUSh/CY/xLlqoJWa8u', 'Dubois', 'Laurent', '0623456789', 'Mérignac', '8 avenue de la Marne', '33700', 1, 1),
('camille.rousseau@email.fr', '$2y$10$DxunKO6UYBNm4qiTvhseGOT30pxciUkGWqmkUSh/CY/xLlqoJWa8u', 'Rousseau', 'Camille', '0634567890', 'Pessac', '23 rue Jean Jaurès', '33600', 1, 1),
('marc.thomas@email.fr', '$2y$10$DxunKO6UYBNm4qiTvhseGOT30pxciUkGWqmkUSh/CY/xLlqoJWa8u', 'Thomas', 'Marc', '0645678901', 'Libourne', '5 place de la Mairie', '33500', 1, 1);


INSERT INTO menu (titre, nombre_personne_minimum ,prix_par_personne, description , quantite_restante , conditions_delai , conditions_stockage, conditions_infos , regime_id, theme_id) 
VALUES ('Menu Prestige' , 10 , 45.00 , 'Un menu d''exception pour vos réceptions les plus élégantes. Foie gras, filet de bœuf en croûte et trilogie de chocolat.' , 20 , 'Toute commande doit être passée au minimum 72 heures (3 jours ouvrés) avant la date de l''événement. Pour les commandes de plus de 30 personnes, un délai de 7 jours ouvrés est requis.' , 'Les plats sont livrés sous emballage isotherme. Ils doivent être conservés au réfrigérateur (entre 0°C et 4°C) et consommés dans les 24 heures suivant la livraison. Ne pas recongeler.' , 'Du matériel de service (assiettes, couverts, nappes) est prêté gratuitement pour la durée de l''événement. La restitution doit être effectuée sous 10 jours ouvrés après l''événement. Passé ce délai, une pénalité forfaitaire de 600€ sera facturée. Toute modification ou annulation de commande est possible tant que la commande n''a pas été acceptée par notre équipe.' , 1 , 1),
('Menu Jardin d''Été', 8, 35.00, 'Des saveurs fraîches et légères pour vos événements estivaux. Gaspacho de tomates anciennes, risotto aux légumes grillés et panna cotta à la verveine.', 15, 'Toute commande doit être passée au minimum 72 heures (3 jours ouvrés) avant la date de l''événement. Pour les commandes de plus de 30 personnes, un délai de 7 jours ouvrés est requis.', 'Les plats sont livrés sous emballage isotherme. Ils doivent être conservés au réfrigérateur (entre 0°C et 4°C) et consommés dans les 24 heures suivant la livraison. Ne pas recongeler.', 'Du matériel de service (assiettes, couverts, nappes) est prêté gratuitement pour la durée de l''événement. La restitution doit être effectuée sous 10 jours ouvrés après l''événement. Passé ce délai, une pénalité forfaitaire de 600€ sera facturée. Toute modification ou annulation de commande est possible tant que la commande n''a pas été acceptée par notre équipe.', 2, 1),
('Menu Réveillon', 12, 55.00, 'Un festin de Noël pour émerveiller vos convives. Velouté de châtaignes à la truffe, chapon farci aux marrons et bûche glacée aux trois chocolats.', 10, 'Toute commande doit être passée au minimum 72 heures (3 jours ouvrés) avant la date de l''événement. Pour les commandes de plus de 30 personnes, un délai de 7 jours ouvrés est requis.', 'Les plats sont livrés sous emballage isotherme. Ils doivent être conservés au réfrigérateur (entre 0°C et 4°C) et consommés dans les 24 heures suivant la livraison. Ne pas recongeler.', 'Du matériel de service (assiettes, couverts, nappes) est prêté gratuitement pour la durée de l''événement. La restitution doit être effectuée sous 10 jours ouvrés après l''événement. Passé ce délai, une pénalité forfaitaire de 600€ sera facturée. Toute modification ou annulation de commande est possible tant que la commande n''a pas été acceptée par notre équipe.', 1, 2),
('Menu Renouveau', 6, 38.00, 'Un menu 100% végétal aux couleurs du printemps. Tartare d''avocat et mangue, tajine de légumes printaniers et fondant au chocolat noir.', 10, 'Toute commande doit être passée au minimum 72 heures (3 jours ouvrés) avant la date de l''événement. Pour les commandes de plus de 30 personnes, un délai de 7 jours ouvrés est requis.', 'Les plats sont livrés sous emballage isotherme. Ils doivent être conservés au réfrigérateur (entre 0°C et 4°C) et consommés dans les 24 heures suivant la livraison. Ne pas recongeler.', 'Du matériel de service (assiettes, couverts, nappes) est prêté gratuitement pour la durée de l''événement. La restitution doit être effectuée sous 10 jours ouvrés après l''événement. Passé ce délai, une pénalité forfaitaire de 600€ sera facturée. Toute modification ou annulation de commande est possible tant que la commande n''a pas été acceptée par notre équipe.', 3, 3),
('Menu Gala' , 20 , 60.00 , 'Un menu prestigieux pour vos galas et soirées d''entreprise. Carpaccio de Saint-Jacques, suprême de volaille aux morilles et opéra revisité.' , 20 , 'Toute commande doit être passée au minimum 72 heures (3 jours ouvrés) avant la date de l''événement. Pour les commandes de plus de 30 personnes, un délai de 7 jours ouvrés est requis.' , 'Les plats sont livrés sous emballage isotherme. Ils doivent être conservés au réfrigérateur (entre 0°C et 4°C) et consommés dans les 24 heures suivant la livraison. Ne pas recongeler.' , 'Du matériel de service (assiettes, couverts, nappes) est prêté gratuitement pour la durée de l''événement. La restitution doit être effectuée sous 10 jours ouvrés après l''événement. Passé ce délai, une pénalité forfaitaire de 600€ sera facturée. Toute modification ou annulation de commande est possible tant que la commande n''a pas été acceptée par notre équipe.' , 1 , 4),
('Menu Champêtre' , 8 , 32.00 , 'Un menu frais et convivial pour vos réceptions en plein air. Velouté glacé de petits pois à la menthe, tarte fine aux légumes du soleil et pavlova aux fruits rouges.' , 16 , 'Toute commande doit être passée au minimum 72 heures (3 jours ouvrés) avant la date de l''événement. Pour les commandes de plus de 30 personnes, un délai de 7 jours ouvrés est requis.' , 'Les plats sont livrés sous emballage isotherme. Ils doivent être conservés au réfrigérateur (entre 0°C et 4°C) et consommés dans les 24 heures suivant la livraison. Ne pas recongeler.' , 'Du matériel de service (assiettes, couverts, nappes) est prêté gratuitement pour la durée de l''événement. La restitution doit être effectuée sous 10 jours ouvrés après l''événement. Passé ce délai, une pénalité forfaitaire de 600€ sera facturée. Toute modification ou annulation de commande est possible tant que la commande n''a pas été acceptée par notre équipe.' , 2 , 4),
('Menu Féérie d''Hiver' , 10 , 42.00 , 'Un menu 100% végétal aux saveurs chaleureuses de l''hiver. Velouté de butternut rôti aux épices, wellington de champignons aux marrons et bûche glacée au chocolat noir et orange.' , 20 , 'Toute commande doit être passée au minimum 72 heures (3 jours ouvrés) avant la date de l''événement. Pour les commandes de plus de 30 personnes, un délai de 7 jours ouvrés est requis.' , 'Les plats sont livrés sous emballage isotherme. Ils doivent être conservés au réfrigérateur (entre 0°C et 4°C) et consommés dans les 24 heures suivant la livraison. Ne pas recongeler.' , 'Du matériel de service (assiettes, couverts, nappes) est prêté gratuitement pour la durée de l''événement. La restitution doit être effectuée sous 10 jours ouvrés après l''événement. Passé ce délai, une pénalité forfaitaire de 600€ sera facturée. Toute modification ou annulation de commande est possible tant que la commande n''a pas été acceptée par notre équipe.' , 3 , 2),
('Menu Brunch de Pâques' , 6 , 30.00 , 'Un brunch festif pour célébrer Pâques en famille. Œufs brouillés aux asperges et saumon fumé, carré d''agneau aux herbes de Provence et nid de Pâques en chocolat.' , 12 , 'Toute commande doit être passée au minimum 72 heures (3 jours ouvrés) avant la date de l''événement. Pour les commandes de plus de 30 personnes, un délai de 7 jours ouvrés est requis.' , 'Les plats sont livrés sous emballage isotherme. Ils doivent être conservés au réfrigérateur (entre 0°C et 4°C) et consommés dans les 24 heures suivant la livraison. Ne pas recongeler.' , 'Du matériel de service (assiettes, couverts, nappes) est prêté gratuitement pour la durée de l''événement. La restitution doit être effectuée sous 10 jours ouvrés après l''événement. Passé ce délai, une pénalité forfaitaire de 600€ sera facturée. Toute modification ou annulation de commande est possible tant que la commande n''a pas été acceptée par notre équipe.' , 1 , 3);




INSERT INTO plat (titre_plat, type_plat, chemin_photo) VALUES
-- Menu Prestige (plat_id 1-3)
('Foie gras mi-cuit et son chutney de figues', 'entree', 'assets/img/plats/foie-gras.jpg'),
('Filet de bœuf en croûte, jus au porto, gratin dauphinois', 'plat', 'assets/img/plats/filet-boeuf.jpg'),
('Trilogie de chocolat — mousse, fondant, croustillant', 'dessert', 'assets/img/plats/trilogie-chocolat.jpg'),

-- Menu Jardin d'Été (plat_id 4-6)
('Gaspacho de tomates anciennes et basilic frais', 'entree', 'assets/img/plats/gaspacho.jpg'),
('Risotto aux légumes grillés et parmesan', 'plat', 'assets/img/plats/risotto-legumes.jpg'),
('Panna cotta à la verveine et coulis de framboise', 'dessert', 'assets/img/plats/panna-cotta.jpg'),

-- Menu Réveillon (plat_id 7-9)
('Velouté de châtaignes à la truffe', 'entree', 'assets/img/plats/veloute-chataignes.jpg'),
('Chapon farci aux marrons et sauce au cognac', 'plat', 'assets/img/plats/chapon-marrons.jpg'),
('Bûche glacée aux trois chocolats', 'dessert', 'assets/img/plats/buche-chocolats.jpg'),

-- Menu Renouveau (plat_id 10-12)
('Tartare d''avocat et mangue aux graines germées', 'entree', 'assets/img/plats/tartare-avocat.jpg'),
('Tajine de légumes printaniers aux épices douces', 'plat', 'assets/img/plats/tajine-legumes.jpg'),
('Fondant au chocolat noir et coulis de fruits rouges', 'dessert', 'assets/img/plats/fondant-chocolat.jpg'),

-- Menu Gala (plat_id 13-15)
('Carpaccio de Saint-Jacques aux agrumes', 'entree', 'assets/img/plats/carpaccio-stjacques.jpg'),
('Suprême de volaille aux morilles et jus réduit', 'plat', 'assets/img/plats/supreme-volaille.jpg'),
('Opéra revisité au café et caramel beurre salé', 'dessert', 'assets/img/plats/opera.jpg'),

-- Menu Champêtre (plat_id 16-18)
('Velouté glacé de petits pois à la menthe', 'entree', 'assets/img/plats/veloute-petitspois.jpg'),
('Tarte fine aux légumes du soleil et chèvre frais', 'plat', 'assets/img/plats/tarte-legumes.jpg'),
('Pavlova aux fruits rouges et crème de mascarpone', 'dessert', 'assets/img/plats/pavlova.jpg'),

-- Menu Féérie d'Hiver (plat_id 19-21)
('Velouté de butternut rôti aux épices et lait de coco', 'entree', 'assets/img/plats/veloute-butternut.jpg'),
('Wellington de champignons aux marrons et sauce forestière', 'plat', 'assets/img/plats/wellington.jpg'),
('Bûche glacée au chocolat noir et orange confite', 'dessert', 'assets/img/plats/buche-orange.jpg'),

-- Menu Brunch de Pâques (plat_id 22-24)
('Œufs brouillés aux asperges et saumon fumé', 'entree', 'assets/img/plats/oeufs-asperges.jpg'),
('Carré d''agneau aux herbes de Provence et légumes rôtis', 'plat', 'assets/img/plats/carre-agneau.jpg'),
('Nid de Pâques en chocolat et mousse de framboise', 'dessert', 'assets/img/plats/nid-paques.jpg');



INSERT INTO image_menu (menu_id, chemin) VALUES
(1, 'assets/img/menus/prestige.jpg'),
(2, 'assets/img/menus/jardin-ete.jpg'),
(3, 'assets/img/menus/reveillon.jpg'),
(4, 'assets/img/menus/renouveau.jpg'),
(5, 'assets/img/menus/gala.jpg'),
(6, 'assets/img/menus/champetre.jpg'),
(7, 'assets/img/menus/feerie-hiver.jpg'),
(8, 'assets/img/menus/brunch-paques.jpg');


INSERT INTO menu_plat (menu_id, plat_id) VALUES
(1, 1), (1, 2), (1, 3),
(2, 4), (2, 5), (2, 6),
(3, 7), (3, 8), (3, 9),
(4, 10), (4, 11), (4, 12),
(5, 13), (5, 14), (5, 15),
(6, 16), (6, 17), (6, 18),
(7, 19), (7, 20), (7, 21),
(8, 22), (8, 23), (8, 24);


INSERT INTO plat_allergene (plat_id, allergene_id) VALUES
-- Menu Prestige
(1, 6), (1, 4),          -- Foie gras : sulfites, fruits à coque
(2, 1), (2, 2), (2, 3),  -- Filet de bœuf en croûte : gluten, lait, œufs
(3, 2), (3, 3), (3, 5),  -- Trilogie chocolat : lait, œufs, soja

-- Menu Jardin d'Été
(4, 6),                   -- Gaspacho : sulfites
(5, 2),                   -- Risotto : lait
(6, 2), (6, 3),           -- Panna cotta : lait, œufs

-- Menu Réveillon
(7, 2), (7, 4),           -- Velouté châtaignes : lait, fruits à coque
(8, 1), (8, 2),           -- Chapon farci : gluten, lait
(9, 2), (9, 3), (9, 5),   -- Bûche glacée : lait, œufs, soja

-- Menu Renouveau (vegan — peu d'allergènes)
(10, 4),                   -- Tartare avocat : fruits à coque
(11, 1),                   -- Tajine : gluten
(12, 5),                   -- Fondant chocolat : soja

-- Menu Gala
(13, 7),                   -- Carpaccio Saint-Jacques : crustacés
(14, 1), (14, 2),          -- Suprême volaille : gluten, lait
(15, 1), (15, 2), (15, 3), -- Opéra : gluten, lait, œufs

-- Menu Champêtre
(16, 2),                   -- Velouté petits pois : lait
(17, 1), (17, 2),          -- Tarte fine : gluten, lait
(18, 2), (18, 3),          -- Pavlova : lait, œufs

-- Menu Féérie d'Hiver (vegan)
(19, 4),                   -- Velouté butternut : fruits à coque
(20, 1), (20, 4),          -- Wellington : gluten, fruits à coque
(21, 5),                   -- Bûche chocolat noir : soja

-- Menu Brunch de Pâques
(22, 2), (22, 3),          -- Œufs brouillés : lait, œufs
(23, 2),                   -- Carré agneau : lait
(24, 1), (24, 2), (24, 3); -- Nid de Pâques : gluten, lait, œufs








-- Commandes avec statuts variés
INSERT INTO commande (utilisateur_id, menu_id, adresse_livraison, code_postal , ville, distance_km, numero_commande, date_commande, date_prestation, heure_livraison, prix_menu, nombre_personne, prix_livraison, statut, pret_materiel, restitution_materiel) VALUES
-- Sophie (Bordeaux, livraison gratuite)
(3, 1, '42 cours Victor Hugo' , '33000' , 'Bordeaux', 0, 'CMD-2026-001', '2026-03-10 14:30:00', '2026-03-20', '12:00', 450.00, 10, 0, 'terminee', 1, 1),
(3, 4, '42 cours Victor Hugo' , '33000' ,'Bordeaux', 0, 'CMD-2026-002', '2026-04-01 10:15:00', '2026-04-10', '11:00', 228.00, 6, 0, 'terminee', 1, 1),

-- Laurent (Mérignac, 8km, frais livraison)
(4, 5, '8 avenue de la Marne' , '33700' , 'Mérignac', 8, 'CMD-2026-003', '2026-03-15 09:00:00', '2026-03-25', '19:00', 1200.00, 20, 9.72, 'terminee', 1, 1),
(4, 3, '8 avenue de la Marne', '33700' , 'Mérignac', 8, 'CMD-2026-004', '2026-11-20 16:45:00', '2026-12-24', '12:00', 660.00, 12, 9.72, 'en_preparation', 0, 0),

-- Camille (Pessac, 12km)
(5, 7, '23 rue Jean Jaurès', '33600' , 'Pessac', 12, 'CMD-2026-005', '2026-11-25 11:30:00', '2026-12-20', '18:00', 630.00, 15, 12.08, 'acceptee', 0, 0),
(5, 2, '23 rue Jean Jaurès', '33600' , 'Pessac', 12, 'CMD-2026-006', '2026-06-01 08:00:00', '2026-06-15', '12:30', 280.00, 8, 12.08, 'terminee', 1, 0),

-- Marc (Libourne, 30km)
(6, 8, '5 place de la Mairie', '33500' , 'Libourne', 30, 'CMD-2026-007', '2026-03-20 17:00:00', '2026-04-05', '11:30', 300.00, 10, 22.70, 'terminee', 1, 1),
(6, 6, '5 place de la Mairie','33500' , 'Libourne', 30, 'CMD-2026-008', '2026-07-10 14:00:00', '2026-07-25', '18:00', 512.00, 16, 22.70, 'en_attente', 0, 0),

-- Sophie commande annulée
(3, 5, '42 cours Victor Hugo', '33000' ,'Bordeaux', 0, 'CMD-2026-009', '2026-05-15 10:00:00', '2026-05-30', '19:00', 1200.00, 20, 0, 'annulee', 0, 0),

-- Camille en livraison
(5, 1, '23 rue Jean Jaurès', '33600' , 'Pessac', 12, 'CMD-2026-010', '2026-11-28 09:30:00', '2026-12-15', '12:00', 675.00, 15, 12.08, 'en_livraison', 1, 0);




INSERT INTO historique_statut (commande_id, statut, date_modification) VALUES
-- CMD-001 (terminée)
(1, 'en_attente', '2026-03-10 14:30:00'),
(1, 'acceptee', '2026-03-11 09:00:00'),
(1, 'en_preparation', '2026-03-18 08:00:00'),
(1, 'en_livraison', '2026-03-20 10:00:00'),
(1, 'livree', '2026-03-20 12:15:00'),
(1, 'terminee', '2026-03-30 09:00:00'),

-- CMD-002 (terminée)
(2, 'en_attente', '2026-04-01 10:15:00'),
(2, 'acceptee', '2026-04-02 08:30:00'),
(2, 'en_preparation', '2026-04-08 07:00:00'),
(2, 'en_livraison', '2026-04-10 09:30:00'),
(2, 'livree', '2026-04-10 11:20:00'),
(2, 'terminee', '2026-04-20 09:00:00'),

-- CMD-003 (terminée)
(3, 'en_attente', '2026-03-15 09:00:00'),
(3, 'acceptee', '2026-03-16 10:00:00'),
(3, 'en_preparation', '2026-03-23 06:00:00'),
(3, 'en_livraison', '2026-03-25 17:00:00'),
(3, 'livree', '2026-03-25 19:30:00'),
(3, 'terminee', '2026-04-05 09:00:00'),

-- CMD-004 (en préparation)
(4, 'en_attente', '2026-11-20 16:45:00'),
(4, 'acceptee', '2026-11-21 09:00:00'),
(4, 'en_preparation', '2026-12-22 07:00:00'),

-- CMD-005 (acceptée)
(5, 'en_attente', '2026-11-25 11:30:00'),
(5, 'acceptee', '2026-11-26 08:00:00'),

-- CMD-006 (terminée, matériel non restitué)
(6, 'en_attente', '2026-06-01 08:00:00'),
(6, 'acceptee', '2026-06-02 09:00:00'),
(6, 'en_preparation', '2026-06-13 07:00:00'),
(6, 'en_livraison', '2026-06-15 10:30:00'),
(6, 'livree', '2026-06-15 13:00:00'),
(6, 'attente_retour_materiel', '2026-06-16 09:00:00'),

-- CMD-007 (terminée)
(7, 'en_attente', '2026-03-20 17:00:00'),
(7, 'acceptee', '2026-03-21 08:00:00'),
(7, 'en_preparation', '2026-04-03 07:00:00'),
(7, 'en_livraison', '2026-04-05 09:30:00'),
(7, 'livree', '2026-04-05 12:00:00'),
(7, 'terminee', '2026-04-15 09:00:00'),

-- CMD-008 (en attente)
(8, 'en_attente', '2026-07-10 14:00:00'),

-- CMD-009 (annulée)
(9, 'en_attente', '2026-05-15 10:00:00'),
(9, 'annulee', '2026-05-16 09:00:00'),

-- CMD-010 (en livraison)
(10, 'en_attente', '2026-11-28 09:30:00'),
(10, 'acceptee', '2026-11-29 08:00:00'),
(10, 'en_preparation', '2026-12-13 07:00:00'),
(10, 'en_livraison', '2026-12-15 10:00:00');




INSERT INTO avis (commande_id, utilisateur_id, note, description, statut, date_avis) VALUES
(1, 3, 5, 'Service impeccable pour notre mariage ! Les 120 convives ont été ravis. Le foie gras était exceptionnel.', 'valide', '2026-04-01 14:00:00'),
(3, 4, 5, 'Gala d''entreprise parfaitement réussi. Présentation soignée et saveurs au rendez-vous.', 'valide', '2026-04-10 10:30:00'),
(7, 6, 5, 'Brunch de Pâques mémorable pour les 60 ans de mon père. Tout était parfait, merci !', 'valide', '2026-04-20 16:00:00'),
(2, 3, 4, 'Très bon menu pour notre Noël en famille. Petit bémol : j''aurais aimé plus de choix végétariens.', 'valide', '2026-04-25 11:00:00'),
(6, 5, 4, 'Menu Jardin d''Été frais et savoureux. La panna cotta était divine. Livraison ponctuelle.', 'en_attente', '2026-06-20 09:00:00');