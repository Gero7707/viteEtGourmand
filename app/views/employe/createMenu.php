<?php
$pageSpecificCss = ['style.css' , 'formulaire.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <?php if($_GET['success'] ?? null) :?>
        <p class="success-message mt-1 text-center"><?= htmlspecialchars($_GET['success']) ?></p><br>
    <?php endif ?>
    <div class="d-flex justify-content-center">
        <div class="d-flex flex-column justify-content-center form-contact">
            <h4 class="text-center mt-3 mb-3">Créer un menu</h4>
            <form action="/create-menu" method="POST" enctype="multipart/form-data" class="text-center">
                <?= Auth::csrfField() ?>
                <label class="mt-3 mb-1" for="theme">Thème :</label><br>
                <select name="theme_id" id="theme_id" >
                    <option value=""></option>
                    <?php foreach($themes as$theme) : ?>
                        <option value="<?= htmlspecialchars($theme['theme_id']) ?>"><?= htmlspecialchars($theme['libelle']) ?></option>
                    <?php endforeach ?>
                </select><br>

                <label class="mt-3 mb-1" for="regime">Régime :</label><br>
                <select name="regime_id" id="regime_id" >
                    <option value=""></option>
                    <?php foreach($regimes as $regime) : ?>
                        <option value="<?= htmlspecialchars($regime['regime_id']) ?>" ><?= htmlspecialchars($regime['libelle']) ?></option>
                    <?php endforeach ?>
                </select><br>

                <label class="mt-3 mb-1" for="titre">Titre du menu :</label><br>
                <input type="text" name="titre" id="titre" ><br>

                <label class="mt-3 mb-1" for="nombre_personne_minimum">Nombre de personnes minimum :</label><br>
                <input type="number" name="nombre_personne_minimum" id="nombre_personne_minimum"><br>

                <label class="mt-3 mb-1" for="prix_par_personne">Prix par personne :</label><br>
                <input type="number" step="0.01" name="prix_par_personne" id="prix_par_personne" ><br>

                <label class="mt-3 mb-1" for="description">Descrition du menu :</label><br>
                <textarea name="description" id="description" rows="5" cols="33" ></textarea><br>

                <label class="mt-3 mb-1" for="quantite_restante">Quantite disponible :</label><br>
                <input type="number" name="quantite_restante" id="quantite_restante" ><br>

                <label class="mt-3 mb-1" for="conditions_delai">Delais :</label><br>
                <textarea name="conditions_delai" id="conditions_delai" rows="5" cols="33" required><?= htmlspecialchars($menu['conditions_delai']) ?></textarea><br>

                <label class="mt-3 mb-1" for="conditions_stockage">Stockage :</label><br>
                <textarea name="conditions_stockage" id="conditions_stockage" rows="5" cols="33" required><?= htmlspecialchars($menu['conditions_stockage']) ?></textarea><br>

                <label class="mt-3 mb-1" for="conditions_infos">Infos supplémentaires :</label><br>
                <textarea name="conditions_infos" id="conditions_infos" rows="5" cols="33" required><?= htmlspecialchars($menu['conditions_infos']) ?></textarea><br>
                
                <label class="mt-3 mb-1" for="img_menu">Image du menu :</label><br>
                <input type="file" name="img_menu" id="img_menu" ><br>

                <button class="btn-form mt-3 mb-3" type="submit">Céer menu</button>
            </form>
            
        </div>
        
    </div>
    
    <p class="error-message mt-1 text-center"></p><br>
    
    
</main>
<?php
$loadScriptJs = 'form.js';
require_once __DIR__ . '/../../views/layout/footer.php';
?>