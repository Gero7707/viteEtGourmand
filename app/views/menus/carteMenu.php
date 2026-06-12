<?php
$pageSpecificCss = ['style.css' , 'formulaire.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>
<main>

    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>

    <p class="arborescence"><a href="/">Accueil</a>><a href="/menus">Menus</a>><?= htmlspecialchars($menus['titre']) ?></p>
    <section class="section-detail d-flex justify-content-around mb-5">
        <div class="img-estimateur mt-4">
            <div class="img-menu-detail">

            </div>
            <div>
                <form action="">
                    <label for="prix_estime">Estimateur de prix :Entrer un nombre de personnes . Minimum <?= htmlspecialchars($menus['nombre_personne_minimum']) ?></label>
                    <input type="number" name="prix_estime" id="prix_estime">
                    <button type="submit">Estimer le prix total</button>
                </form>
            </div>
            <div>
                <a href="/commandes/create/<?=  htmlspecialchars($menus['menu_id']); ?>">Commander</a>
            </div>
        </div>


        <article class="infos-completes mt-4 ">
            <div class="d-flex justify-content-around entete-menu-detail">
                <div class="titre-menu d-flex flex-column">
                    <h3><?= htmlspecialchars($menus['titre']) ?></h3><br>
                    <p class="theme-carte" ><?php if($menus['regime'] === 'Classique') : ?>
                                                                    <i class="fa-solid fa-square"></i>   
                                                                <?php elseif($menus['regime'] === 'Vegan') : ?>
                                                                    <i class="fa-solid fa-circle"></i>
                                                                <?php elseif($menus['regime'] === 'Végétarien') : ?>
                                                                    <i class="fa-solid fa-diamond"></i>
                                                                <?php endif ?>     &nbsp;<?= htmlspecialchars($menus['regime']) ?></p>
                </div>
                
                <div class="prix-nb-quantite d-flex flex-column">
                    <p>Prix pour <?= htmlspecialchars($menus['nombre_personne_minimum']) ?> personnes :</p>
                    <p>Prix : <?= htmlspecialchars($menus['prix_par_personne']) ?> €/pers</p>
                    <p>Qté restante : <?= htmlspecialchars($menus['quantite_restante']) ?></p>
                    <p>Hors frais de livraison</p>
                </div>
            </div>
            
            <p class="mt-5 description"><?= htmlspecialchars($menus['description']) ?></p><br>
            <div class="composition-menu">
                <?php foreach($plat as $p) : ?>
                    <h5><?= htmlspecialchars(ucfirst($p['type_plat'])) ?> :</h5>
                    <p><?= htmlspecialchars($p['titre_plat']) ?></p>
                    <p><i class="fa-solid fa-arrow-turn-up"></i>Allergènes : <?php foreach($p['allergenes'] as $allergene) : ?>
                                        <?= htmlspecialchars($allergene['libelle']) ?> , 
                                    <?php endforeach ?></p>
                    

                    <!-- Entreprise -->
                    <?php if(isset($_SESSION['role_id'] ) && ($_SESSION['role_id'] === 2 || $_SESSION['role_id'] === 3)) : ?>
                        <form action="/plats/dissocier/<?= htmlspecialchars($p['plat_id']) ?>" method="POST">
                            <input type="hidden" name="menu_id" value="<?= htmlspecialchars($menus['menu_id']) ?>">
                            <?= Auth::csrfField() ?>
                            <button type="submit">Dissocier plat</button>
                        </form>
                    <?php endif ?>

                <?php endforeach ?>
            </div>
            <div class="conditions-menus mt-4 mb-5">
                <h6>Delai :</h6>
                <p><?= htmlspecialchars($menus['conditions_delai']) ?></p>
                <h6>Stockage :</h6>
                <p><?= htmlspecialchars($menus['conditions_stockage']) ?></p>
                <h6>Informations importantes :</h6>
                <p><?= htmlspecialchars($menus['conditions_infos']) ?></p>
            </div>

        </article>
        
    </section>

</main>

                    <!-- <img src="/<?= htmlspecialchars($p['chemin_photo']) ?>" alt="" width="50" height="50"> -->



<?php
// $loadScriptJs = '';
require_once __DIR__ . '/../../views/layout/importJs.php';
?>