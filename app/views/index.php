<?php
require_once __DIR__ . '/../views/layout/header.php';
?>

<main>
    <?php if(!isset($_SESSION['utilisateur_id'])): ?>
        
        <div class="d-flex mt-2 intro justify-content-around">
            <div>
                <p class="fw-mediumbold text-center">L'art de la réception, depuis 1999 </p>
                <p class="fw-mediumbold text-center mb-2">Vite & Gourmand, traiteur événementiel à Bordeaux. Des menus raffinés, livrés chez vous,pour tous vos événements.</p>
            </div>
            <div class="text-center">
                <a href="/menus" class="fw-mediumbold bg-secondary text-primary lien-intro ">Découvrir nos menus</a>
            </div>
        </div>
    <?php elseif(isset($_SESSION['utilisateur_id'])): ?>

        <?php if($_SESSION['role_id'] === 1) : ?>
            <div class="d-flex mt-2 intro justify-content-around">
                <div>
                    <p class="fw-mediumbold text-center">Bonjour  <?= $_SESSION['prenom'] ?>  !</p><br>
                    <p class="fw-mediumbold text-center">L'art de la réception, depuis 1999 </p>
                    <p class="fw-mediumbold text-center mb-2">Vite & Gourmand, traiteur événementiel à Bordeaux. Des menus raffinés, livrés chez vous,pour tous vos événements.</p>
                </div>
                <div class="text-center">
                    <a href="/menus" class="fw-mediumbold bg-secondary text-primary lien-intro ">Découvrir nos menus</a>
                </div>
            </div>
        <?php elseif ($_SESSION['role_id'] === 2) :  ?>
        <a href="/commandes-client">Commandes</a><br>
        <a href="/avis-valider">Avis</a><br>
        <a href="/menus">Menus</a><br>
        <a href="/create-menu">Créer un menu</a><br>
        <a href="/plats">Plats</a><br>
        <a href="/plats/create">Créer un plat</a><br>
        <a href="/changer-horaire">Changer horaire</a><br>
        <a href="/employe/dashboard">Dashoard</a><br>
        <?php elseif ($_SESSION['role_id'] === 3) :  ?>
        <a href="/commandes-client">Commandes</a><br>
        <a href="/avis-valider">Avis</a><br>
        <a href="/menus">Menus</a><br>
        <a href="/create-menu">Créer un menu</a><br>
        <a href="/plats">Plats</a><br>
        <a href="/plats/create">Créer un plat</a><br>
        <a href="/changer-horaire">Changer horaire</a><br>
        <a href="/admin/dashboard">Dashoard</a><br>
        <?php endif ?>

    <?php endif ?>

    <?php if ($_GET['error'] ?? null): ?>
        <p><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
        <section class="section-carousel">
            <!-- Slider main container -->
            <div class="swiper">
                <div class="swiper-button-prev"></div>
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide"> 
                        <div class="img-wrapper">
                            <img src="/assets/img/menus/banquet.jpg" alt="" data-swiper-parallax-x="30%" loading="lazy">
                        </div>
                    </div>
                    <div class="swiper-slide"> 
                        <div class="img-wrapper">
                            <img src="/assets/img/menus/brunch-paques.jpg" alt="" data-swiper-parallax-x="30%" loading="lazy">
                        </div>
                    </div>
                    <div class="swiper-slide"> 
                        <div class="img-wrapper">
                            <img src="/assets/img/menus/jardin-ete.jpg" alt="" data-swiper-parallax-x="30%" loading="lazy">
                        </div>
                    </div>
                    <div class="swiper-slide"> 
                        <div class="img-wrapper">
                            <img src="/assets/img/menus/menu-estival.jpg" alt="" data-swiper-parallax-x="30%" loading="lazy">
                        </div>
                    </div>
                    <div class="swiper-slide"> 
                        <div class="img-wrapper">
                            <img src="/assets/img/menus/fete.jpg" alt="" data-swiper-parallax-x="30%" loading="lazy">
                        </div>
                    </div>
                </div>
                <div class="swiper-button-next"></div>
            </div>
        </section>
    
    <section class="section-savoir-faire">
        <h3 class="text-center mb-5 mt-5">Notre savoir faire</h3>
        <div class="d-flex carte-savoir-faire mb-4 mt-5">
            <img src="/assets/img/menus/banquet.jpg" alt="baquet" class="img-carte1 observer">
            <div class="p-5 texte text-center texte-carte1 observer">
                <p class="mb-5 mt-5">Depuis 1999, Vite & Gourmand met son expertise au service de vos réceptions. </p>
                <p class="mb-5">Chaque menu est élaboré avec des produits frais et de saison, <br> sélectionnés auprès de producteurs locaux bordelais.</p>
                <p >De l'entrée au dessert, nos plats allient saveurs authentiques et <br> présentation soignée pour faire de chaque repas un moment inoubliable.</p>
            </div>
        </div>

        <div class="d-flex carte-savoir-faire mb-4 mt-5">
            <div class="p-5 texte text-center texte-carte2 observer ">
                <p class="mb-5">Notre équipe accompagne vos événements de A à Z :conception de menus personnalisés, préparation dans nos cuisines, livraison et mise en place chez vous.</p>
                <p class="mb-5">Mariages, repas d'entreprise, fêtes de famille ou galas, nous nous adaptons à chaque occasion avec le même souci du détail et de l'excellence. </p>
                <p >Plus de 2 000 événements réussis à Bordeaux et dans toute la Gironde.</p>
            </div>
            <img src="/assets/img/menus/menu-estival.jpg" alt="menu-estival" class="img-carte2 observer">
            
        </div>
    </section>
    
    <section class="section-avis bg-primary m-auto mt-5 pt-5 pb-4">
        <h3 class="text-secondary text-center mb-5">Avis clients</h3>
                
            <div class="row">
                <?php foreach($avis as $carteAvis) : ?>
                    <div class="col-lg-1 col-sm-2"></div>
                    <div class="carte-avis mb-5 col-lg-4 col-sm-8">
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
                    <div class="col-lg-1 col-sm-2"></div>
                <?php endforeach ?>
            </div>
        <div class="text-center mb-5">
            <a href="/avis" class="avis bg-secondary">Voir tous les avis</a>
        </div>
    </section>
    
</main>
<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
<script src="/assets/js/intersectionObserver.js"></script>
<script src="/assets/js/Swiper.js"></script>
<?php
require_once __DIR__ . '/../views/layout/footer.php';
?>