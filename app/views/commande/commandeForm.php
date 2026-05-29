<?php
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
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
    <form action="/commandes/create" method="POST">
        <?= Auth::csrfField() ?>
        <input type="hidden" name="menu_id" id="menu_id" value="<?= htmlspecialchars($menu['menu_id']) ?>">
        <label for="adresse">Adresse</label><br>
        <input type="text" name="adresse" id="adresse" value="<?= htmlspecialchars($data['adresse'] ?? '') ?>" required><br>

        <label for="code_postal">Code Postal</label><br>
        <input type="text" name="code_postal" id="code_postal" value="<?= htmlspecialchars($data['code_postal'] ?? '') ?>" required><br>

        <label for="ville">Ville</label><br>
        <input type="text" name="ville" id="ville" value="<?= htmlspecialchars($data['ville'] ?? '') ?>" required><br>

        <label for="gsm">Téléphone</label><br>
        <input type="text" name="gsm" id="gsm" value="<?= htmlspecialchars($data['gsm'] ?? '') ?>" required><br>

        <label for="nombre_personne">Nombre de personnes</label><br>
        <input type="number" name="nombre_personne" id="nombre_personne" required><br>

        <label for="date_prestation">Date prestation</label><br>
        <input type="date" name="date_prestation" id="date_prestation" required><br>

        <label for="heure_livraison">Heure livraison</label><br>
        <input type="time" name="heure_livraison" id="heure_livraison" required><br>

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