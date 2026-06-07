<?php
$pageSpecificCss = 'style.css';
require_once __DIR__ . '/../../views/layout/header.php';
?>


<main>
    <a href="/">Accueil</a><br>
    <?php if($_SESSION['role_id'] === 2 ) : ?>
        <a href="/employe/dashboard">Dashboard</a><br>
    <?php elseif($_SESSION['role_id'] === 3 )  : ?>
        <a href="/admin/dashboard">Dashboard</a><br>
    <?php endif ?>
    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
    
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
                        <?php if($commande['statut'] !== 'terminee' && $commande['statut'] !== 'annulee') : ?>
                            <form action="/commandes/update/<?= $commande['commande_id'] ?>" method="POST">
                                <?= Auth::csrfField() ?>
                                <button type="submit">Modifier statut</button>
                            </form>
                        <?php endif ?>
                    </td>
                    <td>
                        <a href="/commandes/<?= $commande['commande_id'] ?>">Voir</a>
                    </td>
                    <td>
                        <?php if($commande['statut'] !== 'terminee' && $commande['statut'] !== 'annulee') : ?>
                            <a href="/commandes/annuler-commande/<?= $commande['commande_id'] ?>">Annuler Commande</a>
                        <?php endif ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    
</main> 

<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>