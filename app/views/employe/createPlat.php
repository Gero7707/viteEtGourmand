<?php
$pageSpecificCss = ['style.css' , 'formulaire.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>


<main>
    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
    <div class="d-flex justify-content-center">
        <div class="d-flex flex-column text-center form-contact">
            <h3 class="text-center  mb-2">Créer un plat</h3>
            <form action="/plats/create" method="POST" enctype="multipart/form-data" class="text-center">
                <?= Auth::csrfField() ?>

                <label class="form-label" for="titre_plat">Titre du plat :</label><br>
                <input  class="form-control" type="text" name="titre_plat" id="titre_plat" required><br>

                <div class="cadre-input">
                    <label class="form-label"  for="type_plat">Type :</label><br>
                    <select name="type_plat" id="type_plat" required>
                        <option value=""></option>
                        <option value="entree">Entrée</option>
                        <option value="plat">Plat</option>
                        <option value="dessert">Dessert</option>
                    </select><br>
                </div>
                <hr>
                <div class="cadre-input">
                    <label class="form-label" for="allergene">Allergenes :</label><br>
                    <div class="check-allergene m-auto">
                        <?php foreach($allergenes as $allergene) : ?>
                            <div class="d-flex flex-start">
                                <input type="checkbox" name="allergenes[]" id="allergene_<?= $allergene['allergene_id'] ?>" value="<?= $allergene['allergene_id'] ?>">
                                <label class="form-label" for="allergene_<?= $allergene['allergene_id'] ?>"><?= $allergene['libelle'] ?></label><br>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
                <hr>
                <div class="cadre-input">
                    <label class="form-label"   for="chemin_photo">Image</label><br>
                    <input class="form-control input-img" type="file" name="chemin_photo" id="chemin_photo" required><br>
                </div>
                
                <p class="error-message mt-1 text-center"></p><br>
                <button class="mt-3 mb-3 btn-form" type="submit">Céer plat</button>
            </form>
        </div>
    </div>
    
</main>


<?php
$loadScriptJs = 'form.js';
require_once __DIR__ . '/../../views/layout/importJs.php';
?>