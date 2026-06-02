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
    <h4>Changer les horiares</h4>
    <form action="/changer-horaire" method="POST">
        <?= Auth::csrfField() ?>
        <?php foreach($horaires as $horaire) : ?>
            <input type="hidden" name="horaire_id[]" value="<?= $horaire['horaire_id'] ?>">
            <p><?= htmlspecialchars($horaire['jour']) ?></p><br>
            <label for="heure_ouverture[<?= $horaire['horaire_id'] ?>]">Ouverture</label><br>
            <input type="time" name="heure_ouverture[<?= $horaire['horaire_id'] ?>]" value="<?= htmlspecialchars($horaire['heure_ouverture']) ?>"><br>
            <label for="heure_fermeture[<?= $horaire['horaire_id'] ?>]">Fermeture</label><br>
            <input type="time" name="heure_fermeture[<?= $horaire['horaire_id'] ?>]" value="<?= htmlspecialchars($horaire['heure_fermeture']) ?>"><br>
        <?php endforeach ?>
        <button type="submit">Changer Horaire</button>
    </form>
    <hr>
    <h4>Ajouter un jour de travail</h4>
    <form action="/ajout-jour" method="POST">
        <?= Auth::csrfField() ?>
        <?php foreach($jourManquants  as $jourManquant) : ?>
            <input type="hidden" name="jour[]" id="jour" value="<?= htmlspecialchars($jourManquant) ?>">
            <p><?= htmlspecialchars($jourManquant) ?></p><br>
            <label for="heure_ouverture[<?= $jourManquant ?>]">Ouverture</label><br>
            <input type="time" name="heure_ouverture[<?= $jourManquant ?>]"><br>
            <label for="heure_fermeture[<?= $jourManquant ?>]">Fermeture</label><br>
            <input type="time" name="heure_fermeture[<?= $jourManquant ?>]"><br>
        <?php endforeach ?>
        <button type="submit">Ajouter un jour</button>
    </form>
    <hr>
    <h4>Supprimer un jour</h4>
    <table>
        <thead>
            <tr>
                <th>Jour</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <? foreach($horaires as $horaire) : ?>
                <tr>
                    <td><?= htmlspecialchars($horaire['jour']) ?></td>
                    <td>
                        <form action="/supp-jour/<?= $horaire['horaire_id']  ?>" method="POST">
                            <?= Auth::csrfField() ?>
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
                
            <?php endforeach ?>
        </tbody>
    </table>
</main>

