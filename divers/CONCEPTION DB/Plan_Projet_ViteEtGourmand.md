# 🍽️ Plan de Projet — Vite & Gourmand

## Stack technique

| Couche | Technologie |
|---|---|
| Front-end | HTML5, CSS3, JavaScript vanilla |
| Back-end | PHP vanilla (PDO) |
| BDD relationnelle | MySQL |
| BDD NoSQL | MongoDB |
| Versioning | Git / GitHub |
| Déploiement | À définir (fly.io, Heroku, Azure, Vercel…) |

---

## Phase 1 — Fondations (semaine 1-2)

### 1. Gestion de projet
- [ ] Créer le board Trello / Notion / Jira

      .Nomenclature étiquettes :
      🔴 Rouge → Phase 1 — Fondations
      🟠 Orange → Phase 2 — Back-end
      🔵 Bleu → Phase 3 — Front-end
      🟣 Violet → Phase 4 — NoSQL & avancé
      🟢 Vert → Phase 5 — Déploiement & docs
      🟡 Jaune → Documentation

- [ ] Définir les user stories à partir de l'énoncé
- [ ] Organiser le backlog par priorité
- [ ] Documenter la méthodologie choisie (Agile / Kanban)

### 2. Charte graphique
- [ ] Choisir la palette de couleurs
- [ ] Choisir la/les police(s)
- [ ] Réaliser 3 maquettes desktop (wireframes + mockups)
- [ ] Réaliser 3 maquettes mobile (wireframes + mockups)
- [ ] Exporter le tout en PDF

### 3. Base de données relationnelle (MySQL)
- [ ] Concevoir le MCD en s'appuyant sur l'annexe 1 du sujet
- [ ] Dériver le MLD (modèle logique)
- [ ] Écrire le fichier SQL de création des tables
- [ ] Écrire le fichier SQL d'insertion de données de test (jeu de données)
- [ ] Vérifier les contraintes d'intégrité et les relations

### 4. Initialisation Git
- [ ] Créer le repository GitHub (PUBLIC)
- [ ] Créer la branche `main`
- [ ] Créer la branche `develop`
- [ ] Mettre en place la structure de dossiers du projet
- [ ] Rédiger le fichier `README.md` (instructions de déploiement local)

---

## Phase 2 — Back-end core (semaine 3-5)

### 5. Architecture PHP
- [ ] Mettre en place un routeur simple (front controller)
- [ ] Configurer la connexion PDO à MySQL
- [ ] Structurer le projet : contrôleurs / modèles / vues
- [ ] Gérer les variables d'environnement (config BDD, clés, etc.)

### 6. Authentification & gestion des rôles
- [ ] Inscription utilisateur (nom, prénom, GSM, mail, adresse postale, mot de passe)
- [ ] Validation mot de passe sécurisé (10 car. min, 1 spécial, 1 maj, 1 min, 1 chiffre)
- [ ] Connexion par email + mot de passe
- [ ] Réinitialisation de mot de passe par mail
- [ ] Gestion des sessions et des rôles (utilisateur, employé, administrateur)
- [ ] Hashage des mots de passe (password_hash / password_verify)
- [ ] Protection CSRF sur les formulaires
- [ ] Conformité RGPD (consentement, données personnelles)

### 7. CRUD Menus & Plats
- [ ] Création / modification / suppression de menus (admin + employé)
- [ ] Gestion des plats (entrée, plat, dessert) avec allergènes
- [ ] Association plats ↔ menus (relation many-to-many)
- [ ] Gestion des thèmes (Noël, Pâques, classique, événement)
- [ ] Gestion des régimes (végétarien, vegan, classique…)
- [ ] Galerie d'images par menu
- [ ] Gestion du stock disponible
- [ ] Conditions du menu (délai de commande, stockage…)

### 8. Système de commande
- [ ] Formulaire de commande (infos client auto-remplies)
- [ ] Choix du menu et du nombre de personnes (minimum respecté)
- [ ] Calcul du prix :
  - Prix de base selon le nombre de personnes
  - Réduction de 10% si ≥ 5 personnes de plus que le minimum
  - Frais de livraison hors Bordeaux : 5€ + 0.59€/km
- [ ] Vue détaillée du prix avant validation
- [ ] Enregistrement de la commande en BDD
- [ ] Gestion des statuts de commande (en attente, accepté, en préparation, en livraison, livré, attente retour matériel, terminée)

---

## Phase 3 — Front-end (semaine 5-7)

### 9. Pages publiques
- [ ] **Page d'accueil** : présentation entreprise, professionnalisme équipe, avis clients validés
- [ ] **Vue globale des menus** : titre, description, nb personnes min, prix, bouton détail
- [ ] **Filtres dynamiques (JS sans rechargement)** :
  - Par prix maximum
  - Par fourchette de prix
  - Par thème
  - Par régime
  - Par nombre de personnes minimum
- [ ] **Vue détaillée d'un menu** : toutes les infos + conditions bien visibles + bouton commander
- [ ] **Page contact** : formulaire (titre, description, mail) → envoi par mail à l'entreprise
- [ ] **Mentions légales** et **CGV**

### 10. Espaces connectés
- [ ] **Espace utilisateur** :
  - Visualiser ses commandes en détail
  - Modifier ses informations personnelles
  - Annuler / modifier une commande (si pas encore acceptée)
  - Suivi de commande (historique des états avec dates/heures)
  - Donner un avis (note 1-5 + commentaire) après commande terminée
- [ ] **Espace employé** :
  - Modifier / supprimer menus, plats, horaires
  - Gestion des commandes avec filtres (par statut, par client)
  - Mise à jour des statuts de commande
  - Annulation avec motif + mode de contact obligatoire
  - Validation / refus des avis clients
- [ ] **Espace administrateur** :
  - Tout ce que l'employé peut faire
  - Créer un compte employé (email + mot de passe)
  - Désactiver un compte employé
  - Graphique comparatif du nombre de commandes par menu (données NoSQL)
  - Calcul du chiffre d'affaires par menu avec filtres (menu, durée)

### 11. Navigation & layout
- [ ] Header avec menu : accueil, menus, connexion, contact
- [ ] Footer : horaires (lundi → dimanche), liens mentions légales & CGV
- [ ] Responsive design (mobile-first recommandé)

---

## Phase 4 — NoSQL + fonctionnalités avancées (semaine 7-8)

### 12. MongoDB
- [ ] Installer et configurer MongoDB
- [ ] Stocker les statistiques de commandes par menu
- [ ] Requêtes d'agrégation pour les graphiques admin
- [ ] Connexion PHP ↔ MongoDB (extension mongodb)

### 13. Envoi de mails
- [ ] Mail de bienvenue à l'inscription
- [ ] Mail de confirmation de commande
- [ ] Mail de notification commande terminée (invitation à donner un avis)
- [ ] Mail de retour matériel (délai 10 jours ouvrés, frais 600€)
- [ ] Mail de création de compte employé (sans mot de passe)
- [ ] Lien de réinitialisation de mot de passe

### 14. Accessibilité (RGAA)
- [ ] Labels sur tous les champs de formulaire
- [ ] Contrastes de couleurs suffisants
- [ ] Navigation au clavier fonctionnelle
- [ ] Attributs ARIA là où nécessaire
- [ ] Textes alternatifs sur les images
- [ ] Structure sémantique HTML (header, main, nav, footer, section…)

---

## Phase 5 — Déploiement & documentation (semaine 8-9)

### 15. Déploiement
- [ ] Choisir l'hébergeur
- [ ] Configurer le serveur (PHP, MySQL, MongoDB)
- [ ] Déployer l'application
- [ ] Tester en production
- [ ] Créer le compte administrateur de José

### 16. Documentation (livrables PDF / dans le repo)
- [ ] **Manuel d'utilisation** (PDF) : présentation de l'app + identifiants de test pour chaque rôle
- [ ] **Charte graphique** (PDF) : palette, polices, maquettes wireframes & mockups
- [ ] **Documentation gestion de projet** : explication de la méthodologie
- [ ] **Documentation technique** :
  - Réflexions initiales sur les choix technologiques (justifications)
  - Configuration de l'environnement de travail
  - MCD / diagramme de classes
  - Diagramme de cas d'utilisation
  - Diagramme de séquence
  - Documentation de déploiement (étapes détaillées)
- [ ] **Fichiers SQL** dans le repo : création de BDD + insertion de données
- [ ] **Dispositions de sécurité** détaillées dans la copie à rendre

---

## Récapitulatif des livrables

| Livrable | Format |
|---|---|
| Code source | Repo GitHub PUBLIC |
| Application déployée | URL en ligne |
| Logiciel gestion de projet | Lien Trello / Notion / Jira |
| README.md | Dans le repo |
| Fichiers SQL (création + données) | Dans le repo |
| Manuel d'utilisation | PDF dans le repo |
| Charte graphique + maquettes | PDF dans le repo |
| Documentation gestion de projet | PDF / dans la copie |
| Documentation technique | PDF / dans la copie |
| Copie à rendre | Word ou Excel (renommé selon convention) |

---

## Stratégie Git

```
main ← merge depuis develop (version stable testée)
  └── develop ← merge depuis les branches feature
        ├── feature/auth
        ├── feature/crud-menus
        ├── feature/commandes
        ├── feature/filtres-js
        ├── feature/espace-utilisateur
        ├── feature/espace-employe
        ├── feature/espace-admin
        ├── feature/mongodb-stats
        ├── feature/mails
        ├── feature/accessibilite
        └── ...
```

> **Règle** : chaque fonctionnalité = une branche depuis `develop`. Après test → merge vers `develop`. Quand `develop` est stable → merge vers `main`.

