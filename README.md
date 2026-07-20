# 🍽️ Vite & Gourmand

Application web pour **Vite & Gourmand**, traiteur événementiel basé à Bordeaux depuis 25 ans. Permet aux clients de consulter les menus, passer des commandes et suivre leur préparation.

Projet réalisé dans le cadre du **TP Développeur Web et Web Mobile** (Studi).

---

## Stack technique

- **Front-end** : HTML5, CSS3, JavaScript vanilla
- **Back-end** : PHP 8.3 vanilla (PDO)
- **Base de données relationnelle** : MySQL 8.0.42
- **Base de données NoSQL** : MongoDB
- **Serveur** : Apache (via Docker)
- **Envoi d'emails** : PHPMailer + Mailtrap (dev)
- **Conteneurisation** : Docker / Docker Compose

> Environnement de développement : PHP 8.3 / MySQL 8.0.42.
> Production (Alwaysdata) : PHP 8.4 / MariaDB 11.4. Divergence volontaire, compatibilité assurée lors des tests en production.

---

## Prérequis

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) installé et lancé
- [Git](https://git-scm.com/)
- [Composer](https://getcomposer.org/) (pour installer les dépendances PHP)

---

## Installation

### 1. Cloner le repository

```bash
git clone https://github.com/Gero7707/viteEtGourmand.git
cd viteEtGourmand
```

### 2. Configurer les variables d'environnement

Créer un fichier `.env` à la racine du projet :

```env
# Base de données
DB_HOST=mysql
DB_PORT=3306
DB_NAME=vite_et_gourmand
DB_USER=root
DB_PASSWORD=votre_mot_de_passe

# Application
APP_ENV=development
APP_URL=http://localhost:8080

# Mailtrap (emails de développement)
MAILTRAP_HOST=sandbox.smtp.mailtrap.io
MAILTRAP_PORT=2525
MAILTRAP_USERNAME=votre_username_mailtrap
MAILTRAP_PASSWORD=votre_password_mailtrap
```

### 3. Installer les dépendances PHP

```bash
composer install
```

### 4. Lancer les containers Docker

```bash
docker-compose up -d --build
```

### 5. Importer les bases de données

**MySQL** - deux fichiers dans `sql/` : `db.sql` crée la base et les tables, `insert.sql` charge les données de test.

```bash
docker exec -i viteetgourmand-mysql-1 mysql -u root -pvotre_mot_de_passe vite_et_gourmand < sql/db.sql
docker exec -i viteetgourmand-mysql-1 mysql -u root -pvotre_mot_de_passe vite_et_gourmand < sql/insert.sql
```

**MongoDB** - la collection analytique du dashboard est peuplée depuis `config/vite_gourmand.commandes.json`. On copie d'abord le fichier dans le conteneur, puis on l'importe :

​```bash
docker cp config/vite_gourmand.commandes.json vite_gourmand_mongodb:/tmp/
docker exec vite_gourmand_mongodb mongoimport --db vite_gourmand --collection commandes --jsonArray --file /tmp/vite_gourmand.commandes.json
​```


### 6. Accéder à l'application

Ouvrir le navigateur à l'adresse : **http://localhost:8080**

---

## Structure du projet

```
ViteEtGourmand/
├── public/                  ← Point d'entrée (seul dossier accessible par le navigateur)
│   ├── index.php            ← Front Controller
│   ├── .htaccess            ← Réécriture d'URL vers index.php
│   └── assets/
│       ├── css/
│       ├── js/
│       └── img/
│           ├── menus/
│           └── plats/
├── app/
│   ├── controllers/         ← Logique de traitement des requêtes
│   ├── models/              ← Accès aux données (requêtes SQL)
│   ├── views/               ← Templates HTML/PHP
│   │   └── layout/          ← Header, footer réutilisables
│   └── services/            ← Services métier (MailService)
├── core/
│   ├── Router.php           ← Routeur maison
│   ├── Database.php         ← Connexion PDO (Singleton)
│   └── Auth.php             ← Sécurité (CSRF, sessions, contrôle d'accès)
├── sql/
│   ├── db.sql    ← Création des tables
│   └── insert.sql      ← Jeu de données de test
├── config/
├── apache.conf              ← Configuration Apache (DocumentRoot, headers sécurité)
├── Dockerfile               ← Image PHP 8.3 + Apache
├── docker-compose.yml       ← Orchestration des services (PHP, MySQL)
├── .env                     ← Variables d'environnement (non versionné)
└── .gitignore
```

---

## Comptes de test

Les identifiants de connexion sont fournis dans le document de rendu remis avec l'ECF.

| Rôle           | Email                      |
|----------------|----------------------------|
| Administrateur | jose@viteetgourmand.fr     |
| Employé        | julie@viteetgourmand.fr    |
| Client         | sophie.martin@email.fr     |

---

## Sécurité

- Mots de passe hashés avec `password_hash()` (bcrypt)
- Protection CSRF sur tous les formulaires
- Sessions sécurisées (httponly, samesite, strict mode)
- Requêtes préparées (PDO) contre les injections SQL
- Échappement des sorties (`htmlspecialchars`) contre le XSS
- Headers de sécurité HTTP (X-Frame-Options, CSP, X-Content-Type-Options)
- Limitation des tentatives de connexion (brute force)
- `DocumentRoot` limité à `public/` — le code source n'est pas accessible par URL

---

## Stratégie Git

```
main ← version stable testée
develop ← intégration des fonctionnalités
        
```

Chaque fonctionnalité est développée sur une branche `develop`. Après test quand `develop` est stable, synchronisation sélective par `git checkout develop -- fichier` en étant positionné sur la branche `main`, permettant de sélectionner uniquement les fichiers voulus. Pour justifier ce choix `MailService.php` et `MongoDatabase.php` doivent rester différents entre les deux branches. `Mailtrap` vs `Brevo` pour l'un, `Mongo local` vs `Atlas` pour l'autre. La synchronisation fichier par fichier préserve cette divergence voulue. En équipe, j'utiliserais des branches `feature/` fusionnées dans `develop`.
