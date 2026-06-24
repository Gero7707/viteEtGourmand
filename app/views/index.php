<?php
$pageTitle = "Vite & Gourmand — Traiteur événementiel à Bordeaux";
$pageSpecificCss = ['style.css' , 'carousel.css' , 'layout.css'];
require_once __DIR__ . '/../views/layout/header.php';

?>

<main>
    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message-php text-center mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message-php text-center mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
    <?php if(!isset($_SESSION['utilisateur_id'])): ?>
        
        <div class="d-flex  intro flex-column">
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
            <div class="d-flex intro flex-column">
                <div>
                    <?php if($_SESSION['flash_bienvenue'] ?? false): ?>
                        <p class="fw-bolder text-center  text-success">Bonjour  <?= $_SESSION['prenom'] ?>  !</p>
                        <?php unset($_SESSION['flash_bienvenue']); ?>
                    <?php endif ?>
                    <p class="fw-medium text-center">L'art de la réception, depuis 1999 </p>
                    <p class="fw-medium text-center mb-2">Vite & Gourmand, traiteur événementiel à Bordeaux. Des menus raffinés, livrés chez vous,pour tous vos événements.</p>
                </div>
                <div class="text-center">
                    <a href="/menus" class="fw-mediumbold bg-secondary text-primary lien-intro  ">Découvrir nos menus</a>
                </div>
            </div>
        
        <?php elseif ($_SESSION['role_id'] === 2) :  ?>
            <div class="d-none d-md-flex justify-content-around">
                <a href="/employe/dashboard" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Dashoard</a><br>
                <a href="/commandes-client" class="text-centerfw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Commandes</a><br>
                <a href="/avis-valider" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Avis</a><br>
                <a href="/menus" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Menus</a><br>
                <a href="/plats" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Plats</a><br>
                <a href="/changer-horaire" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Horaires</a><br>
            </div>
        <?php elseif ($_SESSION['role_id'] === 3) :  ?>
            <div class="d-none d-md-flex justify-content-around">
                <a href="/admin/dashboard" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Dashoard</a><br>
                <a href="/commandes-client" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Commandes</a><br>
                <a href="/avis-valider" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Avis</a><br>
                <a href="/menus" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Menus</a><br>
                <a href="/plats" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Plats</a><br>
                <a href="/changer-horaire" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Horaires</a><br>
            </div>
        <?php endif ?>

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
                        <img src="/assets/img/accueil/banquet.webp" alt="banquet fleuri et servi de son entrée" data-swiper-parallax-x="30%" loading="lazy">
                    </div>
                </div>
                <div class="swiper-slide"> 
                    <div class="img-wrapper">
                        <img src="/assets/img/accueil/table.webp" alt="table décorée de fleurs blanches et jaunes" data-swiper-parallax-x="30%" loading="lazy">
                    </div>
                </div>
                <div class="swiper-slide"> 
                    <div class="img-wrapper">
                        <img src="/assets/img/accueil/champetre.webp" alt="repas champetre et son ornementation estivale" data-swiper-parallax-x="30%" loading="lazy">
                    </div>
                </div>
                <div class="swiper-slide"> 
                    <div class="img-wrapper">
                        <img src="/assets/img/accueil/reception.webp" alt="reception fleurie et festive" data-swiper-parallax-x="30%" loading="lazy">
                    </div>
                </div>
                <div class="swiper-slide"> 
                    <div class="img-wrapper">
                        <img src="/assets/img/accueil/fete.webp" alt="banquet" data-swiper-parallax-x="30%" loading="lazy">
                    </div>
                </div>
            </div>
            <div class="swiper-button-next"></div>
        </div>
    </section>
    
    <section class="section-savoir-faire">
        <h2 class="text-center mb-5 mt-5">Notre savoir faire</h2>
        <div class="d-flex carte-savoir-faire mb-4 mt-5 ">
            <img src="/assets/img/accueil/grande-table.webp" alt="Grande table de banquet " class="img-carte1 observer mb-5">
            <div class="d-flex flex-column texte text-center texte-carte1 observer">
                <p class="mb-5 mt-2">Depuis 1999, Vite & Gourmand met son expertise au service de vos réceptions. </p>
                <p class="mb-2">Chaque menu est élaboré avec des produits frais et de saison, <br> sélectionnés auprès de producteurs locaux bordelais.</p>
                <p >De l'entrée au dessert, nos plats allient saveurs authentiques et <br> présentation soignée pour faire de chaque repas un moment inoubliable.</p>
            </div>
        </div>

        <div class="d-flex carte-savoir-faire mb-4 mt-5">
            <div class="d-flex flex-column texte text-center texte-carte2 observer ">
                <p class="mb-5 mt-5">Notre équipe accompagne vos événements de A à Z . Conception de menus personnalisés, préparation dans nos cuisines, livraison et mise en place chez vous.</p>
                <p class="mb-5">Mariages, repas d'entreprise, fêtes de famille ou galas, nous nous adaptons à chaque occasion avec le même souci du détail et de l'excellence. </p>
                <p >Plus de 2 000 événements réussis à Bordeaux et dans toute la Gironde.</p>
            </div>
            <img src="/assets/img/menus/menu-de-reve.webp" alt="table dressée et ornementée de branches de rosiers" class="img-carte2 observer mt-5">
            
        </div>
    </section>
    
    <section class="section-avis bg-primary m-auto mt-5 pt-5 pb-4 mb-5">
        <h2 class="text-secondary text-center mb-5">Avis clients</h2>
                
            <div class="row-accueil row">
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
                        <p class="date-avis"><?= htmlspecialchars(str_replace(':00', 'h',date('Y-m-d  à  H:i', strtotime($carteAvis['date_avis'])))) ?></p>
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


<?php
$loadScriptJs = ['intersectionObserver.js' , 'Swiper.js' ];
require_once __DIR__ . '/../views/layout/importJs.php';
require_once __DIR__ . '/../views/layout/footer.php';
?>