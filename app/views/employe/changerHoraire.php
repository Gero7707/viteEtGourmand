<?php
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <?php if($_SESSION['role_id'] === 2) : ?>
        <a href="/employe/dashboard">Dashboard</a><br>
    <?php elseif($_SESSION['role_id'] === 3) : ?>
        <a href="/admin/dashboard">Dashboard</a><br>
    <?php endif ?>
    <hr>
    <?php if ($_GET['error'] ?? null): ?>
        <p><?= htmlspecialchars($_GET['error']) ?></p><br>
    <?php elseif($_GET['success'] ?? null) :?>
        <p><?= htmlspecialchars($_GET['success']) ?></p><br>
    <?php endif ?>

    <form action="/changer-horaire" method="POST">
        <?= Auth::csrfField() ?>
        <?php foreach($horaires as $horaire) : ?>
            <input type="hidden" name="horaire_id[]" value="<?= $horaire['horaire_id'] ?>">
            <p><?= htmlspecialchars($horaire['jour']) ?></p><br>
            <input type="time" name="heure_ouverture[<?= $horaire['horaire_id'] ?>]" value="<?= htmlspecialchars($horaire['heure_ouverture']) ?>">
            <input type="time" name="heure_fermeture[<?= $horaire['horaire_id'] ?>]" value="<?= htmlspecialchars($horaire['heure_fermeture']) ?>">
        <?php endforeach ?>
        <button type="submit">Changer Horaire</button>
    </form>
</main>

