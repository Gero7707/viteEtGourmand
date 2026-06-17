<?php
$pageSpecificCss = ['style.css' , 'layout.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    

    <section class="section-avis bg-primary m-auto mt-5 pt-5 pb-4">
        <h3 class="text-secondary text-center mb-5">Avis clients</h3>
                
            <div class="row-avis row">
                <?php foreach($avis as $carteAvis) : ?>
                    <div class="col-1"></div>
                    <div class="carte-avis mb-5 col-4">
                        <p class="titre-avis"><?= htmlspecialchars($carteAvis['nom_complet']) ?><span class="note-avis"> - <?= htmlspecialchars($carteAvis['note']) ?>/5</span></p>
                        <?php for($i = 0; $i < $carteAvis['note']; $i++): ?>
                            <i class="fa-solid fa-star"></i>
                        <?php endfor ?>
                        <?php for($i = 0; $i < 5 - $carteAvis['note']; $i++): ?>
                            <i class="fa-regular fa-star"></i>
                        <?php endfor ?>
                        <p class="description-avis"><?= htmlspecialchars($carteAvis['description']) ?></p>
                        <p class="date-avis"><?= htmlspecialchars(str_replace(':00', 'h',date('d-m-Y  à  H:i', strtotime($carteAvis['date_avis'])))) ?></p>
                    </div>
                    <div class="col-1"></div>
                <?php endforeach ?>
            </div>
        
    </section>
</main>


<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>