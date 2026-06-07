<?php
require_once __DIR__ . '/../../views/layout/header.php';
?>
<main>
    <a href="/">Accueil</a><br>
    <a href="/menus">Retour aux menus</a><br>
    <hr>
    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>


    <h4>Titre</h4>
    <p><?= htmlspecialchars($menus['titre']) ?></p><br>
    <h4>Prix/pers</h4>
    <p><?= htmlspecialchars($menus['prix_par_personne']) ?></p><br>
    <h4>Nb min</h4>
    <p><?= htmlspecialchars($menus['nombre_personne_minimum']) ?></p><br>
    <h4>Quantité restante</h4>
    <p><?= htmlspecialchars($menus['quantite_restante']) ?></p><br>
    <h4>Description</h4>
    <p><?= htmlspecialchars($menus['description']) ?></p><br>
    <h4>Theme</h4>
    <p><?= htmlspecialchars($menus['theme']) ?></p><br>
    <h4>Regime</h4>
    <p><?= htmlspecialchars($menus['regime']) ?></p><br>
    <h4>Plats</h4>
    <?php foreach($plat as $p) : ?>
        <h5><?= htmlspecialchars($p['type_plat']) ?></h5>
        <p><?= htmlspecialchars($p['titre_plat']) ?></p>
        <img src="/<?= htmlspecialchars($p['chemin_photo']) ?>" alt="" width="50" height="50">
        <h4>Allergènes :</h4>
        <?php foreach($p['allergenes'] as $allergene) : ?>
            <p><?= htmlspecialchars($allergene['libelle']) ?></p>
        <?php endforeach ?>
        <?php if(isset($_SESSION['role_id'] ) && ($_SESSION['role_id'] === 2 || $_SESSION['role_id'] === 3)) : ?>
            <form action="/plats/dissocier/<?= htmlspecialchars($p['plat_id']) ?>" method="POST">
                <input type="hidden" name="menu_id" value="<?= htmlspecialchars($menus['menu_id']) ?>">
                <?= Auth::csrfField() ?>
                <button type="submit">Dissocier plat</button>
            </form>
        <?php endif ?>
    <?php endforeach ?>
    <h4>Conditions:</h4>
    <h5>Delai :</h5>
    <p><?= htmlspecialchars($menus['conditions_delai']) ?></p>
    <h5>Stockage :</h5>
    <p><?= htmlspecialchars($menus['conditions_stockage']) ?></p>
    <h5>Infos :</h5>
    <p><?= htmlspecialchars($menus['conditions_infos']) ?></p>

    <a href="/commandes/create/<?=  htmlspecialchars($menus['menu_id']); ?>">Commander</a>

</main>




<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>