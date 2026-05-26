<?php
require_once __DIR__ . '/../views/layout/header.php';
?>

<main>
    <?php if(!isset($_SESSION['utilisateur_id'])): ?>
        <a href="/auth/login">Connexion</a><br>
        <a href="/auth/register">Créer un compte </a><br>
    <?php endif ?>
    
    <hr><br>
    <?php if(isset($_SESSION['utilisateur_id'])): ?>
        <p>Connecté en tant que <?= $_SESSION['prenom'] ?></p>
        <a href="/auth/logout">Déconnexion</a>
    <?php endif ?>

    <?php if ($_GET['error'] ?? null): ?>
        <p><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <br><hr><br>
    <?php foreach($avis as $carteAvis) : ?>
        <p><?= htmlspecialchars($carteAvis['']) ?></p>


    <br><hr><br>
    
    <?php foreach($horaire  as $jour) : ?>
        <p><?= htmlspecialchars($jour['jour']) ?> - <?= htmlspecialchars(str_replace('h00', 'h',ltrim( $jour['heure_ouverture'], '0'))) ?> - <?= htmlspecialchars(str_replace('h00', 'h',ltrim($jour['heure_fermeture'], '0'))) ?></p>
    <?php endforeach ?>
</main>


<?php
require_once __DIR__ . '/../views/layout/footer.php';
?>