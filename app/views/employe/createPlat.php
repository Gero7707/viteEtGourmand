<?php
$pageSpecificCss = ['style.css' , 'formulaire.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>


<main>
    <?php if($_GET['success'] ?? null) :?>
        <p class="success-message mt-1 text-center"><?= htmlspecialchars($_GET['success']) ?></p><br>
    <?php endif ?>
    <div class="d-flex justify-content-center">
        <div class="d-flex flex-column text-center form-contact">
            <h3 class="text-center  mb-2">Créer un plat</h3>
            <form action="/plats/create" method="POST" enctype="multipart/form-data" class="text-center">
                <?= Auth::csrfField() ?>

                <label class="mt-2" for="titre_plat">Titre du plat :</label><br>
                <input  class="mb-1" type="text" name="titre_plat" id="titre_plat" required><br>
                <hr>
                <div class="cadre-input">
                    <label  for="type_plat">Type :</label><br>
                    <select name="type_plat" id="type_plat" required>
                        <option value=""></option>
                        <option value="entree">Entrée</option>
                        <option value="plat">Plat</option>
                        <option value="dessert">Dessert</option>
                    </select><br>
                </div>
                <hr>
                <div class="cadre-input">
                    <label class=" mb-1" for="allergene">Allergenes :</label><br>
                    <div class="check-allergene m-auto">
                        <?php foreach($allergenes as $allergene) : ?>
                            <div class="d-flex flex-start">
                                <input type="checkbox" name="allergenes[]" id="allergene_<?= $allergene['allergene_id'] ?>" value="<?= $allergene['allergene_id'] ?>">
                                <label for="allergene_<?= $allergene['allergene_id'] ?>"><?= $allergene['libelle'] ?></label><br>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
                <hr>
                <div class="cadre-input">
                    <label   for="chemin_photo">Image</label><br>
                    <input type="file" name="chemin_photo" id="chemin_photo" required><br>
                </div>
                

                <button class="mt-3 mb-3 btn-form" type="submit">Céer plat</button>
            </form>
        </div>
    </div>
    <p class="error-message mt-1 text-center"></p><br>
</main>


<?php
$loadScriptJs = 'form.js';
require_once __DIR__ . '/../../views/layout/footer.php';
?>