<?php
$pageSpecificCss = 'style.css';
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <a href="/profile">Retour</a><br>
    <hr>
    <h3><?= htmlspecialchars($menu['titre']) ?></h3>
    <hr>
    <h4>Prix/Personne :</h4>
    <p><?= htmlspecialchars($menu['prix_par_personne']) ?></p>
    <h4>Theme</h4>
    <p><?= htmlspecialchars($menu['theme']) ?></p><br>
    <h4>Regime</h4>
    <p><?= htmlspecialchars($menu['regime']) ?></p><br>
    <h5>Delai :</h5>
    <p><?= htmlspecialchars($menu['conditions_delai']) ?></p><br>
    <form action="/commandes/edit/<?= $commande['commande_id'] ?>" method="POST">
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

        <label for="adresse_livraison">Adresse</label><br>
        <input type="text" name="adresse_livraison" id="adresse_livraison" value="<?= htmlspecialchars($commande['adresse_livraison'] ?? '') ?>" required><br>
        <small>Indiquez l'adresse du lieu de l'événement (salle des fêtes, domicile, lieu de réception...)</small><br>

        <label for="code_postal">Code Postal</label><br>
        <input type="text" name="code_postal" id="code_postal" value="<?= htmlspecialchars($commande['code_postal'] ?? '') ?>" required><br>

        <label for="ville">Ville</label><br>
        <input type="text" name="ville" id="ville" value="<?= htmlspecialchars($commande['ville'] ?? '') ?>" required><br>

        <label for="utilisateur_gsm">Téléphone</label><br>
        <input type="text" name="utilisateur_gsm" id="utilisateur_gsm" value="<?= htmlspecialchars($commande['utilisateur_gsm'] ?? '') ?>" required><br>

        <label for="nombre_personne">Nombre de personnes</label><br>
        <input type="number" name="nombre_personne" id="nombre_personne" value="<?= htmlspecialchars($commande['nombre_personne'] ?? '') ?>" required><br>

        <label for="date_prestation">Date prestation</label><br>
        <input type="date" name="date_prestation" id="date_prestation" value="<?= htmlspecialchars($commande['date_prestation'] ?? '') ?>" required><br>

        <label for="heure_livraison">Heure livraison</label><br>
        <input type="time" name="heure_livraison" id="heure_livraison" value="<?= htmlspecialchars($commande['heure_livraison'] ?? '') ?>" required><br>

        <button type="button" id="calcul_frais">Calculer les frais</button>
        <p id="errorMessage"></p>
        <div id="resultatCalculFrais">
            
        </div>

        <button type="submit" id="btnValider" disabled>Valider</button>
    </form>
</main>
<script src="/assets/js/calculerPrix.js"></script>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>