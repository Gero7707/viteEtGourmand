<?php
$pageSpecificCss = ['style.css' , 'formulaire.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>
<main>
    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message-php mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message-php mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
    <div class="d-flex justify-content-center">
        <div class="d-flex flex-column text-center form-contact">
            <h3 class="text-center mt-4 mb-5">Modifier un plat</h3>
            <form action="/plats/edit/<?= htmlspecialchars($plats['plat_id']) ?>" method="POST" enctype="multipart/form-data" class="text-center">
                <?= Auth::csrfField() ?>

                <label class="form-label" for="titre_plat">Titre du plat </label><br>
                <input class="mt-3 mb-3" type="text" name="titre_plat" id="titre_plat" value="<?= htmlspecialchars($plats['titre_plat']) ?>" required><br>

                <div class="cadre-input">
                    <label class="form-label" for="type_plat">Type </label><br>
                    <select name="type_plat" id="type_plat" value="<?= htmlspecialchars($plats['type_plat']) ?>" required>
                        <option value=""></option>
                        <option value="entree"<?= htmlspecialchars($plats['type_plat']) == 'entree' ? 'selected' : '' ?>>Entrée</option>
                        <option value="plat" <?= htmlspecialchars($plats['type_plat']) == 'plat' ? 'selected' : '' ?>>Plat</option>
                        <option value="dessert" <?= htmlspecialchars($plats['type_plat']) == 'dessert' ? 'selected' : '' ?>>Dessert</option>
                    </select><br>
                </div>

                <div class="cadre-input">
                    <label class="form-label" for="allergene">Allergenes :</label><br>
                    <div class="check-allergene m-auto">
                        <?php foreach($allergenes as $allergene) : ?>
                            <div class="d-flex flex-start">
                                <input type="checkbox" name="allergenes[]" id="allergene_<?= $allergene['allergene_id'] ?>" value="<?= $allergene['allergene_id'] ?>"  <?= in_array($allergene['allergene_id'], $allergenesIds) ? 'checked' : '' ?>>
                                <label class="form-label" for="allergene_<?= $allergene['allergene_id'] ?>"><?= $allergene['libelle'] ?></label><br>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>

                <div class="cadre-input">
                    <label class="form-label" for="chemin_photo">Image :</label>
                    <img src="/<?=htmlspecialchars($plats['chemin_photo']) ?>" alt="" height="50" width="50"><br>
                    <input class="form-control input-img" type="file" name="chemin_photo" id="chemin_photo" ><br>
                    <button type="button" id="btn-showUpload-plat">Changer Image</button><br>
                </div>
                <p class="error-message mt-1 text-center"></p><br>
                <button class="btn-form mt-3 mb-3" type="submit">Modifier plat</button>
            </form>
        </div>
    </div>
    
</main>
<script src="/assets/js/cta.js"></script>
<?php
$loadScriptJs = ['form.js' , 'cta.js'];
require_once __DIR__ . '/../../views/layout/importJs.php';
?>