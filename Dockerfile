# Image de base — PHP 8.3.23 avec Apache intégré
# Contient PHP-FPM + Apache préconfiguré pour servir des applications PHP
FROM php:8.3.23-apache

# ============================================================
# EXTENSIONS PHP
# pdo — interface abstraite pour les bases de données
# pdo_mysql — driver MySQL pour PDO
# ============================================================
RUN docker-php-ext-install pdo pdo_mysql

# ============================================================
# MODULES APACHE
# rewrite — permet la réécriture d'URL (nécessaire pour le router maison)
# headers — permet d'envoyer des headers HTTP personnalisés (sécurité dans apache.conf)
# ============================================================
RUN a2enmod rewrite
RUN a2enmod headers

# Remplace la configuration Apache par défaut par notre apache.conf personnalisé
# 000-default.conf est le fichier de configuration du site par défaut d'Apache
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Dossier de travail dans le container — toutes les commandes suivantes s'exécutent ici
WORKDIR /var/www/html

# Copie tous les fichiers du projet dans le container
# Le .dockerignore permet d'exclure les fichiers inutiles (vendor, .git etc.)
COPY . .

# Donne les droits de lecture/écriture à www-data (utilisateur Apache)
# Nécessaire pour les uploads, logs, et l'accès aux fichiers PHP
RUN chown -R www-data:www-data /var/www/html