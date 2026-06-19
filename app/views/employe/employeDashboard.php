<?php
$pageSpecificCss = ['style.css' , 'layout.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
   <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message-php text-center mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message-php text-center mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
    <?php if($_SESSION['flash_bienvenue'] ?? false): ?>
        <div class="text-center mt-2 intro">
            <p class="fw-mediumbold text-center">Bonjour  <?= $_SESSION['prenom'] ?>  !</p><br>
        </div>
        <?php unset($_SESSION['flash_bienvenue']); ?>
    <?php endif ?>
    <div class="d-none d-md-flex justify-content-around">
        <a href="/employe/dashboard" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Dashoard</a><br>
        <a href="/commandes-client" class="text-centerfw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Commandes</a><br>
        <a href="/avis-valider" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Avis</a><br>
        <a href="/menus" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Menus</a><br>
        <a href="/plats" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Plats</a><br>
        <a href="/changer-horaire" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Horaires</a><br>
    </div>
    <hr>

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
            <option value="terminee">Terminée</option>
        </select>
    </div>

    <div class="dashboard-commandes mt-4 mb-5">
        <h4 class="text-center mb-4">Commandes Clients</h4>
        <table class="tableau-commande-entreprise">
            <thead>
                <tr >
                    <th>Menu</th>
                    <th class="col-desktop">Nom Client</th>
                    <th class="col-desktop">Date prestation</th>
                    <th class="col-desktop">Nombre</th>
                    <th class="col-desktop">Statut</th>
                    <th>Voir</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($commandes as $commande) : ?>
                    <tr class="ligne-commande" data-statut="<?= $commande['statut'] ?>">
                        <td><?= htmlspecialchars($commande['titre']) ?></td>
                        <td class="col-desktop"><?= htmlspecialchars($commande['nom_complet']) ?></td>
                        <td class="col-desktop"><?= date('d/m/Y ', strtotime($commande['date_prestation'])) ?></td>
                        <td class="col-desktop"><?= htmlspecialchars($commande['nombre_personne']) ?></td>
                        <td class="col-desktop"><?= htmlspecialchars(str_replace(['en_attente', 'en_preparation', 'en_livraison', 'attente_retour_materiel', 'terminee', 'acceptee', 'annule', 'livree'],
                                                            ['En attente', 'En préparation', 'En livraison', 'Attente retour matériel', 'Terminée', 'Acceptée', 'Annulée', 'Livrée'],
                                                            $commande['statut'])) ?>
                        </td>
                        <td>
                            <a class="voir-commande-client" href="/commandes/<?= $commande['commande_id'] ?>"><i class="fa-solid fa-eye"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</main>

<?php
$loadScriptJs = 'filtreAdminEmploye.js';
require_once __DIR__ . '/../../views/layout/importJs.php';
require_once __DIR__ . '/../../views/layout/footer.php';
?>
