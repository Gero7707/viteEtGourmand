<?php
require_once __DIR__ . '/../../views/layout/header.php';
?>
<main>

<?php foreach($menus as $menu) : ?>
    <p><?= htmlspecialchars($menu['titre']) ?></p><br>
    <p><?= htmlspecialchars($menu['prix_par_personne']) ?></p><br>
    <img src="<?= htmlspecialchars($menu['image']) ?>" alt="" width="50" height="50">
    <p><?= htmlspecialchars($menu['nombre_personne_minimum']) ?></p><br>
    <p><?= htmlspecialchars($menu['description']) ?></p><br>
    <p><?= htmlspecialchars($menu['theme']) ?></p><br>
    <p><?= htmlspecialchars($menu['regime']) ?></p>
    <hr>
<?php endforeach ?>
</main>




<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>