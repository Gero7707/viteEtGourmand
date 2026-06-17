<?php
$pageSpecificCss = ['style.css' , 'formulaire.css' , 'layout.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <p class="error-message mt-1 text-center"></p><br>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>

    <?php if ($_SESSION['role_id'] === 2) :  ?>
        <div class="d-flex justify-content-around">
            <a href="/employe/dashboard" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Dashoard</a><br>
            <a href="/commandes-client" class="text-centerfw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Commandes</a><br>
            <a href="/avis-valider" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Avis</a><br>
            <a href="/menus" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Menus</a><br>
            <a href="/create-menu" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Créer un menu</a><br>
            <a href="/plats" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Plats</a><br>
            <a href="/plats/create" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Créer un plat</a><br>
            <a href="/changer-horaire" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Changer horaire</a><br>
        </div>
    <?php elseif ($_SESSION['role_id'] === 3) :  ?>
        <div class="d-flex justify-content-around">
            <a href="/admin/dashboard" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Dashoard</a><br>
            <a href="/commandes-client" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Commandes</a><br>
            <a href="/avis-valider" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Avis</a><br>
            <a href="/menus" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Menus</a><br>
            <a href="/create-menu" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Créer un menu</a><br>
            <a href="/plats" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Plats</a><br>
            <a href="/plats/create" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Créer un plat</a><br>
            <a href="/changer-horaire" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Changer horaire</a><br>
        </div>
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
                <p><?= htmlspecialchars(str_replace(':00', 'h',date('d/m/Y  \à  H:i', strtotime($carteAvis['date_avis'])))) ?></p>
                
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
require_once __DIR__ . '/../../views/layout/importJs.php';
?>