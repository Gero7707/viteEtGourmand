<?php
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <a href="/">Accueil</a><br>
    <a href="/menus">Menus</a><br>
    <?php if($_SESSION['role_id'] === 2 || $_SESSION['role_id'] === 3) : ?>
        <a href="/plats/create">Créer un plat</a><br>
    <?php endif ?>
    <hr>
    <?php if ($_GET['error'] ?? null): ?>
        <p><?= htmlspecialchars($_GET['error']) ?></p><br>
        <hr>
    <?php elseif($_GET['success'] ?? null) :?>
        <p><?= htmlspecialchars($_GET['success']) ?></p><br>
        <hr>
    <?php endif ?>
    <?php foreach($plat as $cartePlat) : ?>
        <h4><?= htmlspecialchars($cartePlat['titre_plat']) ?></h4>

        <p><?= htmlspecialchars($cartePlat['type_plat']) ?></p>
        <p><?= htmlspecialchars($cartePlat['menu_titre'] ?? 'N\'est pas assigné à un menu') ?></p>
        <img src="<?= htmlspecialchars($cartePlat['chemin_photo']) ?>" alt="" width="50" height="50">
        <?php foreach($cartePlat['allergenes'] as $allergene) : ?>
            <p><?= htmlspecialchars($allergene['libelle']) ?></p>
        <?php endforeach ?>
        <a href="/plats/edit/<?= htmlspecialchars($cartePlat['plat_id']) ?>">Modifier</a><br>
        <form action="/plats/delete/<?= htmlspecialchars($cartePlat['plat_id']) ?>" method="POST">
            <?= Auth::csrfField() ?>
            <button type="submit">Supprimer</button><br>
        </form>
        <form action="plats/associer/<?= htmlspecialchars($cartePlat['plat_id']) ?>" method="POST">
            <?= Auth::csrfField() ?>
            <select name="menu_id" id="menu_id"  required>
                <? foreach($cartePlat['menu'] as $menu) : ?>
                    <option value="<?= htmlspecialchars($menu['menu_id']) ?>"><?= htmlspecialchars($menu['titre']) ?></option>
                <? endforeach ?>
            </select><br>
            <button type="submit">Associer</button>
        </form>
    <?php endforeach ?>
</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>