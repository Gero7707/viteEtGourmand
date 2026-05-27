<?php
require_once __DIR__ . '/../../views/layout/header.php';
?>


<main>
    <a href="/">Accueil</a><br>
    <table>
        <thead>
            <tr>
                <th>Menu</th>
                <th>Nom Client</th>
                <th>No Commande</th>
                <th>Date prestation</th>
                <th>Nombre</th>
                <th>Statut</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($commandes as $commande) : ?>
                <tr>
                    <td><?= htmlspecialchars($commande['titre']) ?></td>
                    <td><?= htmlspecialchars($commande['nom_complet']) ?></td>
                    <td><?= htmlspecialchars($commande['numero_commande']) ?></td>
                    <td><?= htmlspecialchars($commande['date_prestation']) ?></td>
                    <td><?= htmlspecialchars($commande['nombre_personne']) ?></td>
                    <td><?= htmlspecialchars($commande['statut']) ?></td>
                    <td>
                        <a href="/modif-commande/<?= $commande['commande_id'] ?>">Modifier</a>
                    </td>
                    <td>
                        <a href="/commandes/<?= $commande['commande_id'] ?>">Voir</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    
</main> 

<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>