<?php
$pageSpecificCss = ['style.css' , 'formulaire.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <p class="error-message mt-1 text-center"></p><br>
    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message-php text-center mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message-php text-center mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
    <div class="d-flex justify-content-center">
        <div class="d-flex flex-column text-center form-contact">
            <h3 class="texte-center  mb-5">Annuler la commande</h3>
            <form action="/commandes/annuler-commande/<?= $commandes['commande_id'] ?>" method="POST">
                <?= Auth::csrfField() ?>
                
                <label class="form-label" for="commentaires">Motif et mode de contact :</label><br>
                <textarea class="texte-annule" name="commentaires" id="commentaires"></textarea><br>
                <p class="error-message mt-1 text-center"></p><br>
                <a class="annuler" href="/commandes-client">Annuler</a><br>
                <button class="btn-form mb-5 " type="submit">Annuler Commande</button>
            </form>
        </div>
    </div>
</main>
<?php
$loadScriptJs = 'form.js';
require_once __DIR__ . '/../../views/layout/importJs.php';
?>