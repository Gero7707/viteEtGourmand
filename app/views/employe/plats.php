<?php
$pageSpecificCss = ['style.css' , 'formulaire.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
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
    
    <hr>
    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
    <section class="section-plats row">
        <?php foreach($plat as $cartePlat) : ?>
            <div class="carte-plat  col-lg-4 mx-4 col-sm-12 mt-3">
                <h5 class="text-center"><?= htmlspecialchars($cartePlat['titre_plat']) ?></h5>
                <div class="d-flex ">
                    <div class="titre-plat d-flex flex-column">
                        <p><span>Type</span> : <?= htmlspecialchars(ucfirst($cartePlat['type_plat'])) ?></p>
                        <p><span>Assigné à</span> : <?= htmlspecialchars($cartePlat['menu_titre'] ?? 'N\'est pas assigné à un menu') ?></p>
                    </div>
                    <div class="img-plat">
                        <img src="<?= htmlspecialchars($cartePlat['chemin_photo']) ?>" alt="<?= htmlspecialchars($cartePlat['titre_plat']) ?>" >
                    </div>
                </div>
                <div class="mt-2 catre-allergene">
                    <p><span>Allergènes</span> :<?php foreach($cartePlat['allergenes'] as $allergene) : ?>
                        <?= implode(' - ', array_map('htmlspecialchars', array_column($cartePlat['allergenes'], 'libelle'))) ?>
                    <?php endforeach ?></p>
                </div>
                <div class="d-flex justify-content-around">
                    <div class="text-center modifier">
                        <a class="mb-2" href="/plats/edit/<?= htmlspecialchars($cartePlat['plat_id']) ?>">Modifier</a>
                        <form action="/plats/delete/<?= htmlspecialchars($cartePlat['plat_id']) ?>" method="POST">
                            <?= Auth::csrfField() ?>
                            <button type="submit">Supprimer</button><br>
                        </form>
                    </div>
                    <?php if(!empty($cartePlat['menu'])) : ?>
                        <div class="text-center">
                            <form action="plats/associer/<?= htmlspecialchars($cartePlat['plat_id']) ?>" method="POST">
                                <?= Auth::csrfField() ?>
                                <select name="menu_id" id="menu_id"  required>
                                    <? foreach($cartePlat['menu'] as $menu) : ?>
                                        <option value="<?= htmlspecialchars($menu['menu_id']) ?>"><?= htmlspecialchars($menu['titre']) ?></option>
                                    <? endforeach ?>
                                </select><br>
                                <button class="mt-2"type="submit">Associer</button>
                            </form>
                        </div>
                    <?php else : ?>
                        <div class="message-plat">
                            <p class="mt-3 ">Aucun menu disponible pour ce plat.</p>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        <?php endforeach ?>
        
    </section>
</main>
<?php
$loadScriptJs = '';

require_once __DIR__ . '/../../views/layout/importJs.php';
?>