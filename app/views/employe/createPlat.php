<?php
$pageSpecificCss = 'style.css';
require_once __DIR__ . '/../../views/layout/header.php';
?>


<main>
    <a href="/">Accueil</a><br>
    <a href="/plats">Plats</a><br>
    <?php if ($_GET['error'] ?? null): ?>
        <p><?= htmlspecialchars($_GET['error']) ?></p><br>
        <hr>
    <?php elseif($_GET['success'] ?? null) :?>
        <p><?= htmlspecialchars($_GET['success']) ?></p><br>
        <hr>
    <?php endif ?>
    <hr>
    <h4>Créer un plat</h4>
    <form action="/plats/create" method="POST" enctype="multipart/form-data">
        <?= Auth::csrfField() ?>
        <label for="titre_plat">Titre du plat </label><br>
        <input type="text" name="titre_plat" id="titre_plat" required><br>

        <label for="type_plat">Type </label><br>
        <select name="type_plat" id="type_plat" required>
            <option value="entree">Entrée</option>
            <option value="plat">Plat</option>
            <option value="dessert">Dessert</option>
        </select><br>

        <label for="allergene">Allergenes</label><br>
            <?php foreach($allergenes as $allergene) : ?>
                <input type="checkbox" name="allergenes[]" id="allergene_<?= $allergene['allergene_id'] ?>" value="<?= $allergene['allergene_id'] ?>">
                <label for="allergene_<?= $allergene['allergene_id'] ?>"><?= $allergene['libelle'] ?></label><br>
            <?php endforeach ?>

        <label for="chemin_photo">Image</label><br>
        <input type="file" name="chemin_photo" id="chemin_photo" required><br>

        <button type="submit">Céer plat</button>
    </form>
</main>


<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>