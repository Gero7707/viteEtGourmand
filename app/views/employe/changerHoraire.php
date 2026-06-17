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
    
    <div class="d-flex justify-content-around" >

        <div class=" flex-column justify-content-center form-horaire">
            <h3 class="text-center mt-3 mb-3">Changer les horiares</h3>
            <form action="/changer-horaire" method="POST" class="text-center">
                <?= Auth::csrfField() ?>
                <?php foreach($horaires as $horaire) : ?>

                    <input type="hidden" name="horaire_id[]" value="<?= $horaire['horaire_id'] ?>">
                    <p><?= htmlspecialchars($horaire['jour']) ?></p>

                    <label class="form-label" for="heure_ouverture[<?= $horaire['horaire_id'] ?>]">Ouverture</label>
                    <input class="form-control" type="time" name="heure_ouverture[<?= $horaire['horaire_id'] ?>]" value="<?= htmlspecialchars($horaire['heure_ouverture']) ?>">
                    
                    <label class="form-label" for="heure_fermeture[<?= $horaire['horaire_id'] ?>]">Fermeture</label>
                    <input class="form-control" type="time" name="heure_fermeture[<?= $horaire['horaire_id'] ?>]" value="<?= htmlspecialchars($horaire['heure_fermeture']) ?>"><br>
                <?php endforeach ?>
                <?php if ($_SESSION['role_id'] === 2) :  ?>
                    <a class="annuler" href="/employe/dashboard">Annuler</a><br>
                <?php elseif ($_SESSION['role_id'] === 3) :  ?>
                    <a class="annuler" href="/admin/dashboard">Annuler</a><br>
                <?php endif ?>
                
                <button class="mt-3 mb-3" type="submit">Changer Horaire</button>
            </form>
        </div>

        <div class=" text-center form-horaire">
            <h4 class="mt-3 mb-3">Ajouter un jour de travail</h4>
            <form action="/ajout-jour" method="POST">
                <?= Auth::csrfField() ?>
                <?php foreach($jourManquants  as $jourManquant) : ?>
                    <input type="hidden" name="jour[]" id="jour" value="<?= htmlspecialchars($jourManquant) ?>">
                    <p><?= htmlspecialchars($jourManquant) ?></p><br>
                    <p class="error-message mt-1 text-center"></p><br>
                    <label class="form-label" for="heure_ouverture[<?= $jourManquant ?>]">Ouverture :</label>
                    <input class="form-control" type="time" name="heure_ouverture[<?= $jourManquant ?>]">

                    <label class="form-label" for="heure_fermeture[<?= $jourManquant ?>]">Fermeture :</label>
                    <input class="form-control" type="time" name="heure_fermeture[<?= $jourManquant ?>]"><br>
                <?php endforeach ?>
                <button class="mt-3 btn-form" type="submit">Ajouter un jour</button>
            </form>
        
            <div class="d-flex flex-column align-items-center">
                <h4 class="mt-3 mb-3">Supprimer un jour</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Jour</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($horaires as $horaire) : ?>
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
            </div>
        </div>
    </div>
</main>

<?php
$loadScriptJs  = 'form.js';
require_once __DIR__ . '/../../views/layout/importJs.php';
?>