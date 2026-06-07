<?php
$pageSpecificCss = 'style.css';
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <a href="/">Voir accueil</a><br>
    <a href="/commandes-client">Retour</a><br>
    <hr>

    <form action="/commandes/annuler-commande/<?= $commandes['commande_id'] ?>" method="POST">
        <?= Auth::csrfField() ?>

        <?php if ($_GET['error'] ?? null): ?>
            <p class="error-message mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
        <?php endif ?>
        <?php if ($_GET['success'] ?? null): ?>
            <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
        <?php endif ?>
        
        <label for="commentaires">Motif et mode de contact :</label><br>
        <textarea name="commentaires" id="commentaires" rows="5" cols="33"></textarea>
        <button type="submit">Annuler Commande</button>
    </form>
</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>