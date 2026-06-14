<?php
$pageSpecificCss = ['style.css' , 'formulaire.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main class="d-flex justify-content-around">
    <div class="carte-menu-commande">
        <div class="d-flex justify-content-around">
            <div class="d-flex flex-column mt-1">
                <h5><?= htmlspecialchars($menu['titre']) ?></h5>
                <p class="theme-carte"><i class="fa-solid fa-square"></i>       &nbsp;<?= htmlspecialchars($menu['regime']) ?></p> 
            </div>
            <div class="d-flex flex-column prix-menu mt-1 mb-5">
                <h6>Prix pour <?= htmlspecialchars($menu['nombre_personne_minimum']) ?> personnes :</h6>
                <p>Prix : <?= htmlspecialchars($menu['prix_par_personne']) ?> € / personne</p>
                <p>Hors frais livraison</p>
            </div>
        </div>
        <div class="texte-carte-commande">
            <p><?= htmlspecialchars($menu['description']) ?></p>
        </div>
        <div class="plats d-flex flex-column align-items-start m-auto">
            <?php foreach($plat as $p) : ?>
                <p><strong><?= ucfirst(htmlspecialchars($p['type_plat'])) ?></strong> : <?= htmlspecialchars($p['titre_plat']) ?></p>
                <p><i class="fa-solid fa-arrow-right"></i>Allergènes :
                    <?php foreach($p['allergenes'] as $allergene) : ?>
                        <?= htmlspecialchars($allergene['libelle']) ?> ,
                    <?php endforeach ?>
                </p>
            <?php endforeach ?>
        </div>
    </div>

    
    <div class="d-flex flex-column  form-contact">
        <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message-php text-center mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message-php text-center mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>

        <h3 class="text-center ">Modifier otre commande</h3>

        <form action="/commandes/edit/<?= $commande['commande_id'] ?>" method="POST" class="text-center">
            <?= Auth::csrfField() ?>
            <input type="hidden" name="menu_id" id="menu_id" value="<?= htmlspecialchars($commande['menu_id']) ?>">
            <input type="hidden" name="commande_id" id="commande_id" value="<?= htmlspecialchars($commande['commande_id']) ?>">
            <input type="hidden" name="distance_km" id="distance_km" value="0">

            

            <label class="form-label" for="adresse_livraison">Adresse :</label><br>
            <input class="form-control" type="text" name="adresse_livraison" id="adresse_livraison" value="<?= htmlspecialchars($commande['adresse_livraison'] ?? '') ?>" required><br>
            <small>Indiquez l'adresse du lieu de l'événement (salle des fêtes, domicile, lieu de réception...)</small><br>

            <label class="form-label" for="code_postal">Code Postal :</label><br>
            <input class="form-control" type="text" name="code_postal" id="code_postal" value="<?= htmlspecialchars($commande['code_postal'] ?? '') ?>" required><br>

            <label class="form-label" for="ville">Ville :</label><br>
            <input class="form-control" type="text" name="ville" id="ville" value="<?= htmlspecialchars($commande['ville'] ?? '') ?>" required><br>

            <label class="form-label" for="utilisateur_gsm">Téléphone :</label><br>
            <input class="form-control" type="text" name="utilisateur_gsm" id="utilisateur_gsm" value="<?= htmlspecialchars($commande['utilisateur_gsm'] ?? '') ?>" required><br>

            
            <label class="form-label" for="date_prestation">Date prestation :</label><br>
            <input class="form-control" type="date" name="date_prestation" id="date_prestation" value="<?= htmlspecialchars($commande['date_prestation'] ?? '') ?>" required>
                
            <label class="form-label" for="heure_livraison">Heure livraison :</label><br>
            <input class="form-control" type="time" name="heure_livraison" id="heure_livraison" value="<?= htmlspecialchars($commande['heure_livraison'] ?? '') ?>" required>
                
            <label class="form-label" for="nombre_personne">Nombre de personnes :</label><br>
            <input class="form-control" type="number" name="nombre_personne" id="nombre_personne" value="<?= htmlspecialchars($commande['nombre_personne'] ?? '') ?>" required><br>

            
            <p id="errorMessage"></p>
            <p class="error-message mt-1 text-center"></p><br>
            <div id="resultatCalculFrais"></div>

            <div>
                <button class="mt-3" type="button" id="calcul_frais">Calculer les frais</button><br><br>
                <a class="annuler" href="/profile">Annuler</a><br>
                <button  class="mt-3 mb-3 btn-form" type="submit" id="btnValider" disabled>Valider</button>
            </div>
        </form>
    </div>
    
</main>
<?php
$loadScriptJs = ['calculerPrix.js' , 'form.js'];
require_once __DIR__ . '/../../views/layout/importJs.php';
?>