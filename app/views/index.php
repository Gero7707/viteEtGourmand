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
        <p><?= htmlspecialchars($carteAvis['nom_complet']) ?></p>
        <p><?= htmlspecialchars($carteAvis['note']) ?></p>
        <p><?= htmlspecialchars($carteAvis['description']) ?></p>
        <p><?= htmlspecialchars(str_replace(':00', 'h',date('d-m-Y  à  H:i', strtotime($carteAvis['date_avis'])))) ?></p>
        <hr>
    <?php endforeach ?>


    <br><hr><br>
    
    
</main>


<?php
require_once __DIR__ . '/../views/layout/footer.php';
?>