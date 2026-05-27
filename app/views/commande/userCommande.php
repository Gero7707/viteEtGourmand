<?php
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <a href="/profile">Retour profil</a><br>


    <h3>Commande no : <?=   htmlspecialchars($commandes['numero_commande']) ?></h3>
    <h4><?= htmlspecialchars($commandes['titre']) ?></h4>
    <hr>
    <p>Date de commande : <?=   htmlspecialchars($commandes['date_commande']) ?></p><br>
    <p>Date de prestation : <?=   htmlspecialchars($commandes['date_prestation']) ?></p><br>
    <p>Heure de livraison : <?=   htmlspecialchars($commandes['heure_livraison']) ?></p><br>
    <p>Prix total : <?=   htmlspecialchars($commandes['prix_menu']) ?></p><br>
    <p>Nombre de personne : <?=   htmlspecialchars($commandes['nombre_personne']) ?></p><br>
    <p>Prix de la livraison : <?=   htmlspecialchars($commandes['prix_livraison'] ?? '') ?></p><br>
    <p>Statut: <?=   htmlspecialchars($commandes['statut']) ?></p><br>
    <p>Prêt de matériel : <?= $commandes['pret_materiel'] ? 'Oui' : 'Non' ?></p><br>
    <p>Restitué : <?= $commandes['restitution_materiel'] ? 'Oui' : 'Non' ?></p>

    <h4>Historique</h4>
    <?php foreach($historique as $statut) : ?>
        <p>Statut : <?=   htmlspecialchars($statut['statut']) ?></p><br>
        <p><?=   htmlspecialchars($statut['date_modification']) ?></p>
    <?php endforeach ?>

</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>