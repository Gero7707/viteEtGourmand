<?php
$pageSpecificCss = 'style.css';
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <a href="/">Accueil</a><br>
    <a href="/menus">Menus</a><br>
    <hr>
    <?php if ($_GET['error'] ?? null): ?>
        <p><?= htmlspecialchars($_GET['error']) ?></p><br>
        <hr>
    <?php elseif($_GET['success'] ?? null) :?>
        <p><?= htmlspecialchars($_GET['success']) ?></p><br>
        <hr>
    <?php endif ?>
    <h4>Créer un menu</h4>
    <form action="/create-menu" method="POST" enctype="multipart/form-data">
        <?= Auth::csrfField() ?>
        <label for="theme">Thème</label><br>
        <select name="theme_id" id="theme_id" required>
            <?php foreach($themes as$theme) : ?>
                <option value="<?= htmlspecialchars($theme['theme_id']) ?>"><?= htmlspecialchars($theme['libelle']) ?></option>
            <?php endforeach ?>
        </select><br>

        <label for="regime">Régime</label><br>
        <select name="regime_id" id="regime_id" required>
            <?php foreach($regimes as $regime) : ?>
                <option value="<?= htmlspecialchars($regime['regime_id']) ?>" ><?= htmlspecialchars($regime['libelle']) ?></option>
            <?php endforeach ?>
        </select><br>

        <label for="titre">Titre du menu</label><br>
        <input type="text" name="titre" id="titre" required><br>

        <label for="nombre_personne_minimum">Nombre de personnes minimum</label><br>
        <input type="number" name="nombre_personne_minimum" id="nombre_personne_minimum"><br>

        <label for="prix_par_personne">Prix par personne</label><br>
        <input type="number" step="0.01" name="prix_par_personne" id="prix_par_personne" required><br>

        <label for="description">Descrition du menu</label><br>
        <textarea name="description" id="description" rows="5" cols="33" required></textarea><br>

        <label for="quantite_restante">Quantite disponible</label><br>
        <input type="number" name="quantite_restante" id="quantite_restante" required><br>

        <label for="conditions_delai">Delais</label><br>
        <textarea name="conditions_delai" id="conditions_delai" rows="5" cols="33" required><?= htmlspecialchars($menu['conditions_delai']) ?></textarea><br>

        <label for="conditions_stockage">Stockage</label><br>
        <textarea name="conditions_stockage" id="conditions_stockage" rows="5" cols="33" required><?= htmlspecialchars($menu['conditions_stockage']) ?></textarea><br>

        <label for="conditions_infos">Infos supplémentaires</label><br>
        <textarea name="conditions_infos" id="conditions_infos" rows="5" cols="33" required><?= htmlspecialchars($menu['conditions_infos']) ?></textarea><br>
        
        <label for="img_menu">Image du menu</label><br>
        <input type="file" name="img_menu" id="img_menu" required><br>

        <button type="submit">Céer menu</button>
    </form>
</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>