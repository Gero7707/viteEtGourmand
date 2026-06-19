<?php
$pageSpecificCss = ['style.css' , 'layout.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>


<main>
    <?php if ($_SESSION['role_id'] === 2) :  ?>
        <div class="d-none d-md-flex justify-content-around">
            <a href="/employe/dashboard" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Dashoard</a><br>
            <a href="/commandes-client" class="text-centerfw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Commandes</a><br>
            <a href="/avis-valider" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Avis</a><br>
            <a href="/menus" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Menus</a><br>
            <a href="/plats" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Plats</a><br>
            <a href="/changer-horaire" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Horaires</a><br>
        </div>
    <?php elseif ($_SESSION['role_id'] === 3) :  ?>
        <div class="d-none d-md-flex justify-content-around">
            <a href="/admin/dashboard" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Dashoard</a><br>
            <a href="/commandes-client" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Commandes</a><br>
            <a href="/avis-valider" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Avis</a><br>
            <a href="/menus" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Menus</a><br>
            <a href="/plats" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Plats</a><br>
            <a href="/changer-horaire" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Horaires</a><br>
        </div>
    <?php endif ?>
    <p class="success-message text-center"></p>
    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message-php text-center mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message-php text-center mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
    <hr>

    <?php if($_SESSION['role_id'] === 2 || $_SESSION['role_id'] === 3) : ?>
        <div class="text-center input-select">
            <label for="statut">Filtrer par statut :</label>
            <select name="statut" id="statut">
                <option value=""></option>
                <option value="en_attente">En attente</option>
                <option value="acceptee">Acceptée</option>
                <option value="en_preparation">En préparation</option>
                <option value="en_livraison">En livraison</option>
                <option value="livree">Livrée</option>
                <option value="attente_retour_materiel">Attente retour matériel</option>
                <option value="terminee">Terminee</option>
            </select>
        </div>
    <?php endif ?>

    <section class="section-commandes-entreprise mt-3 mb-5">
        <h4 class="text-center mb-4">Commandes Clients</h4>
        <table class="tableau-commande-entreprise" >
            <thead>
                <tr>
                    <th>Menu</th>
                    <th class=" d-none d-xxl-table-cell">Nom Client</th>
                    <th class=" d-none d-xxl-table-cell">No Commande</th>
                    <th class=" d-none d-md-table-cell">Date prestation</th>
                    <th class=" d-none d-md-table-cell">Nombre</th>
                    <th class=" d-none d-md-table-cell">Statut</th>
                    <th>Voir</th>
                    <th class=" d-none d-md-table-cell">Modifier</th>
                    <th class=" d-none d-md-table-cell">Annuler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($commandes as $commande) : ?>
                    <tr class="ligne-commande" data-statut="<?= $commande['statut'] ?>">
                        <td><?= htmlspecialchars($commande['titre']) ?></td>
                        <td class=" d-none d-xxl-table-cell"><?= htmlspecialchars($commande['nom_complet']) ?></td>
                        <td class=" d-none d-xxl-table-cell"><?= htmlspecialchars($commande['numero_commande']) ?></td>
                        <td class=" d-none d-md-table-cell"><?= date('d/m/Y', strtotime($commande['date_prestation']) )?></td>
                        <td class=" d-none d-md-table-cell"><?= htmlspecialchars($commande['nombre_personne']) ?></td>
                        <td class=" d-none d-md-table-cell statut-commande"><?= htmlspecialchars(str_replace(['en_attente', 'en_preparation', 'en_livraison', 'attente_retour_materiel', 'terminee', 'acceptee', 'annulee', 'livree'],
                                                            ['En attente', 'En préparation', 'En livraison', 'Attente retour matériel', 'Terminée', 'Acceptée', 'Annulée', 'Livrée'],
                                                            $commande['statut'])) ?>
                        </td>
                        <td>
                            <a class="voir-commande-client" href="/commandes/<?= $commande['commande_id'] ?>"><i class="fa-solid fa-eye"></i></a>
                        </td>
                        <td class=" d-none d-md-table-cell">
                            <?php if($commande['statut'] !== 'terminee' && $commande['statut'] !== 'annulee') : ?>
                                <form class="form-changer-statut" action="/commandes/update/<?= $commande['commande_id'] ?>" method="POST">
                                    <?= Auth::csrfField() ?>
                                    <button class="changer-statut" type="submit">Statut</button>
                                </form>
                            <?php endif ?>
                        </td>
                        <td class=" d-none d-md-table-cell">
                            <?php if($commande['statut'] !== 'terminee' && $commande['statut'] !== 'annulee') : ?>
                                <a class="annuler-commande" href="/commandes/annuler-commande/<?= $commande['commande_id'] ?>">Annuler</a>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </section>
</main> 
<?php
$loadScriptJs = 'filtreAdminEmploye.js';
require_once __DIR__ . '/../../views/layout/importJs.php';
require_once __DIR__ . '/../../views/layout/footer.php';
?>
