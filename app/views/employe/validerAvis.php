<?php
$pageSpecificCss = 'style.css';
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <a href="/">Accueil</a><br>

    <?php if ($_GET['error'] ?? null): ?>
        <p><?= htmlspecialchars($_GET['error']) ?></p><br>
    <?php elseif($_GET['success'] ?? null) :?>
        <p><?= htmlspecialchars($_GET['success']) ?></p><br>
    <?php endif ?>

    <?php foreach($avis as $carteAvis) : ?>
        <p><?= htmlspecialchars($carteAvis['nom_complet']) ?></p>
        <p><?= htmlspecialchars($carteAvis['note']) ?></p>
        <p><?= htmlspecialchars($carteAvis['description']) ?></p>
        <p><?= htmlspecialchars(str_replace(':00', 'h',date('d-m-Y  à  H:i', strtotime($carteAvis['date_avis'])))) ?></p>
        <hr>
        <form action="/avis-valider/<?= $carteAvis['avis_id'] ?>" method="POST">
            <?= Auth::csrfField() ?>

            <?php if ($_GET['error'] ?? null): ?>
                <p class="error-message mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
            <?php endif ?>
            <?php if ($_GET['success'] ?? null): ?>
                <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
            <?php endif ?>
            <button type="submit" name="statut" value="valide">Valider</button>
            <button type="submit" name="statut" value="refuse">Refuser</button>
        </form>
    <?php endforeach ?>
</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>