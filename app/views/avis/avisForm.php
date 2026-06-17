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
    <p class="error-message mt-1 text-center"></p><br>
    <div  class="d-flex justify-content-center">
        <div class="d-flex flex-column justify-content-center form-contact">
            <h3 class="text-center ">Noter votre commande</h3>
            <form action="/avis/noter-commande/<?= $commande['commande_id'] ?>" method="POST" class="text-center ">
                <?= Auth::csrfField() ?>
                <label class="form-label"  for="note">Note :</label><br>
                <input type="hidden" name="note" id="note" value="">
                <div class="d-flex justify-content-center">
                    <div id="etoilesContainer">
                        <i class="fa-regular fa-star etoiles"></i><i class="fa-regular fa-star etoiles"></i><i class="fa-regular fa-star etoiles"></i><i class="fa-regular fa-star etoiles"></i><i class="fa-regular fa-star etoiles"></i>
                    </div>
                    <div id="noteContainer"></div>
                </div>
                <label class="form-label" class="mt-5"  for="description">Donnez votre avis :</label><br>
                <textarea  name="description" id="description" rows="5" cols="33"></textarea><br>
                <a class="annuler" href="/profile">Annuler</a><br>
                <button class="mt-5 mb-5 btn-form"  type="submit">Valider</button>
            </form>
        </div>
    </div>
    
</main>
<script src="/assets/js/etoiles.js"></script>
<?php
$loadScriptJs = 'form.js';
require_once __DIR__ . '/../../views/layout/importJs.php';
require_once __DIR__ . '/../../views/layout/footer.php';
?>