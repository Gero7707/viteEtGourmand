<?php
$pageSpecificCss = ['style.css' , 'formulaire.css'];
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
    <div  class="d-flex justify-content-center ">
        <div class="d-flex flex-column justify-content-center form-contact mt-5">
            <h3 class="text-center">Modifier votre avis</h3>
            <form action="/avis/edit/<?= $avis['avis_id'] ?>" method="POST" class="text-center">
                <?= Auth::csrfField() ?>
                
                <label class="form-label" for="note">Note</label><br>
                <p>Vous avez donné la note : <?= htmlspecialchars($avis['note']) ?>/5</p>
                
                <input type="hidden" name="note" id="note" value="">
                <div class="d-flex justify-content-center div-etoiles">
                    <div id="etoilesContainer">
                        <i class="fa-regular fa-star etoiles"></i><i class="fa-regular fa-star etoiles"></i><i class="fa-regular fa-star etoiles"></i><i class="fa-regular fa-star etoiles"></i><i class="fa-regular fa-star etoiles"></i>
                    </div>
                    <div id="noteContainer"></div>
                </div>

                <label class="form-label" for="description">Donnez votre avis :</label><br>
                <textarea name="description" id="description" rows="5" cols="33"><?= htmlspecialchars($avis['description']) ?></textarea><br>
                <a class="annuler" href="/profile">Annuler</a><br>
                <button class="btn-form mb-5" type="submit">Valider</button>
            </form>
        </div>
    </div>
</main>
<script src="/assets/js/form.js"></script>
<?php
$loadScriptJs = ['form.js' , 'etoiles.js' ];
require_once __DIR__ . '/../../views/layout/footer.php';
?>