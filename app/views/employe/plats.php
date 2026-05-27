<?php
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <a href="/">Accueil</a><br>
    <a href="/menus">Menus</a><br>
    <hr>
    <?php foreach($plat as $cartePlat) : ?>
        <h4><?= htmlspecialchars($cartePlat['titre_plat']) ?></h4>

        <p><?= htmlspecialchars($cartePlat['type_plat']) ?></p>
        <p><?= htmlspecialchars($cartePlat['menu_titre']) ?></p>
        <img src="<?= htmlspecialchars($cartePlat['chemin_photo']) ?>" alt="" width="50" height="50">
        <?php foreach($cartePlat['allergenes'] as $allergene) : ?>
            <p><?= htmlspecialchars($allergene['libelle']) ?></p>
        <?php endforeach ?>
    <?php endforeach ?>
</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>