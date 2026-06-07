<?php
$pageSpecificCss = ['style.css' , 'formulaire.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main class="d-flex justify-content-around">
    <div class="d-flex flex-column  form-contact">
        <form action="/avis/noter-commande/<?= $commande['commande_id'] ?>" method="POST" class="text-center">
            <?= Auth::csrfField() ?>
            <h3 class="text-center mt-5">Noter votre commande</h3>
            <?php if ($_GET['error'] ?? null): ?>
                <p class="error-message mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
            <?php endif ?>
            <?php if ($_GET['success'] ?? null): ?>
                <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
            <?php endif ?>

            <label class="mt-5"  for="note">Note :</label><br>
            <input type="hidden" name="note" id="note" value="">
            <div class="d-flex justify-content-center">
                <div id="etoilesContainer">
                    <i class="fa-regular fa-star etoiles"></i><i class="fa-regular fa-star etoiles"></i><i class="fa-regular fa-star etoiles"></i><i class="fa-regular fa-star etoiles"></i><i class="fa-regular fa-star etoiles"></i>
                </div>
                <div id="noteContainer"></div>
            </div>
            <label class="mt-5"  for="description">Donnez votre avis :</label><br>
            <textarea name="description" id="description" rows="5" cols="33"></textarea><br>

            <button class="mt-5 mb-5"  type="submit">Valider</button>
        </form>
    </div>
    
</main>
<script src="/assets/js/etoiles.js"></script>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>