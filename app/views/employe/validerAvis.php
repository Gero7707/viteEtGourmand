<?php
$pageSpecificCss = ['style.css' , 'formulaire.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <p class="error-message mt-1 text-center"></p><br>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
    <div class="container-avis text-center mt-3">
        <?php foreach($avis as $carteAvis) : ?>
            <div class="avis-carte mt-3">
                <p><?= htmlspecialchars($carteAvis['nom_complet']) ?></p>
                <?php for($i = 1 ; $i <= 5 ; $i ++ ) :
                    if($i <= $carteAvis['note']):?>
                        <i class="fa-solid fa-star etoiles"></i>
                    <?php else : ?>
                        <i class="fa-regular fa-star etoiles"></i>
                    <?php endif ?>
                <?php endfor ?>
                <p><?= htmlspecialchars($carteAvis['note']) ?>/5</p>
                <p><?= htmlspecialchars($carteAvis['description']) ?></p>
                <p><?= htmlspecialchars(str_replace(':00', 'h',date('d-m-Y  à  H:i', strtotime($carteAvis['date_avis'])))) ?></p>
                
                <form action="/avis-valider/<?= $carteAvis['avis_id'] ?>" method="POST">
                    <?= Auth::csrfField() ?>
                    <button type="submit" name="statut" value="valide">Valider</button>
                    <button type="submit" name="statut" value="refuse">Refuser</button>
                </form>
                <hr>
            </div>
        <?php endforeach ?>
    </div>
</main>
<?php
$loadScriptJs = 'form.js';
require_once __DIR__ . '/../../views/layout/footer.php';
?>