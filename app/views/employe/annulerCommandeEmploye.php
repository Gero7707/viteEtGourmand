<?php
$pageSpecificCss = ['style.css' , 'formulaire.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
    <div class="d-flex justify-content-center">
        <div class="d-flex flex-column text-center form-contact">
            <h4 class="texte-center mt-3 mb-5">Annuler la commande</h4>
            <form action="/commandes/annuler-commande/<?= $commandes['commande_id'] ?>" method="POST">
                <?= Auth::csrfField() ?>
                
                <label class="mb-5 mt-5" for="commentaires">Motif et mode de contact :</label><br>
                <textarea class="mb-5 texte-annule" name="commentaires" id="commentaires"></textarea><br>
                <p class="error-message mt-1 text-center"></p><br>
                <button class="btn-form mb-5 mt-5" type="submit">Annuler Commande</button>
            </form>
        </div>
    </div>
</main>
<?php
$loadScriptJs = 'form.js';
require_once __DIR__ . '/../../views/layout/footer.php';
?>