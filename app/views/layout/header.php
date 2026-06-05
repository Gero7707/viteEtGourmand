<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a5f2a52ad7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/assets/css/style.css">
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
        <?php endif ?>
    </div>
        
    </header>
    

