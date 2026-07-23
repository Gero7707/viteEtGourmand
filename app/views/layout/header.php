<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Vite & Gourmand — Traiteur événementiel à Bordeaux') ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription ?? 'Traiteur événementiel bordelais. Menus raffinés pour mariages, séminaires et réceptions. Commandez en ligne.') ?>">
    <meta name="theme-color" content="#1B2A4A">
    <meta name="apple-mobile-web-app-title" content="V&G" />

    <meta property="og:title" content="Vite & Gourmand">
    <meta property="og:description" content="Traiteur événementiel bordelais. Menus raffinés pour mariages, séminaires et réceptions. Commandez en ligne.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://restaurationviteetgourmand.alwaysdata.net/">
    <meta property="og:image" content="https://restaurationviteetgourmand.alwaysdata.net/assets/img/cuistot.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:type" content="image/jpeg">
    
    
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/assets/img/favicon.svg" />
    <link rel="shortcut icon" href="/assets/img/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/apple-touch-icon.png" />
    
    <link rel="manifest" href="/site.webmanifest" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a5f2a52ad7.js" crossorigin="anonymous"></script>
    <?php
    $chemin = $_SERVER['DOCUMENT_ROOT'] . '/assets/css/' ;   
    if(isset($pageSpecificCss)) {
        if (is_array($pageSpecificCss)) {
            foreach ($pageSpecificCss as $cssFile) {

                echo '<link rel="stylesheet" href="/assets/css/' . htmlspecialchars($cssFile) . '?v=' . filemtime($chemin .$cssFile) . '">' . PHP_EOL;
            }
        } else {

            // Ajout de '?v=' . time() pour le cache busting.
            echo '<link rel="stylesheet" href="/assets/css/' . htmlspecialchars($pageSpecificCss) . '?v=' . filemtime($chemin . $pageSpecificCss) . '">' . PHP_EOL;
        }
    }
    ?>
    
</head>
<body>
    
    <header class="bg-primary">
        
        <h1 class="titre text-secondary">Vite & Gourmand</h1>
        <ul class="d-flex lien-header lien-slide" >
            <?php //if (getenv('APP_ENV') === 'dev'): ?>
                <!-- <button popovertarget="my-popover">Open Var dump</button>
                <div popover id="my-popover"><?php //var_dump($_COOKIE); ?></div> -->
            <?php //endif; ?>
            <li><a href="/">Accueil</a></li>
            <li><a href="/menus">Nos menus</a></li>
            <li><a href="/contact">Contact</a></li>
        </ul>
        
        <div class="d-flex auth">
            <?php if(!isset($_SESSION['utilisateur_id'])): ?>
                <a href="/auth/login" class="border-secondary text-secondary btn-largeur ancre-auth">Connexion</a>
                <a href="/auth/register" class="border-secondary text-secondary btn-largeur ancre-auth">Créer un compte </a>
            <?php elseif(isset($_SESSION['utilisateur_id'])) : ?>
                <form action="/auth/logout" method="POST">
                    <?= Auth::csrfField() ?>
                    <button type="submit" class="border-secondary text-secondary btn-largeur ancre-auth">Déconnexion</button>
                </form>
                <?php if($_SESSION['role_id'] === 1) : ?>
                    <a href="/profile" class="border-secondary text-secondary btn-largeur ancre-auth">Voir profil</a>
                <?php endif ?>
            <?php endif ?>
        </div>
            <?php if(isset($_SESSION['utilisateur_id']) && ($_SESSION['role_id']=== 2 || $_SESSION['role_id'] === 3) && ($pageMenu ?? false)) :?>
                <div class="dropdown dropdown-entreprise ">
            <?php else :?>
                <div class="dropdown">
            <?php endif ?>
        
            <a class="btn  " href="#" role="button" aria-label="Menu de navigation" data-bs-toggle="dropdown" aria-expanded="false">
                <?php if(!isset($_SESSION['utilisateur_id']) || $_SESSION['role_id'] === 1): ?>
                    <i aria-hidden="true" class="fa-solid fa-bars"></i>
                <?php elseif($_SESSION['role_id'] === 2  || $_SESSION['role_id'] === 3) : ?>
                    <i aria-hidden="true" class="fa-solid fa-utensils"></i>
                <?php endif ?>
            </a>

            <ul class="dropdown-menu">
                <?php if(!isset($_SESSION['utilisateur_id'])): ?>
                    <li><a class="dropdown-item" href="/auth/login">Connexion</a></li>
                    <li><a class="dropdown-item" href="/auth/register">Créer un compte</a></li>
                <?php elseif(isset($_SESSION['utilisateur_id'])) : ?>
                    <form action="/auth/logout" method="POST">
                        <?= Auth::csrfField() ?>
                        <button type="submit" class="dropdown-item">Déconnexion</button>
                    </form>
                    <?php if($_SESSION['role_id'] === 1) : ?>
                        <li><a class="dropdown-item" href="/profile">Voir profil</a></li>
                    <?php endif ?>
                <?php endif ?>
                <li><a class="dropdown-item" href="/">Accueil</a></li>
                <li><a class="dropdown-item" href="/menus">Nos menus</a></li>
                <li><a class="dropdown-item" href="/contact">Contact</a></li>
                <li><a class="dropdown-item" href="/avis">Avis clients</a></li>
                <?php if(isset($_SESSION['utilisateur_id'])  && ($_SESSION['role_id'] === 2  || $_SESSION['role_id'] === 3)) : ?>
                    <?php if ($_SESSION['role_id'] === 2) :  ?>
                    <li><a class="dropdown-item" href="/employe/dashboard" >Dashoard</a></li>
                    <li><a class="dropdown-item" href="/commandes-client" >Commandes</a></li>
                    <li><a class="dropdown-item" href="/avis-valider" >Valider avis</a></li>
                    <li><a class="dropdown-item" href="/create-menu">Céer menu</a></li>
                    <li><a class="dropdown-item" href="/plats">Plats</a></li>
                    <li><a class="dropdown-item" href="/plats/create">Créer plats</a></li>
                    <li><a class="dropdown-item" href="/changer-horaire" >Horaires</a></li>
                    <?php elseif ($_SESSION['role_id'] === 3) :  ?>
                    <li><a class="dropdown-item" href="/admin/dashboard" >Dashoard</a></li>
                    <li><a class="dropdown-item" href="/commandes-client" >Commandes</a></li>
                    <li><a class="dropdown-item" href="/avis-valider" >Valider avis</a></li>
                    <li><a class="dropdown-item" href="/create-menu">Céer menu</a></li>
                    <li><a class="dropdown-item" href="/plats">Plats</a></li>
                    <li><a class="dropdown-item" href="/plats/create">Créer plats</a></li>
                    <li><a class="dropdown-item" href="/changer-horaire" >Horaires</a></li>
                    <?php endif ?>
                <?php endif ?>
            </ul>
        </div>
        
    </header>
    

