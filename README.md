# 🍽️ Vite & Gourmand

Application web pour **Vite & Gourmand**, traiteur événementiel basé à Bordeaux depuis 25 ans. Permet aux clients de consulter les menus, passer des commandes et suivre leur préparation.

Projet réalisé dans le cadre du **TP Développeur Web et Web Mobile** (Studi).

---

## Stack technique

- **Front-end** : HTML5, CSS3, JavaScript vanilla
- **Back-end** : PHP 8.3 vanilla (PDO)
- **Base de données relationnelle** : MySQL 8.0
- **Base de données NoSQL** : MongoDB
- **Serveur** : Apache (via Docker)
- **Envoi d'emails** : PHPMailer + Mailtrap (dev)
- **Conteneurisation** : Docker / Docker Compose

---

## Prérequis

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) installé et lancé
- [Git](https://git-scm.com/)
- [Composer](https://getcomposer.org/) (pour installer les dépendances PHP)

---

## Installation

### 1. Cloner le repository

```bash
git clone https://github.com/VOTRE-USERNAME/ViteEtGourmand.git
cd ViteEtGourmand
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

### 5. Importer la base de données

Les fichiers SQL se trouvent dans le dossier `sql/` :

```bash
docker exec -i viteetgourmand-mysql-1 mysql -u root -pvotre_mot_de_passe vite_et_gourmand < sql/create_tables.sql
docker exec -i viteetgourmand-mysql-1 mysql -u root -pvotre_mot_de_passe vite_et_gourmand < sql/insert_data.sql
```

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
│   ├── create_tables.sql    ← Création des tables
│   └── insert_data.sql      ← Jeu de données de test
├── config/
├── apache.conf              ← Configuration Apache (DocumentRoot, headers sécurité)
├── Dockerfile               ← Image PHP 8.3 + Apache
├── docker-compose.yml       ← Orchestration des services (PHP, MySQL)
├── .env                     ← Variables d'environnement (non versionné)
└── .gitignore
```

---

## Comptes de test

| Rôle           | Email                      | Mot de passe   |
|----------------|----------------------------|----------------|
| Administrateur | jose@viteetgourmand.fr     | *à compléter*  |
| Employé        | julie@viteetgourmand.fr    | *à compléter*  |
| Client         | sophie.martin@email.fr     | *à compléter*  |

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
  └── develop ← intégration des fonctionnalités
        ├── feature/router-upgrade
        ├── feature/auth
        ├── feature/crud-menus
        ├── feature/commandes
        └── ...
```

Chaque fonctionnalité est développée dans une branche `feature/` depuis `develop`. Après test → merge vers `develop`. Quand `develop` est stable → merge vers `main`.
