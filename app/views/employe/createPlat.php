<?php
$pageSpecificCss = ['style.css' , 'formulaire.css' , 'layout.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>


<main>
    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message-php text-center mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message-php text-center mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
    <?php if ($_SESSION['role_id'] === 2) :  ?>
        <div class="d-none d-md-flex justify-content-around">
            <a href="/employe/dashboard" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Dashoard</a><br>
            <a href="/commandes-client" class="text-centerfw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Commandes</a><br>
            <a href="/avis-valider" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Avis</a><br>
            <a href="/menus" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Menus</a><br>
            <a href="/plats" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Plats</a><br>
            <a href="/changer-horaire" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Horaires</a><br>
        </div>
    <?php elseif ($_SESSION['role_id'] === 3) :  ?>
        <div class="d-none d-md-flex justify-content-around">
            <a href="/admin/dashboard" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Dashoard</a><br>
            <a href="/commandes-client" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Commandes</a><br>
            <a href="/avis-valider" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Avis</a><br>
            <a href="/menus" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Menus</a><br>
            <a href="/plats" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Plats</a><br>
            <a href="/changer-horaire" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Horaires</a><br>
        </div>
    <?php endif ?>
    <hr>
    <div class="d-flex justify-content-center">
        <div class="d-flex flex-column text-center form-contact">
            <h2 class="text-center  mb-2">Créer un plat</h2>
            <form action="/plats/create" method="POST" enctype="multipart/form-data" class="text-center validate-form">
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
                <a class="annuler" href="/plats">Annuler</a><br>
                <button class="mt-3 mb-3 btn-form" type="submit">Céer plat</button>
            </form>
        </div>
    </div>
    
</main>


<?php
$loadScriptJs = 'form.js';
require_once __DIR__ . '/../../views/layout/importJs.php';
require_once __DIR__ . '/../../views/layout/footer.php';
?>