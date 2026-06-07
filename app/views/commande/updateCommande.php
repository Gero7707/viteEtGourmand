<?php
$pageSpecificCss = ['style.css' , 'formulaire.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main class="d-flex justify-content-around">
    <div class="menu-choisi text-center">
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
    </div>

    
    <div class="d-flex flex-column  form-contact">

        <h3 class="text-center mt-4">Votre commande</h3>

        <form action="/commandes/edit/<?= $commande['commande_id'] ?>" method="POST" class="text-center">
            <?= Auth::csrfField() ?>
            <input type="hidden" name="menu_id" id="menu_id" value="<?= htmlspecialchars($commande['menu_id']) ?>">
            <input type="hidden" name="commande_id" id="commande_id" value="<?= htmlspecialchars($commande['commande_id']) ?>">
            <input type="hidden" name="distance_km" id="distance_km" value="0">

            <?php if ($_GET['error'] ?? null): ?>
                <p class="error-message mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
            <?php endif ?>
            <?php if ($_GET['success'] ?? null): ?>
                <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
            <?php endif ?>

            <label class="mt-3" for="adresse_livraison">Adresse</label><br>
            <input type="text" name="adresse_livraison" id="adresse_livraison" value="<?= htmlspecialchars($commande['adresse_livraison'] ?? '') ?>" required><br>
            <small>Indiquez l'adresse du lieu de l'événement (salle des fêtes, domicile, lieu de réception...)</small><br>

            <label class="mt-3" for="code_postal">Code Postal</label><br>
            <input type="text" name="code_postal" id="code_postal" value="<?= htmlspecialchars($commande['code_postal'] ?? '') ?>" required><br>

            <label class="mt-3" for="ville">Ville</label><br>
            <input type="text" name="ville" id="ville" value="<?= htmlspecialchars($commande['ville'] ?? '') ?>" required><br>

            <label class="mt-3" for="utilisateur_gsm">Téléphone</label><br>
            <input type="text" name="utilisateur_gsm" id="utilisateur_gsm" value="<?= htmlspecialchars($commande['utilisateur_gsm'] ?? '') ?>" required><br>

            <div class="d-flex justify-content-around">
                <div class="d-flex flex-column align-content-center">
                    <label class="mt-3" for="date_prestation">Date prestation</label><br>
                    <input type="date" name="date_prestation" id="date_prestation" value="<?= htmlspecialchars($commande['date_prestation'] ?? '') ?>" required>
                </div>
                <div class="d-flex flex-column">
                    <label class="mt-3" for="heure_livraison">Heure livraison</label><br>
                    <input type="time" name="heure_livraison" id="heure_livraison" value="<?= htmlspecialchars($commande['heure_livraison'] ?? '') ?>" required>
                </div>
                <div class="d-flex flex-column align-items-center">
                    <label class="mt-3" for="nombre_personne">Nombre de personnes</label><br>
                    <input type="number" name="nombre_personne" id="nombre_personne" value="<?= htmlspecialchars($commande['nombre_personne'] ?? '') ?>" required><br>
                </div>
            </div>

            <button type="button" id="calcul_frais">Calculer les frais</button>
            <p id="errorMessage"></p>
            <div id="resultatCalculFrais">
                
            </div>

            <button type="submit" id="btnValider" disabled>Valider</button>
        </form>
    </div>
    
</main>
<script src="/assets/js/calculerPrix.js"></script>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>