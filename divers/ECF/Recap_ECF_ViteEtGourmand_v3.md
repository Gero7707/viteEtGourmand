# 📋 Récapitulatif du projet ECF — Vite & Gourmand (v3)

## Contexte du projet

- **Formation** : TP Développeur Web et Web Mobile (Studi)
- **Projet** : ECF — Application web pour "Vite & Gourmand", traiteur événementiel à Bordeaux
- **Entreprise cliente** : Vite & Gourmand (Julie et José), traiteur depuis 25 ans
- **Entreprise de dev** : FastDev (le candidat est développeur missionné)
- **Durée indicative** : 70h
- **Stack** : PHP vanilla (PDO), MySQL, MongoDB, HTML5/CSS3/JS vanilla
- **Rôle de Claude** : Maître d'apprentissage expert full stack. Explique le pourquoi, guide étape par étape, ne donne pas de code sans explication, valide le travail, corrige.
- **Simulation managériale** : L'utilisateur simule le rôle de manager (GV) sur Trello, crée les cartes et les attribue à un collaborateur développeur (V = même personne, compte unique car limitation Trello gratuit)

---

## Ce qui a été fait

### ✅ Phase 1 — Gestion de projet

#### Trello
- Board créé : "Debut Projet ECF"
- **5 colonnes** : À faire → En cours → En attente → En test/Revue → Terminé
- **6 étiquettes** :
  - 🔴 Rouge : Phase 1 — Fondations
  - 🟠 Orange : Phase 2 — Backend core
  - 🔵 Bleu : Phase 3 — Front-end
  - 🟣 Violet : Phase 4 — NoSQL & avancé
  - 🟢 Vert : Phase 5 — Déploiement
  - 🟡 Jaune : Documentation
- **Méthodologie** : Kanban (justifié : travail solo, périmètre fixe, pas besoin des cérémonies Scrum)
- **Priorisation** : Méthode MoSCoW (Must / Should / Could / Won't)
- **Règle Kanban** : 1 carte max en cours par membre, toute carte passe par En test/Revue avant Terminé

#### Cartes terminées
1. ✅ Créer plan d'action
2. ✅ Prise en main de Trello
3. ✅ Définir les user stories et organiser le backlog
4. ✅ Documenter la méthodologie Kanban
5. ✅ Créer la charte graphique (wireframes + mockups terminés)
6. ✅ Diagramme de cas d'utilisation
7. ✅ MLD sur draw.io
8. ✅ Fichier SQL de création des tables
9. ✅ Fichier SQL d'insertion de données de test

#### Documentation gestion de projet
- Google Doc créé : "Documentation Gestion de Projet — Vite & Gourmand"
- Contenu :
  - Choix de la méthodologie Kanban (justification)
  - Organisation du tableau Trello (colonnes, étiquettes, membres, flux)
  - Méthode de priorisation MoSCoW
  - Règles de fonctionnement (WIP limits, critères de passage entre colonnes)
  - Note : rôles manager/dev simulés depuis un seul compte Trello
  - **Décisions de conception UX/UI** (ajouté — document Word généré : Decisions_UX_UI_ViteEtGourmand.docx)

---

### ✅ User Stories (fichier généré : UserStories_ViteEtGourmand.md)

#### Acteurs identifiés
1. **Visiteur** (non authentifié) : consulte le site, les menus, peut filtrer, voir le détail, contacter, créer un compte
2. **Utilisateur** (authentifié) : commande, suit ses commandes, modifie/annule (si pas acceptée), donne un avis, modifie son profil
3. **Employé** : modifie/supprime menus/plats/horaires, gère les commandes (filtres, statuts), annule avec motif+contact, valide/refuse avis
4. **Administrateur** : tout ce que l'employé fait + crée/désactive comptes employés, graphiques commandes par menu (MongoDB), CA par menu avec filtres

#### Décisions prises sur les user stories
- **V-05 (Estimateur de prix)** : amélioration UX proposée par le développeur. Sur la vue détaillée d'un menu, le visiteur peut estimer le prix selon le nombre de personnes SANS créer de compte. Seuls les frais de livraison nécessitent la connexion (adresse requise). Justification RGPD : ne pas forcer la création de compte pour voir un prix.
- **Pas de panier** : l'énoncé décrit une commande directe (un menu à la fois), pas un système de panier multi-articles
- **Prêt de matériel** : c'est un statut de commande géré côté employé, pas un choix du client
- **Compte admin** : créé par le développeur, impossible à créer depuis l'application
- **Pas de badge thème sur les cartes menus** : incohérence entre fêtes nommées (Noël, Pâques avec icônes identifiables) et événements génériques ("Gala", "Anniversaire" sans icône évidente). Le thème est un critère de filtre et s'affiche sur la vue détaillée uniquement. Le badge régime est conservé car c'est une info de santé prioritaire.

#### Compréhension métier
- Vite & Gourmand = **traiteur événementiel** (pas un restaurant)
- Livraison chez le client pour des événements (Noël, Pâques, repas, événements)
- Chaque menu a un nombre minimum de personnes
- **Tarification** :
  - Prix de base = prix affiché pour le nb minimum de personnes
  - Prix par personne = prix de base / nb minimum
  - Si commande pour X personnes : X × prix par personne
  - Réduction 10% si ≥ 5 personnes AU-DESSUS du minimum
  - Livraison gratuite à Bordeaux, sinon 5€ + 0.59€/km
- **Prêt de matériel** : géré par l'employé, pénalité de 600€ si non restitué sous 10 jours ouvrés
- **Statuts de commande** : en attente → accepté → en préparation → en cours de livraison → livré → (en attente retour matériel) → terminée

---

### ✅ Charte graphique (terminée — exportée en PDF depuis Figma)

#### Palette de couleurs — Bleu nuit & Doré (premium, sobre, luxueux, événementiel)

**Couleurs principales** :
| Nom | Hex | Usage |
|---|---|---|
| Bleu très foncé | #0F1D36 | Fonds sombres, header alternatif, footer |
| Bleu nuit | #1B2A4A | Couleur principale, header, boutons |
| Bleu moyen | #2A3F6A | Hover, éléments secondaires, badges régime |
| Doré | #D4A853 | Accent, boutons CTA sur fond sombre, étoiles avis |
| Doré clair | #E8C475 | Hover liens navigation, accents légers |
| Doré très clair | #F5E6C4 | Fond bloc conditions (vue détaillée menu) |

**Neutres** :
| Nom | Hex | Usage |
|---|---|---|
| Noir doux | #1A1A1A | Titres principaux |
| Texte | #333333 | Corps de texte |
| Secondaire | #666666 | Texte secondaire |
| Placeholder | #6B6B6B | Placeholder formulaires (corrigé pour accessibilité, était #999999) |
| Bordure | #E8E8E8 | Bordures, séparateurs |
| Fond carte | #F5F5F5 | Fond des cartes menu |
| Fond | #FAFAFA | Fond de page |

**Couleurs sémantiques** :
| Nom | Hex | Usage |
|---|---|---|
| Succès / Validé | #2E7D4F | Statut accepté, terminé |
| Erreur / Annulé | #C62828 | Statut annulé, erreurs formulaire |
| Attention / En cours | #E68A00 | Statut en attente, avertissements |
| Info / Lien | #1565C0 | Liens, statut en livraison |

**Couleurs accessibilité** (alternatives pour fond clair) :
| Nom | Hex | Usage |
|---|---|---|
| Doré sur fond clair | #8A5E1A | Prix et liens dorés sur fond blanc (remplace #D4A853) |
| Attention texte | #9A5C00 | Texte attention sur fond clair (remplace #E68A00) |

#### Règles d'accessibilité (RGAA / WCAG AA)
- Ratio de contraste minimum : **4.5:1** pour texte normal, **3:1** pour texte ≥18px ou ≥14px bold
- ❌ Ne JAMAIS utiliser #D4A853 (doré) comme texte sur fond clair → utiliser #8A5E1A
- ❌ Ne JAMAIS utiliser #E68A00 (attention) avec texte blanc → utiliser texte foncé #9A5C00 sur fond léger
- ❌ Ne JAMAIS utiliser #999999 comme placeholder → remplacé par #6B6B6B
- ✅ Contrastes validés avec calcul programmatique

#### Typographie
| Élément | Police | Taille | Poids |
|---|---|---|---|
| Logo "Vite & Gourmand" | Great Vibes | 36px | Regular |
| H1 (titres principaux) | Manrope | 24px | Bold (700) |
| H2 (sous-titres) | Manrope | 18px | Bold (700) |
| Corps de texte | Manrope | 16px | Regular (400) |
| Bouton | Manrope | 14px | Medium (500) |

#### Application de la charte sur les composants
- **Header** : fond bleu nuit (#1B2A4A), logo doré en Great Vibes, liens blanc (#FAFAFA), hover doré clair (#E8C475), boutons bordure doré + texte doré, hover inversé (fond doré, texte bleu nuit)
- **Hero/Carousel** : pleine largeur, accroche Manrope 24px Bold, CTA fond doré texte bleu nuit, flèches + pause blanc semi-transparent
- **Cartes menus** : fond #FAFAFA ou #F5F5F5, bordure #E8E8E8, titre Manrope 18px Bold #1A1A1A, prix doré foncé #8A5E1A, badge régime fond bleu moyen #2A3F6A texte blanc, bouton fond bleu nuit texte blanc
- **Section avis** : fond bleu nuit (#1B2A4A), cartes blanches, étoiles doré (#D4A853)
- **Bloc conditions** : fond doré très clair (#F5E6C4), bordure gauche doré 4px
- **Bouton Commander** : fond doré (#D4A853), texte bleu nuit, Manrope 16px Bold, pleine largeur
- **Footer** : fond bleu très foncé (#0F1D36), texte blanc, liens doré clair (#E8C475)
- **Sidebar filtres** : fond blanc, bordure droite #E8E8E8, titres Manrope 14px Bold bleu nuit

#### Composants Figma créés
- **Bouton avec variants** (Component Set) : état Default + état Hover avec interaction "Pendant le survol" → Smart animate 150ms
- **Lien navigation avec variants** : état Default (blanc) + état Hover (doré clair #E8C475)

---

### ✅ Wireframes (terminés — 6 wireframes)

#### Desktop (1440×900)
1. ✅ Page d'accueil (header, hero carousel avec pause, section "Notre savoir-faire" en zigzag, avis clients, footer avec horaires)
2. ✅ Vue globale des menus (sidebar filtres à gauche, grille 2 colonnes de cartes menus)
3. ✅ Vue détaillée d'un menu (fil d'Ariane, galerie, infos, plats avec allergènes, conditions, estimateur, bouton Commander)

#### Mobile (375×812)
4. ✅ Page d'accueil (menu hamburger, contenu une colonne)
5. ✅ Vue globale des menus (bouton "Filtrer" ouvrant panneau déroulant, cartes une colonne)
6. ✅ Vue détaillée d'un menu (tout empilé en une colonne, bouton Commander pleine largeur)

#### Bonus
- ✅ Menu hamburger ouvert (état alternatif montrant les liens : Accueil, Nos menus, Contact, Connexion, Créer un compte)
- ✅ Panneau filtres mobile (avec bouton fermer ✕ et bouton "Appliquer filtres")

---

### ✅ Mockups (terminés — 6 mockups)

#### Desktop
1. ✅ Page d'accueil
2. ✅ Vue globale des menus — 4 cartes menus avec badges régime bleu, boutons "Voir Menu"
3. ✅ Vue détaillée d'un menu — Menu Prestige : galerie, badge, prix, plats avec allergènes, bloc conditions, estimateur, bouton Commander

#### Mobile
4. ✅ Page d'accueil mobile
5. ✅ Vue globale mobile
6. ✅ Vue détaillée mobile

#### Contenus des menus créés (8 menus au total)

**Menu Prestige** — Classique / Classique — 45€/pers — min 10 pers
- Description : "Un menu d'exception pour vos réceptions les plus élégantes. Foie gras, filet de bœuf en croûte et trilogie de chocolat."
- Entrée : Foie gras mi-cuit et son chutney de figues (allergènes : sulfites, fruits à coque)
- Plat : Filet de bœuf en croûte, jus au porto, gratin dauphinois (allergènes : gluten, lait, œufs)
- Dessert : Trilogie de chocolat — mousse, fondant, croustillant (allergènes : lait, œufs, soja)

**Menu Jardin d'Été** — Végétarien / Classique — 35€/pers — min 8 pers
- Description : "Des saveurs fraîches et légères pour vos événements estivaux. Gaspacho de tomates anciennes, risotto aux légumes grillés et panna cotta à la verveine."

**Menu Réveillon** — Classique / Noël — 55€/pers — min 12 pers
- Description : "Un festin de Noël pour émerveiller vos convives. Velouté de châtaignes à la truffe, chapon farci aux marrons et bûche glacée aux trois chocolats."

**Menu Renouveau** — Vegan / Pâques — 38€/pers — min 6 pers
- Description : "Un menu 100% végétal aux couleurs du printemps. Tartare d'avocat et mangue, tajine de légumes printaniers et fondant au chocolat noir."

**Menu Gala** — Classique / Événement — 60€/pers — min 20 pers
- Description : "Un menu prestigieux pour vos galas et soirées d'entreprise. Carpaccio de Saint-Jacques, suprême de volaille aux morilles et opéra revisité."

**Menu Champêtre** — Végétarien / Événement — 32€/pers — min 8 pers
- Description : "Un menu frais et convivial pour vos réceptions en plein air. Velouté glacé de petits pois à la menthe, tarte fine aux légumes du soleil et pavlova aux fruits rouges."

**Menu Féérie d'Hiver** — Vegan / Noël — 42€/pers — min 10 pers
- Description : "Un menu 100% végétal aux saveurs chaleureuses de l'hiver. Velouté de butternut rôti aux épices, wellington de champignons aux marrons et bûche glacée au chocolat noir et orange."

**Menu Brunch de Pâques** — Classique / Pâques — 30€/pers — min 6 pers
- Description : "Un brunch festif pour célébrer Pâques en famille. Œufs brouillés aux asperges et saumon fumé, carré d'agneau aux herbes de Provence et nid de Pâques en chocolat."

#### Conditions du menu (identiques pour tous les menus, stockées en 3 champs séparés)
- **conditions_delai** : Toute commande doit être passée au minimum 72 heures (3 jours ouvrés) avant la date de l'événement. Pour les commandes de plus de 30 personnes, un délai de 7 jours ouvrés est requis.
- **conditions_stockage** : Les plats sont livrés sous emballage isotherme. Ils doivent être conservés au réfrigérateur (entre 0°C et 4°C) et consommés dans les 24 heures suivant la livraison. Ne pas recongeler.
- **conditions_infos** : Du matériel de service (assiettes, couverts, nappes) est prêté gratuitement pour la durée de l'événement. La restitution doit être effectuée sous 10 jours ouvrés après l'événement. Passé ce délai, une pénalité forfaitaire de 600€ sera facturée. Toute modification ou annulation de commande est possible tant que la commande n'a pas été acceptée par notre équipe.

#### Décision de conception : 3 champs conditions au lieu d'un seul
- **Problème** : un seul champ `conditions TEXT` ne permet pas d'afficher proprement les 3 sections avec leurs titres respectifs
- **Solution** : 3 champs séparés (`conditions_delai`, `conditions_stockage`, `conditions_infos`) dans la table menu
- **Côté PHP/HTML** : les titres "Délai de commande", "Conditions de stockage", "Informations importantes" sont codés en dur dans le template, seul le contenu vient de la base
- **MCD, MLD et SQL** mis à jour en conséquence

#### Avis clients créés
1. Sophie M. — ★★★★★ — Mariage, 120 convives
2. Laurent D. — ★★★★★ — Gala d'entreprise annuel
3. Camille R. — ★★★★☆ — Menu de Noël 15 personnes (bémol : plus de choix végétariens souhaité)
4. Marc et Isabelle T. — ★★★★★ — Anniversaire 60 ans, 30 invités

---

### ✅ Diagramme de cas d'utilisation (terminé — exporté depuis draw.io)

#### Acteurs et héritages
- **Visiteur** ◁— **Utilisateur** (l'utilisateur hérite des droits du visiteur)
- **Employé** ◁— **Administrateur** (l'admin hérite des droits de l'employé)
- Visiteur et Utilisateur à gauche du diagramme, Employé et Admin à droite

#### Cas d'utilisation par acteur

**Visiteur** (7 cas) :
1. Consulter les avis
2. Consulter les menus
3. Filtrer les menus
4. Consulter un menu détaillé
5. Estimer le prix
6. Créer un compte
7. Contacter le prestataire

**Utilisateur** (8 cas, en plus du Visiteur) :
1. Se connecter
2. Réinitialiser le mot de passe
3. Passer une commande
4. Consulter l'historique de commandes
5. Modifier / Annuler une commande
6. Suivre sa commande
7. Modifier son profil
8. Donner un avis

**Employé** (6 cas) :
1. Gérer les menus et plats
2. Gérer les horaires
3. Filtrer les commandes
4. Mettre à jour le statut de commande
5. Annuler une commande (avec motif)
6. Modérer les avis

**Administrateur** (2 cas, en plus de l'Employé) :
1. Gérer les comptes employés
2. Consulter les statistiques

#### Relations
- **<<include>>** : "Passer une commande" inclut toujours "Calculer le prix"
- **<<extend>>** : "Réinitialiser le mot de passe" étend optionnellement "Se connecter"

#### Décisions de conception
- **"Consulter les avis"** ajouté comme cas du Visiteur : sur la page d'accueil on affiche quelques avis, mais le visiteur peut cliquer pour voir tous les avis validés → action intentionnelle
- **Pas de include/extend côté Employé/Admin** : les comportements comme l'envoi de mail lors d'une annulation sont des détails d'implémentation, pas des cas d'utilisation

#### Diagrammes de séquence — À faire plus tard
- Reportés après la mise en place de l'architecture PHP (Phase 2)
- Cas prévus : Passer une commande, Se connecter, Gérer un statut de commande

---

### ✅ MCD (Modèle Conceptuel de Données) — corrigé, amélioré, MCD enrichi

Le MCD de l'annexe 1 a été analysé, corrigé et enrichi. Format : **MCD enrichi** (noms d'attributs + types génériques sans précision de taille).

#### Entités (12 — table contact retirée)
1. **commande** (commande_id INT, adresse_livraison VARCHAR, distance_km DECIMAL, numero_commande VARCHAR, date_commande DATETIME, date_prestation DATE, heure_livraison TIME, prix_menu DECIMAL, nombre_personne INT, prix_livraison DECIMAL, statut VARCHAR, pret_materiel BOOL, restitution_materiel BOOL)
2. **utilisateur** (utilisateur_id INT, password VARCHAR, email VARCHAR, nom VARCHAR, prenom VARCHAR, gsm VARCHAR, ville VARCHAR, adresse VARCHAR, code_postal VARCHAR, actif BOOL)
3. **role** (role_id INT, libelle VARCHAR)
4. **menu** (menu_id INT, titre VARCHAR, nombre_personne_minimum INT, prix_par_personne DECIMAL, description TEXT, quantite_restante INT, conditions_delai TEXT, conditions_stockage TEXT, conditions_infos TEXT)
5. **plat** (plat_id INT, titre_plat VARCHAR, type_plat VARCHAR, chemin_photo VARCHAR)
6. **allergene** (allergene_id INT, libelle VARCHAR)
7. **theme** (theme_id INT, libelle VARCHAR)
8. **regime** (regime_id INT, libelle VARCHAR)
9. **avis** (avis_id INT, note INT, description TEXT, statut VARCHAR, date_avis DATETIME)
10. **image_menu** (image_id INT, chemin VARCHAR)
11. **historique_statut** (historique_id INT, statut VARCHAR, date_modification DATETIME)
12. **horaire** (horaire_id INT, jour VARCHAR, heure_ouverture TIME, heure_fermeture TIME)

#### Décision : pas de table contact
- Le formulaire de contact envoie un mail directement via PHP (mail() ou PHPMailer)
- Rien n'est stocké en base de données
- L'énoncé dit juste "envoi par mail à l'entreprise", l'option mail seul suffit

#### Relations
| Relation | Entité 1 | Cardinalité | Entité 2 | Cardinalité |
|---|---|---|---|---|
| passe | commande | 0,n | utilisateur | 1,1 |
| comprend | commande | 1,1 | menu | 0,n |
| met à jour | commande | 1,1 | historique_statut | 0,n |
| possède | utilisateur | 1,1 | role | 0,1 |
| publie | utilisateur | 1,1 | avis | 0,n |
| concerne | avis | 1,1 | commande | 0,n |
| adapte | menu | 1,1 | regime | 0,1 |
| propose | menu | 1,1 | theme | 0,1 |
| compose | menu | 1,n | plat | 0,n |
| contient | plat | 0,n | allergene | 0,n |
| illustre | menu | 1,1 | image_menu | 0,n |

#### Corrections apportées par rapport au MCD original (annexe 1)
1. Ajout de commande_id (l'original n'avait pas de clé primaire propre)
2. Ajout de adresse_livraison et distance_km dans commande
3. Suppression du champ "regime" dans menu (redondant avec la relation "adapte")
4. Changement des types monétaires : DOUBLE → DECIMAL
5. Changement heure_livraison : VARCHAR → TIME
6. Changement description : VARCHAR(50) → TEXT
7. Changement photo : BLOB → VARCHAR chemin_photo
8. Changement password : VARCHAR(50) → VARCHAR
9. Ajout du champ "nom" dans utilisateur
10. Renommage "telephone" en "gsm"
11. Ajout du champ "actif" BOOL dans utilisateur
12. Ajout du champ "code_postal" dans utilisateur
13. Remplacement de "conditions" TEXT par 3 champs : conditions_delai, conditions_stockage, conditions_infos
14. Ajout du champ "type_plat" dans plat
15. Ajout de la table "image_menu"
16. Ajout de la table "historique_statut"
17. Ajout de la relation avis → commande ("concerne")
18. Ajout du champ "date_avis" dans avis
19. Changement note : VARCHAR(50) → INT
20. Changement heure_ouverture/heure_fermeture : VARCHAR → TIME

#### Justifications techniques documentées
- **VARCHAR pour code_postal** : les codes postaux commençant par 0 perdraient le zéro initial avec un INT
- **DECIMAL vs DOUBLE** : DOUBLE crée des erreurs d'arrondi (0.1 + 0.2 ≠ 0.3), inacceptable pour des montants financiers
- **VARCHAR vs BLOB pour les images** : stocker les fichiers binaires en base alourdit la BDD, bonne pratique = fichier sur le serveur + chemin en base
- **Table role séparée** : contrôle strict des valeurs, extensible
- **Table historique_statut** : l'énoncé exige le suivi avec dates/heures de chaque changement
- **Champ gsm** : terminologie de l'énoncé, le label affiché sera "Téléphone"

---

### ✅ MLD (Modèle Logique de Données) — terminé sur draw.io

#### Tables (14 tables, notation : PK = clé primaire, FK = clé étrangère)

**Tables de référence :**
- **role** (PK role_id INT AUTO_INCREMENT, libelle VARCHAR(50) NOT NULL)
- **theme** (PK theme_id INT AUTO_INCREMENT, libelle VARCHAR(50) NOT NULL)
- **regime** (PK regime_id INT AUTO_INCREMENT, libelle VARCHAR(50) NOT NULL)
- **allergene** (PK allergene_id INT AUTO_INCREMENT, libelle VARCHAR(100) NOT NULL)
- **horaire** (PK horaire_id INT AUTO_INCREMENT, jour VARCHAR(10) NOT NULL, heure_ouverture TIME NOT NULL, heure_fermeture TIME NOT NULL)

**Tables principales :**
- **utilisateur** (PK utilisateur_id INT AUTO_INCREMENT, email VARCHAR(255) UNIQUE NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, gsm VARCHAR(20), ville VARCHAR(100), adresse VARCHAR(255), code_postal VARCHAR(10), actif TINYINT(1) DEFAULT 1, FK role_id INT NOT NULL)
- **menu** (PK menu_id INT AUTO_INCREMENT, titre VARCHAR(255) NOT NULL, nombre_personne_minimum INT NOT NULL, prix_par_personne DECIMAL(10,2) NOT NULL, description TEXT NOT NULL, quantite_restante INT, conditions_delai TEXT, conditions_stockage TEXT, conditions_infos TEXT, FK regime_id INT, FK theme_id INT)
- **plat** (PK plat_id INT AUTO_INCREMENT, titre_plat VARCHAR(255) NOT NULL, type_plat ENUM('entree','plat','dessert') NOT NULL, chemin_photo VARCHAR(255))
- **image_menu** (PK image_id INT AUTO_INCREMENT, chemin VARCHAR(255) NOT NULL, FK menu_id INT NOT NULL)
- **commande** (PK commande_id INT AUTO_INCREMENT, adresse_livraison VARCHAR(255) NOT NULL, distance_km DECIMAL(10,2), numero_commande VARCHAR(50) UNIQUE NOT NULL, date_commande DATETIME NOT NULL, date_prestation DATE NOT NULL, heure_livraison TIME, prix_menu DECIMAL(10,2) NOT NULL, nombre_personne INT NOT NULL, prix_livraison DECIMAL(10,2), statut VARCHAR(50) NOT NULL, pret_materiel TINYINT(1) DEFAULT 0, restitution_materiel TINYINT(1) DEFAULT 0, FK utilisateur_id INT NOT NULL, FK menu_id INT NOT NULL)
- **historique_statut** (PK historique_id INT AUTO_INCREMENT, statut VARCHAR(50) NOT NULL, date_modification DATETIME NOT NULL, FK commande_id INT NOT NULL)
- **avis** (PK avis_id INT AUTO_INCREMENT, note INT NOT NULL, description TEXT, statut VARCHAR(20) NOT NULL, date_avis DATETIME NOT NULL, FK commande_id INT NOT NULL, FK utilisateur_id INT NOT NULL)

**Tables de jointure (many-to-many) :**
- **menu_plat** (PK/FK menu_id INT NOT NULL, PK/FK plat_id INT NOT NULL)
- **plat_allergene** (PK/FK plat_id INT NOT NULL, PK/FK allergene_id INT NOT NULL)

#### Relations (13 au total, notation pied de corbeau)
| Depuis (FK) | Vers (PK) | Type |
|---|---|---|
| utilisateur.role_id | role.role_id | one-to-many |
| menu.regime_id | regime.regime_id | one-to-many |
| menu.theme_id | theme.theme_id | one-to-many |
| image_menu.menu_id | menu.menu_id | one-to-many |
| commande.utilisateur_id | utilisateur.utilisateur_id | one-to-many |
| commande.menu_id | menu.menu_id | one-to-many |
| historique_statut.commande_id | commande.commande_id | one-to-many |
| avis.commande_id | commande.commande_id | one-to-many |
| avis.utilisateur_id | utilisateur.utilisateur_id | one-to-many |
| menu_plat.menu_id | menu.menu_id | one-to-many |
| menu_plat.plat_id | plat.plat_id | one-to-many |
| plat_allergene.plat_id | plat.plat_id | one-to-many |
| plat_allergene.allergene_id | allergene.allergene_id | one-to-many |

#### Concepts appris
- **FK va toujours du côté "plusieurs"** de la relation
- **Many-to-many** : impossible directement en BDD relationnelle, nécessite une table de jointure
- **Table de jointure** (ou table d'association / table pivot) : ne contient que des FK, clé primaire composite
- **Clé primaire composite** : combinaison de 2 FK qui ensemble forment la PK unique
- **MCD vs MLD** : le MCD ne contient pas les types précis ni les tables de jointure, c'est le MLD qui les ajoute
- **NOT NULL** : réfléchir pour chaque champ si la donnée peut être vide ou non
- **Adresse utilisateur facultative** : l'adresse obligatoire se gère au moment de la commande (commande.adresse_livraison NOT NULL), pas à l'inscription (RGPD)

---

### ✅ Fichier SQL de création des tables (terminé)

#### Ordre de création (respecte les dépendances FK)
1. role, theme, regime, allergene, horaire (aucune FK)
2. utilisateur (FK vers role)
3. menu (FK vers regime et theme)
4. plat (aucune FK)
5. image_menu (FK vers menu)
6. commande (FK vers utilisateur et menu)
7. historique_statut (FK vers commande)
8. avis (FK vers utilisateur et commande)
9. menu_plat (FK vers menu et plat)
10. plat_allergene (FK vers plat et allergene)

#### Points techniques
- `CREATE DATABASE IF NOT EXISTS vite_et_gourmand; USE vite_et_gourmand;` en début de fichier
- BOOL = TINYINT(1) en MySQL
- DEFAULT 1 pour actif (utilisateur actif par défaut)
- DEFAULT 0 pour pret_materiel et restitution_materiel (pas de prêt par défaut)
- ENUM('entree','plat','dessert') pour type_plat
- UNIQUE sur email (utilisateur) et numero_commande (commande)

---

### ✅ Fichier SQL d'insertion de données de test (terminé)

#### Ordre d'insertion (respecte les dépendances FK)
1. role → regime → theme → allergene → horaire
2. utilisateur
3. menu
4. plat
5. image_menu
6. menu_plat
7. plat_allergene
8. commande
9. historique_statut
10. avis

#### Données de référence
- **3 rôles** : utilisateur (1), employé (2), administrateur (3)
- **3 régimes** : Classique (1), Végétarien (2), Vegan (3)
- **4 thèmes** : Classique (1), Noël (2), Pâques (3), Événement (4)
- **7 allergènes** : gluten (1), lait (2), œufs (3), fruits à coque (4), soja (5), sulfites (6), crustacés (7)
- **6 horaires** : Mardi à Dimanche (Lundi fermé — pas de ligne en base)

#### Utilisateurs (6)
| Email | Rôle | Ville |
|---|---|---|
| jose@viteetgourmand.fr | Admin (3) | Bordeaux |
| julie@viteetgourmand.fr | Employé (2) | Bordeaux |
| sophie.martin@email.fr | Client (1) | Bordeaux |
| laurent.dubois@email.fr | Client (1) | Mérignac |
| camille.rousseau@email.fr | Client (1) | Pessac |
| marc.thomas@email.fr | Client (1) | Libourne |

- Mots de passe : hash bcrypt placeholder (même hash pour tous en test)
- Clients répartis Bordeaux + banlieue pour tester les frais de livraison

#### Menus (8) — 2 par thème, variété de régimes
| # | Menu | Régime | Thème | Prix/pers | Min pers |
|---|---|---|---|---|---|
| 1 | Prestige | Classique (1) | Classique (1) | 45€ | 10 |
| 2 | Jardin d'Été | Végétarien (2) | Classique (1) | 35€ | 8 |
| 3 | Réveillon | Classique (1) | Noël (2) | 55€ | 12 |
| 4 | Renouveau | Vegan (3) | Pâques (3) | 38€ | 6 |
| 5 | Gala | Classique (1) | Événement (4) | 60€ | 20 |
| 6 | Champêtre | Végétarien (2) | Événement (4) | 32€ | 8 |
| 7 | Féérie d'Hiver | Vegan (3) | Noël (2) | 42€ | 10 |
| 8 | Brunch de Pâques | Classique (1) | Pâques (3) | 30€ | 6 |

#### Plats (24) — 3 par menu (entrée, plat, dessert)
- Chaque plat a un chemin_photo en `assets/img/plats/`

#### Images menus (8) — 1 par menu
- Chemins en `assets/img/menus/`
- Image principale pour la carte sur la vue globale

#### Commandes (10) — statuts variés
| # | Client | Menu | Ville | Statut |
|---|---|---|---|---|
| CMD-001 | Sophie | Prestige | Bordeaux (0km) | terminée |
| CMD-002 | Sophie | Renouveau | Bordeaux (0km) | terminée |
| CMD-003 | Laurent | Gala | Mérignac (8km) | terminée |
| CMD-004 | Laurent | Réveillon | Mérignac (8km) | en_preparation |
| CMD-005 | Camille | Féérie | Pessac (12km) | acceptée |
| CMD-006 | Camille | Jardin d'Été | Pessac (12km) | terminée (matériel non restitué) |
| CMD-007 | Marc | Brunch Pâques | Libourne (30km) | terminée |
| CMD-008 | Marc | Champêtre | Libourne (30km) | en_attente |
| CMD-009 | Sophie | Gala | Bordeaux (0km) | annulée |
| CMD-010 | Camille | Prestige | Pessac (12km) | en_livraison |

#### Historiques de statut — 2 à 6 entrées par commande
- Chaque commande a son historique complet (en_attente → acceptée → en_preparation → ...)
- CMD-006 a le statut spécial "attente_retour_materiel"

#### Avis (5) — notes et statuts variés
| Commande | Client | Note | Statut |
|---|---|---|---|
| CMD-001 | Sophie | 5/5 | validé |
| CMD-003 | Laurent | 5/5 | validé |
| CMD-007 | Marc | 5/5 | validé |
| CMD-002 | Sophie | 4/5 | validé |
| CMD-006 | Camille | 4/5 | en_attente |

#### Architecture MVC prévue
```
projet/
├── public/           ← point d'entrée (index.php)
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── img/
│   │       ├── menus/
│   │       └── plats/
├── app/
│   ├── controllers/
│   ├── models/
│   └── views/
├── config/
└── ...
```
- Chemins en base relatifs à `public/` : `assets/img/menus/`, `assets/img/plats/`

---

### 🔲 Prochaines étapes — Phase 2

1. 🔲 Initialiser le repo Git (GitHub PUBLIC, branches main + develop)
2. 🔲 Mettre en place l'architecture PHP (front controller, PDO, MVC, env vars)
3. 🔲 Développer l'authentification
4. 🔲 Diagrammes de séquence (Passer une commande, Se connecter, Gérer statut commande)
5. 🔲 Développer le CRUD Menus & Plats
6. 🔲 Développer le système de commande
7. 🔲 Développer le front-end (HTML/CSS/JS)
8. 🔲 Intégrer MongoDB (statistiques commandes)
9. 🔲 Mettre en place l'envoi de mails
10. 🔲 Accessibilité RGAA
11. 🔲 Déploiement
12. 🔲 Documentation technique (diagrammes UML, déploiement)
13. 🔲 Manuel d'utilisation (PDF)

---

## Fichiers générés
1. `Plan_Projet_ViteEtGourmand.md` — Plan de projet complet avec toutes les tâches
2. `UserStories_ViteEtGourmand.md` — User stories des 4 acteurs avec priorités MoSCoW
3. `Decisions_UX_UI_ViteEtGourmand.docx` — Documentation des décisions de conception UX/UI
4. `Recap_ECF_ViteEtGourmand_v3.md` — Ce fichier (récapitulatif mis à jour)
5. `Vite_et_gourmand_MCD.jpg` — MCD corrigé et enrichi (exporté depuis draw.io)
6. `MLD_Vite_et_Gourmand.jpg` — MLD complet avec relations (exporté depuis draw.io)
7. `Diagramme_cas_utilisation.png` — Diagramme de cas d'utilisation (exporté depuis draw.io)
8. PDFs charte graphique exportés depuis Figma (wireframes + mockups)
9. Fichier SQL : création des tables (CREATE TABLE)
10. Fichier SQL : insertion des données de test (INSERT INTO)
