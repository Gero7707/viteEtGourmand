<?php
require_once __DIR__ . '/../../views/layout/header.php';
?>
<main>
    <a href="/">Accueil</a><br>
    
    <hr>
    <?php if ($_GET['error'] ?? null): ?>
        <p><?= htmlspecialchars($_GET['error']) ?></p><br>
        <hr>
    <?php elseif($_GET['success'] ?? null) :?>
        <p><?= htmlspecialchars($_GET['success']) ?></p><br>
        <hr>
    <?php endif ?>

<?php foreach($menus as $menu) : ?>
    <p><?= htmlspecialchars($menu['titre']) ?></p><br>
    <p><?= htmlspecialchars($menu['prix_par_personne']) ?></p><br>
    <img src="<?= htmlspecialchars($menu['image']) ?>" alt="" width="50" height="50">
    <p><?= htmlspecialchars($menu['nombre_personne_minimum']) ?></p><br>
    <p><?= htmlspecialchars($menu['description']) ?></p><br>
    <p><?= htmlspecialchars($menu['theme']) ?></p><br>
    <p><?= htmlspecialchars($menu['regime']) ?></p><br>
    <a href="/menus/<?=  htmlspecialchars($menu['menu_id']); ?>">Voir menu</a><br>
    <?php if(isset($_SESSION['role_id']) && ($_SESSION['role_id'] === 2 || $_SESSION['role_id'] === 3 )) : ?>
        <a href="/menus/edit/<?= htmlspecialchars($menu['menu_id']) ?>">Modifier</a><br>
        <form action="/menus/delete/<?= htmlspecialchars($menu['menu_id']) ?>" method="POST">
            <?= Auth::csrfField() ?>
            <button type="submit">Supprimer</button>
        </form>
    
    <?php endif ?>
    <hr>
<?php endforeach ?>
</main>




<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>