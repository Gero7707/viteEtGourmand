<?php
require_once __DIR__ . '/../views/layout/header.php';
?>

<main>
    <?php if(!isset($_SESSION['utilisateur_id'])): ?>
        
        <div class="text-center mt-2 intro">
            <p class="fw-mediumbold text-center">L'art de la réception, depuis 1999 </p><br>
            <p class="fw-mediumbold text-center mb-4">Vite & Gourmand, traiteur événementiel à Bordeaux. Des menus raffinés, livrés chez vous,pour tous vos événements.</p>
            <a href="/menus" class="fw-mediumbold bg-secondary text-primary lien-intro ">Découvrir nos menus</a>
        
        </div>
    <?php elseif(isset($_SESSION['utilisateur_id'])): ?>

        <?php if($_SESSION['role_id'] === 1) : ?>
            <div class="text-center mt-2 intro">
                <p class="fw-mediumbold text-center">Bonjour  <?= $_SESSION['prenom'] ?>  !</p><br>
                <p class="fw-mediumbold text-center">L'art de la réception, depuis 1999 </p><br>
                <p class="fw-mediumbold text-center mb-4">Vite & Gourmand, traiteur événementiel à Bordeaux. Des menus raffinés, livrés chez vous,pour tous vos événements.</p>
                <a href="/menus" class="fw-mediumbold bg-secondary text-primary lien-intro ">Découvrir nos menus</a>
            </div>
        <?php elseif ($_SESSION['role_id'] === 2) :  ?>
        <a href="/commandes-client">Commandes</a><br>
        <a href="/avis-valider">Avis</a><br>
        <a href="/menus">Menus</a><br>
        <a href="/create-menu">Créer un menu</a><br>
        <a href="/plats">Plats</a><br>
        <a href="/plats/create">Créer un plat</a><br>
        <a href="/changer-horaire">Changer horaire</a><br>
        <a href="/employe/dashboard">Dashoard</a><br>
        <?php elseif ($_SESSION['role_id'] === 3) :  ?>
        <a href="/commandes-client">Commandes</a><br>
        <a href="/avis-valider">Avis</a><br>
        <a href="/menus">Menus</a><br>
        <a href="/create-menu">Créer un menu</a><br>
        <a href="/plats">Plats</a><br>
        <a href="/plats/create">Créer un plat</a><br>
        <a href="/changer-horaire">Changer horaire</a><br>
        <a href="/admin/dashboard">Dashoard</a><br>
        <?php endif ?>

    <?php endif ?>

    <?php if ($_GET['error'] ?? null): ?>
        <p><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <br><hr><br>

    <h3>Carousel</h3>
    
    <br><hr><br>
    <?php foreach($avis as $carteAvis) : ?>
        <p><?= htmlspecialchars($carteAvis['nom_complet']) ?></p>
        <p><?= htmlspecialchars($carteAvis['note']) ?></p>
        <p><?= htmlspecialchars($carteAvis['description']) ?></p>
        <p><?= htmlspecialchars(str_replace(':00', 'h',date('d-m-Y  à  H:i', strtotime($carteAvis['date_avis'])))) ?></p>
        <hr>
    <?php endforeach ?>
    <a href="/avis">Voir tous les avis</a>


    <br><hr><br>
    
    
</main>


<?php
require_once __DIR__ . '/../views/layout/footer.php';
?>