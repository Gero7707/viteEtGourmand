<?php
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <a href="/">Accueil</a><br>

    <form action=""></form>

    <?php foreach($avis as $carteAvis) : ?>
        <p><?= htmlspecialchars($carteAvis['nom_complet']) ?></p>
        <p><?= htmlspecialchars($carteAvis['note']) ?></p>
        <p><?= htmlspecialchars($carteAvis['description']) ?></p>
        <p><?= htmlspecialchars(str_replace(':00', 'h',date('d-m-Y  à  H:i', strtotime($carteAvis['date_avis'])))) ?></p>
        <hr>
    <?php endforeach ?>
</main>


<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>