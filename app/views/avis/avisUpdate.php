<?php
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <a href="/">Accueil</a><br>
    <a href="/avis">Retour aux avis</a><br>
    <form action="/avis/edit/<?= $avis['avis_id'] ?>" method="POST">
        <?= Auth::csrfField() ?>
        <label for="note">Note</label><br>
        <input type="number" name="note" id="note" min="1" max="5" value="<?= htmlspecialchars($avis['note']) ?>" required><br>
        <label for="description">Donnez votre avis :</label><br>
        <textarea name="description" id="description" rows="5" cols="33"><?= htmlspecialchars($avis['description']) ?></textarea>
        <button type="submit">Valider</button>
    </form>
</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>