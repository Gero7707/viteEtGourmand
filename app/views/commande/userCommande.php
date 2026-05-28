<?php
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <?php if($_SESSION['role_id'] === 1 ) : ?>
        <a href="/profile">Retour profil</a><br>
    <?php elseif($_SESSION['role_id'] === 2 || $_SESSION['role_id'] === 3 )  : ?>
        <a href="/commandes-client">Retour aux commandes</a>
    <?php endif ?>

    <h3>Commande no : <?=   htmlspecialchars($commandes['numero_commande']) ?></h3>

    <h4><?= htmlspecialchars($commandes['titre']) ?></h4>
    <?php if($_SESSION['role_id'] === 3 || $_SESSION['role_id'] === 2) : ?>
        <p>Client :<?= htmlspecialchars($commandes['nom_complet']) ?> </p><br>
        <p>Adresse : <?= htmlspecialchars($commandes['adresse']) ?> </p><br>
        <p>Ville : <?= htmlspecialchars($commandes['ville'] ?? '') ?> </p><br>
        <p>Code postal :<?= htmlspecialchars($commandes['code_postal'] ?? '') ?></p><br>
        <p>Téléphone : <?= htmlspecialchars($commandes['gsm'] ?? '') ?></p><br>
        <p>Email : <?= htmlspecialchars($commandes['email']) ?></p><br>
    <?php endif ?>
    <hr>
    <p>Date de commande : <?= htmlspecialchars($commandes['date_commande']) ?></p><br>
    <p>Date de prestation : <?= htmlspecialchars($commandes['date_prestation']) ?></p><br>
    <p>Heure de livraison : <?= htmlspecialchars($commandes['heure_livraison']) ?></p><br>
    <p>Prix de la livraison : <?= htmlspecialchars($commandes['prix_livraison'] ?? '') ?></p><br>
    <p>Prix total : <?= htmlspecialchars($commandes['prix_menu']) ?></p><br>
    <p>Nombre de personne : <?=   htmlspecialchars($commandes['nombre_personne']) ?></p><br>
    <p>Statut: <?= htmlspecialchars($commandes['statut']) ?></p><br>
    <p>Prêt de matériel : <?= $commandes['pret_materiel'] ? 'Oui' : 'Non' ?></p><br>
    <p>Restitué : <?= $commandes['restitution_materiel'] ? 'Oui' : 'Non' ?></p>

    <h4>Historique</h4>
    <?php foreach($historique as $statut) : ?>
        <p>Statut : <?= htmlspecialchars($statut['statut']) ?></p><br>
        <p><?= htmlspecialchars($statut['date_modification']) ?></p>
    <?php endforeach ?>

</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>