<?php
$pageSpecificCss = 'style.css';
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <a href="/">Accueil</a><br>

    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>

    <p><?= htmlspecialchars($user['prenom'])  ?> , voici vos infos </p><br>
    <p>Votre email : <?= htmlspecialchars($user['email'])  ?></p><br>
    <p>Votre Nom : <?= htmlspecialchars($user['nom'])  ?></p><br>
    <p>Votre Prenom : <?= htmlspecialchars($user['prenom'])  ?></p><br>
    <p>Votre numéro de téléphone :  <?= htmlspecialchars($user['gsm']?? '' )  ?></p><br>
    <p>Votre ville :  <?= htmlspecialchars($user['ville'] ?? '' )  ?></p><br>
    <p>Votre adresse :  <?= htmlspecialchars($user['adresse'] ?? '' )  ?></p><br>
    <p>Votre code postale :  <?= htmlspecialchars($user['code_postal'] ?? '' )  ?></p><br>
    <hr>
    <h4>Vos commandes</h4><br>
    <?php foreach($commandes as $commande) : ?>
        <p><?= htmlspecialchars($commande['numero_commande'])  ?></p><br>
        <p><?= htmlspecialchars($commande['date_commande'])  ?></p><br>
        <p><?= htmlspecialchars($commande['titre'])  ?></p><br>
        <p><?= htmlspecialchars($commande['statut'])  ?></p><br>
        <a href="/commandes/<?= $commande['commande_id'] ?>">Voir commande</a><br>
    <?php endforeach ?>
        <a href="/profile/edit">Modifier profil</a>
</main>



$pageSpecificCss = 'style.css';