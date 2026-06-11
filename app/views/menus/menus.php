<?php
$pageSpecificCss = ['style.css' , 'formulaire.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>
<?php if ($_GET['error'] ?? null): ?>
    <p class="error-message mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
<?php endif ?>
<?php if ($_GET['success'] ?? null): ?>
    <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
<?php endif ?>
<main >
    <div class="d-flex justify-content-aroun">
        <section class="section-filtres">
            <button id="init-filtres" type="submit">Réinitialiser</button>
            <div class="filtres">
                <h4 class="mt-5">Filtres</h4>
                <ul>
                    <li>Prix :<br>
                        <ul>
                            <li><i class="fa-solid fa-arrow-right"></i>&nbsp; < à 20€</li>
                            <li><i class="fa-solid fa-arrow-right"></i>&nbsp; de 20€ à 30€</li>
                            <li><i class="fa-solid fa-arrow-right"></i>&nbsp; > 30€</li><br>
                        </ul>
                        <label for="prix_max">Prix max :</label>
                        <input type="number" name="prix_max" id="prix_max" class="mb-5">
                    </li>
                    <li class="mb-5">Thème : 
                            <select name="theme" id="theme">
                                <option value="noel">Noêl</option>
                                <option value="pacques">Pacques</option>
                                <option value="classique">Classique</option>
                                <option value="evenement">Evènement</option>
                            </select></li>
                    <li class="mb-5">Régime :
                        <select name="regime" id="regime">
                            <option value="vegan">Végan</option>
                            <option value="vegetarien">Végétarien</option>
                            <option value="classique">Classique</option>
                        </select>
                    </li>
                    <li><label for="nb_personne">Nombre personnes :</label><br>
                        <i class="fa-solid fa-arrow-right"></i><input class="iput-nombre" type="number" name="nb_personne" id="nb_personne" placeholder="min 4"><br>
                        
                    </li>
                </ul>
            </div>
        </section>

        <section class="section-menus bg-primary mt-5 pt-5 pb-4 mb-4">
                    
                <div class="row">
                    <?php foreach($menus as $menu) : ?>
                        <div class="col-lg-1 col-sm-2"></div>
                        <div class="carte-menu mb-5 col-lg-4 col-sm-8">
                            
                            <div class="d-flex justify-content-between en-tete-carte-menu">
                                <h4><?= htmlspecialchars($menu['titre']) ?></h4>
                                <a href="/menus/<?=  htmlspecialchars($menu['menu_id']); ?>">Voir menu</a><br>
                            </div>
                            <div class="prix mt-4">
                                <p>Prix : <?= htmlspecialchars($menu['prix_par_personne']) ?>€/pers</p><br>
                            </div>
                            <div class="texte-img d-flex">
                                <div class="theme-description d-flex flex-column">
                                    <div>
                                        <p class="theme-carte"><?php if($menu['regime'] === 'Classique') : ?>
                                                                    <i class="fa-solid fa-square"></i>   
                                                                <?php elseif($menu['regime'] === 'Vegan') : ?>
                                                                    <i class="fa-solid fa-circle"></i>
                                                                <?php elseif($menu['regime'] === 'Végétarien') : ?>
                                                                    <i class="fa-solid fa-diamond"></i>
                                                                <?php endif ?>     &nbsp;<?= htmlspecialchars($menu['regime']) ?></p>
                                    </div>
                                    <div>
                                        <p><?= htmlspecialchars($menu['description']) ?></p>
                                    </div>
                                </div>
                                <div class="d-flex flex-column img-nb-personne">
                                    <img src="<?= htmlspecialchars($menu['image']) ?>" alt="">
                                    <p>A partir de <?= htmlspecialchars($menu['nombre_personne_minimum']) ?> personnes</p><br>
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
                        </div>
                        <div class="col-lg-1 col-sm-2"></div>
                    <?php endforeach ?>
                </div>
        </section>
    </div>

</main>




<?php
$loadScriptJs = '';
require_once __DIR__ . '/../../views/layout/importJs.php';
?>