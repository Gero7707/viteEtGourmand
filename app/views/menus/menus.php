<?php
$pageSpecificCss = ['style.css' , 'formulaire.css' , 'layout.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>
<?php if ($_GET['error'] ?? null): ?>
    <p class="error-message-php text-center mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
<?php endif ?>
<?php if ($_GET['success'] ?? null): ?>
    <p class="success-message-php text-center mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
<?php endif ?>
<main class="menus-main">
    <p class=" arborescence text-center "><a href="/">Accueil<</a>Menus</p>
    <div class="d-flex justify-content-aroun">
        <section class="section-filtres">
            <button id="init-filtres" type="button">Réinitialiser</button>
            <div class="filtres">
                <h4 class="mt-5">Filtres</h4>
                <ul>
                    <li>Prix :
                        <p id="messageBouton"></p>
                        <ul class="liste-bouton">
                            <li><button class="btn-filtre" type="button" data-min="0" data-max="19.99"><i class="fa-solid fa-arrow-right"></i>&nbsp; < à 20€</button></li>
                            <li><button class="btn-filtre" type="button" data-min="20" data-max="29.99"><i class="fa-solid fa-arrow-right"></i>&nbsp; de 20€ à 30€</button></li>
                            <li><button class="btn-filtre" type="button" data-min="30" data-max="100"><i class="fa-solid fa-arrow-right"></i>&nbsp; > 30€</button></li><br>
                        </ul>
                        <p id="messageInput"></p>
                        <label for="prixMax">Prix max :</label>
                        
                        <input type="number" name="prixMax" id="prixMax" class="mb-5">
                        
                    </li>
                    <li class="mb-5">Thème : 
                            <select name="theme" id="theme">
                                <option value=""></option>
                                <option value="1">Classique</option>
                                <option value="2">Noêl</option>
                                <option value="3">Pacques</option>
                                <option value="4">Evènement</option>
                            </select></li>
                    <li class="mb-5">Régime :
                        <select name="regime" id="regime">
                            <option value=""></option>
                            <option value="1">Classique</option>
                            <option value="2">Végétarien</option>
                            <option value="3">Végan</option>
                        </select>
                    </li>
                    <li><label for="nombre">Nombre personnes :</label><br>
                        <i class="fa-solid fa-arrow-right"></i><input class="iput-nombre" type="number" name="nombre" id="nombre" placeholder="min 4"><br>
                        
                    </li>
                </ul>
            </div>
        </section>

        <section class="section-menus bg-primary mt-5 pt-5 pb-4 mb-5">
                
                <div class="row justify-content-center px-5 gx-5 " id="carteContainer">
                    <p id="messageFiltre"></p>
                    <?php foreach($menus as $menu) : ?>
                        <article class="carte-menu mb-5 col-lg-4 mx-4 col-sm-12 d-flex flex-column" data-menu-id="<?= $menu['menu_id'] ?>" data-theme="<?= $menu['theme_id'] ?>" data-prix="<?= $menu['prix_par_personne'] ?>" data-regime = "<?= $menu['regime_id'] ?>" data-nombre = "<?= $menu['nombre_personne_minimum'] ?>" >
                            
                            <div class="d-flex justify-content-between en-tete-carte-menu">
                                <h4><?= htmlspecialchars($menu['titre']) ?></h4>
                                <a href="/menus/<?=  htmlspecialchars($menu['menu_id']); ?>">Voir menu</a><br>
                            </div>
                            <div class="prix mt-1">
                                <p>Prix : <?= htmlspecialchars($menu['prix_par_personne']) ?>€/pers</p><br>
                            </div>
                            <div class="texte-img d-flex">
                                <div class="theme-description d-flex flex-column">
                                    
                                    <div class="theme-regime">
                                        <p>Thème :</p>
                                        <p class="theme-carte mb-5" ><?= htmlspecialchars($menu['theme']) ?></p>
                                        <p>Régime :</p>
                                        <p class="regime-carte "><?= htmlspecialchars($menu['regime']) ?></p>
                                    </div>
                                    
                                    <div>
                                        <p class="menu-description"><?= htmlspecialchars($menu['description']) ?></p>
                                    </div>
                                </div>
                                <div class="d-flex flex-column img-nb-personne">
                                    <img src="<?= htmlspecialchars($menu['image']) ?>" alt="">
                                    <p>A partir de <?= htmlspecialchars($menu['nombre_personne_minimum']) ?> personnes</p><br>
                                    <p class="liste-allergene" data-menu-id="<?= $menu['menu_id'] ?>"><i class="fa-regular fa-hand-point-right"></i>Allergènes</p>
                                    <div class="modal-allergenes"></div>
                                </div>
                                
                            </div>
                            
                            
                            <div class="action-entreprise d-flex justify-content-around">
                                <?php if(isset($_SESSION['role_id']) && ($_SESSION['role_id'] === 2 || $_SESSION['role_id'] === 3 )) : ?>
                                    <a href="/menus/edit/<?= htmlspecialchars($menu['menu_id']) ?>">Modifier</a><br>
                                    <form action="/menus/delete/<?= htmlspecialchars($menu['menu_id']) ?>" method="POST">
                                        <?= Auth::csrfField() ?>
                                        <button type="submit">Supprimer</button>
                                    </form>
                                <?php endif ?>
                            </div>
                        </article>
                    <?php endforeach ?>
                </div>
        </section>
    </div>

</main>




<?php
$loadScriptJs = 'filtres.js';
require_once __DIR__ . '/../../views/layout/importJs.php';
require_once __DIR__ . '/../../views/layout/footer.php';
?>