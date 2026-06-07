<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a5f2a52ad7.js" crossorigin="anonymous"></script>
    <?php
    $chemin = $_SERVER['DOCUMENT_ROOT'] . '/Assets/CSS/' ;   
    if(isset($pageSpecificCss)) {
        if (is_array($pageSpecificCss)) {
            foreach ($pageSpecificCss as $cssFile) {

                echo '<link rel="stylesheet" href="/Assets/CSS/' . htmlspecialchars($cssFile) . '?v=' . filemtime($chemin .$cssFile) . '">' . PHP_EOL;
            }
        } else {

            // Ajout de '?v=' . time() pour le cache busting.
            echo '<link rel="stylesheet" href="/Assets/CSS/' . htmlspecialchars($pageSpecificCss) . '?v=' . filemtime($chemin . $pageSpecificCss) . '">' . PHP_EOL;
        }
    }
    ?>
    <title>Vite et gourmand</title>
</head>
<body>
    
    <header class="bg-primary">
        
        <p class="titre text-secondary">Vite & Gourmand</p>
        <ul class="d-flex lien-header" >
            <li><a href="/">Accueil</a></li>
            <li><a href="/menus">Nos menus</a></li>
            <li><a href="/contact">Contact</a></li>
        </ul>
        
        <div class="d-flex auth">
            <?php if(!isset($_SESSION['utilisateur_id'])): ?>
                <a href="/auth/login" class="border-secondary text-secondary btn-largeur ancre-auth">Connexion</a>
                <a href="/auth/register" class="border-secondary text-secondary btn-largeur ancre-auth">Créer un compte </a>
            <?php elseif(isset($_SESSION['utilisateur_id'])) : ?>
                <a href="/auth/logout" class="border-secondary text-secondary btn-largeur ancre-auth">Déconnexion</a>
                <?php if($_SESSION['role_id'] === 1) : ?>
                    <a href="/profile" class="border-secondary text-secondary btn-largeur ancre-auth">Voir profil</a>
                <?php endif ?>
            <?php endif ?>
        </div>
        <div class="dropdown ">
            <a class="btn  " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-bars"></i>
            </a>

            <ul class="dropdown-menu">
                <?php if(!isset($_SESSION['utilisateur_id'])): ?>
                    <li><a class="dropdown-item" href="/auth/login">Connexion</a></li>
                    <li><a class="dropdown-item" href="/auth/register">Créer un compte</a></li>
                <?php elseif(isset($_SESSION['utilisateur_id'])) : ?>
                    <li><a class="dropdown-item" href="/auth/logout">Déconnexion</a></li>
                    <?php if($_SESSION['role_id'] === 1) : ?>
                        <li><a class="dropdown-item" href="/profile">Voir profil</a></li>
                    <?php endif ?>
                <?php endif ?>
                <li><a class="dropdown-item" href="/">Accueil</a></li>
                <li><a class="dropdown-item" href="/menus">Nos menus</a></li>
                <li><a class="dropdown-item" href="/contact">Contact</a></li>
                <li><a class="dropdown-item" href="/avis">Avis clients</a></li>
            </ul>
        </div>
        
    </header>
    

