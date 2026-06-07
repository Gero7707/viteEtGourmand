<?php
$pageSpecificCss = 'style.css';
require_once __DIR__ . '/../../views/layout/header.php';
?>
<main>
    <a href="/plats">Retour aux plats</a><br>
    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
    <hr>
    <h4>Modifier un plat</h4>
    <form action="/plats/edit/<?= htmlspecialchars($plats['plat_id']) ?>" method="POST" enctype="multipart/form-data">
        <?= Auth::csrfField() ?>
        <label for="titre_plat">Titre du plat </label><br>
        <input type="text" name="titre_plat" id="titre_plat" value="<?= htmlspecialchars($plats['titre_plat']) ?>" required><br>

        <label for="type_plat">Type </label><br>
        <select name="type_plat" id="type_plat" value="<?= htmlspecialchars($plats['type_plat']) ?>" required>
            <option value="entree"<?= htmlspecialchars($plats['type_plat']) == 'entree' ? 'selected' : '' ?>>Entrée</option>
            <option value="plat" <?= htmlspecialchars($plats['type_plat']) == 'plat' ? 'selected' : '' ?>>Plat</option>
            <option value="dessert" <?= htmlspecialchars($plats['type_plat']) == 'dessert' ? 'selected' : '' ?>>Dessert</option>
        </select><br>

        <label for="allergene">Allergenes</label><br>
            <?php foreach($allergenes as $allergene) : ?>
                <input type="checkbox" name="allergenes[]" id="allergene_<?= $allergene['allergene_id'] ?>" value="<?= $allergene['allergene_id'] ?>"  <?= in_array($allergene['allergene_id'], $allergenesIds) ? 'checked' : '' ?>>
                <label for="allergene_<?= $allergene['allergene_id'] ?>"><?= $allergene['libelle'] ?></label><br>
            <?php endforeach ?>

        <img src="/<?=htmlspecialchars($plats['chemin_photo']) ?>" alt="" height="50" width="50"><br>
        <input type="file" name="chemin_photo" id="chemin_photo" ><br>
        <button type="button" id="btn-showUpload-plat">Changer Image</button><br>

        <button type="submit">Modifier plat</button>
    </form>
</main>
<script src="/assets/js/cta.js"></script>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>