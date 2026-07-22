<?php
$pageDescription = "Découvrez le " .  $menus['titre']  . " de Vite & Gourmand.";
$pageMenu = true;
$pageTitle = $menus['titre'] . ' — Vite & Gourmand';
$pageSpecificCss = ['style.css' , 'formulaire.css' , 'carousel.css' , 'layout.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>
<main>

    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message-php text-center mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message-php text-center mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>

    <p class="arborescence"><a href="/">Accueil</a>><a href="/menus">Menus</a>><?= htmlspecialchars($menus['titre']) ?></p>
    <section class="section-detail d-flex justify-content-around mb-5">
        <div class="img-estimateur ">
            <div class="img-menu-detail">
                <div class="swiper swiper-menu-detail">
                    <div class="swiper-button-prev"></div>
                    <!-- Additional required wrapper -->
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        <?php foreach($plat as $p) : ?>
                        <div class="swiper-slide"> 
                            <div class="img-wrapper position-img">
                                <img src="/<?= htmlspecialchars($p['chemin_photo']) ?>" alt="<?= htmlspecialchars($p['titre_plat']) ?>" data-swiper-parallax-x="30%" loading="lazy">
                            </div>
                            <h2><?= htmlspecialchars($p['titre_plat']) ?></h2>
                        </div>
                        <?php endforeach ?>
                    </div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
            
            <div class="commander">
                <a class=" fw-mediumbold bg-secondary text-primary" href="/commandes/create/<?=  htmlspecialchars($menus['menu_id']); ?>">Commander</a>
                <p>Vous pouvez faire une estimation du prix total à la page commander .</p>
            </div>
            <div class="citation mt-5">
                <p>"La cuisine est un voyage à travers le monde des saveurs."</p>
                <p>Anne-Sophie Pic</p>
            </div>
        </div>


        <article class="infos-completes  ">
            <div class="d-flex justify-content-around entete-menu-detail">
                <div class="titre-menu d-flex flex-column">
                    <h2><?= htmlspecialchars($menus['titre']) ?></h2><br>
                    <p>Thème :</p>
                    <p class="theme-carte mt-2" ><?= htmlspecialchars($menus['theme']) ?></p>
                    <p>Régime :</p>
                    <p class="regime-carte mt-2"><?= htmlspecialchars($menus['regime']) ?></p>
                </div>
                
                
                <div class="prix-nb-quantite d-flex flex-column">
                    <h3>Prix pour <?= htmlspecialchars($menus['nombre_personne_minimum']) ?> personnes :</h3>
                    <h3>Prix : <?= htmlspecialchars($menus['prix_par_personne']) ?> €/pers</h3>
                    <h3>Qté restante : <?= htmlspecialchars($menus['quantite_restante']) ?></h3>
                    <h3>Hors frais de livraison</h3>
                </div>
            </div>
            
            <p class="mt-5 description"><?= htmlspecialchars($menus['description']) ?></p><br>
            <div class="composition-menu">
                <?php foreach($plat as $p) : ?>
                    <h3><?= htmlspecialchars(ucfirst($p['type_plat'])) ?> :</h3>
                    <h4><?= htmlspecialchars($p['titre_plat']) ?></h4>
                    <p><i class="fa-solid fa-arrow-turn-up"></i>Allergènes : <?php foreach($p['allergenes'] as $allergene) : ?>
                                        <?= implode(', ', array_column($p['allergenes'], 'libelle')) ?>
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
            <div class="conditions-menus mt-4 ">
                <h4>Delai :</h4>
                <p><?= htmlspecialchars($menus['conditions_delai']) ?></p>
                <h4>Stockage :</h4>
                <p><?= htmlspecialchars($menus['conditions_stockage']) ?></p>
                <h4>Informations importantes :</h4>
                <p><?= htmlspecialchars($menus['conditions_infos']) ?></p>
            </div>

        </article>

        <div class="commander-small" aria-hidden="true">
            <a class=" fw-mediumbold bg-secondary text-primary" aria-hidden="true" href="/commandes/create/<?=  htmlspecialchars($menus['menu_id']); ?>">Commander</a>
            <p>Vous pouvez faire une estimation du prix total à la page commander .</p>
        </div>

    </section>

</main>

                    


<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
<?php
$loadScriptJs = 'Swiper.js';
require_once __DIR__ . '/../../views/layout/importJs.php';
require_once __DIR__ . '/../../views/layout/footer.php';
?>