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
    
    <div class="d-flex justify-content-around d-none d-md-flex">
        <a href="/admin/dashboard" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Dashoard</a><br>
                <a href="/commandes-client" class="text-centerfw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Commandes</a><br>
                <a href="/avis-valider" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Avis</a><br>
                <a href="/menus" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Menus</a><br>
                <a href="/plats" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Plats</a><br>
                <a href="/changer-horaire" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Horaires</a><br>
    </div>
    <hr>

    <section class="admin-dashboard mb-5">
        <h2 class="text-center mb-3">Employés</h2>
        <a href="/admin/employe-register" class="creer-employe">Créer compte employé</a>
            <table class="tableau-dashboard-admin mt-4 mb-4">
                <thead>
                    <tr>
                        <th class="col-desktop">Nom</th>
                        <th>Prénom</th>
                        <th  class="col-desktop">Email</th>
                        <th>Téléphone</th>
                        <th class="col-desktop">Ville</th>
                        <th class="col-desktop">Actif</th>
                        <th></th>
                        <th>Modif</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($employes as $employe) : ?>
                        <tr>
                            <td class="col-desktop"><?= htmlspecialchars($employe['nom']) ?></td>
                            <td><?= htmlspecialchars($employe['prenom']) ?></td>
                            <td class="col-desktop"><?= htmlspecialchars($employe['email']) ?></td>
                            <td><?= htmlspecialchars($employe['gsm'] ?? '') ?></td>
                            <td class="col-desktop"><?= htmlspecialchars($employe['ville'] ?? '') ?></td>
                            <td class="col-desktop"><?= $employe['actif'] ? 'Oui' : 'Non' ?></td>
                            <td>
                                <?php if($employe['actif'] === 1) : ?>
                                    <form action="/admin/desactiver/<?= htmlspecialchars($employe['utilisateur_id']) ?>" method="POST">
                                        <?= Auth::csrfField() ?>
                                        <button aria-label="Désactiver l'employé"  type="submit"><i class="fa-solid fa-toggle-on" aria-hidden="true"></i></button>
                                    </form>
                                <?php elseif($employe['actif'] === 0) : ?>
                                    <form action="/admin/activer/<?= htmlspecialchars($employe['utilisateur_id']) ?>" method="POST">
                                        <?= Auth::csrfField() ?>
                                        <button aria-label="Activer l'employé"  type="submit"><i class="fa-solid fa-toggle-off" aria-hidden="true" ></i></button>
                                    </form>
                                <?php endif ?>
                            </td>
                            <td>
                                <a aria-label="Modifier profil employé" class="modif-profil-employe px-2" href="/admin/update-employe/<?= htmlspecialchars($employe['utilisateur_id']) ?>"><i aria-hidden="true" class="fa-solid fa-pencil"></i></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
    </section>
    <hr>
    <div class="text-center input-select mt-5">
        <label for="statut">Filtrer par statut :</label>
        <select name="statut" id="statut">
            <option value="actives">Commandes actives</option>
            <option value="en_attente">En attente</option>
            <option value="acceptee">Acceptée</option>
            <option value="en_preparation">En préparation</option>
            <option value="en_livraison">En livraison</option>
            <option value="livree">Livrée</option>
            <option value="attente_retour_materiel">Attente retour matériel</option>
            <option value="terminee">Terminee</option>
            <option value="annulee">Annulée</option>
        </select>
    </div>

    <div class="dashboard-commandes mt-4 mb-4">
        <h2 class="text-center mb-4">Commandes Clients</h2>
        <table class="tableau-commande-entreprise">
            <thead>
                <tr>
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
                        <td class="col-desktop"><?= date('d/m/Y', strtotime($commande['date_prestation']) )?></td>
                        <td class="col-desktop"><?= htmlspecialchars($commande['nombre_personne']) ?></td>
                        <td class="col-desktop"><?= htmlspecialchars(str_replace(['en_attente', 'en_preparation', 'en_livraison', 'attente_retour_materiel', 'terminee', 'acceptee', 'annulee', 'livree'],
                                                            ['En attente', 'En préparation', 'En livraison', 'Attente retour matériel', 'Terminée', 'Acceptée', 'Annulée', 'Livrée'],
                                                            $commande['statut'])) ?>
                        </td>
                        <td>
                            <a aria-label="Voir la commande" class="voir-commande-client" href="/commandes/<?= $commande['commande_id'] ?>"><i aria-hidden="true" class="fa-solid fa-eye"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    
    <section class="mt-5 mb-1 section-graphique">
        <h2 class="text-center">Statistiques</h2>
        <h3 class="text-center">Commandes par menu :</h3>
        <div class="conteneur-graphique">
            <canvas id="graphiqueCommandes" data-commandes="<?= htmlspecialchars(json_encode($commandesParMenu)) ?>"></canvas>
        </div>
        
    </section>

    <section class="section-chiffre-affaire mb-5 p-5">
        <h3 class="text-center">Chiffre d'affaires :</h3>
        <form method="GET" action="/admin/dashboard" class="d-flex flex-column align-items-center" id="formulaire-ca">
            <label for="filtre-menu">Menu : </label>
            <select name="menu" id="filtre-menu">
                <option value="">Tous les menus</option>
                <?php foreach($caParMenu as $ligne) : ?>
                    <option value="<?= htmlspecialchars($ligne['_id']) ?>"
                        <?= ($_GET['menu'] ?? '') === $ligne['_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($ligne['_id']) ?>
                    </option>
                <?php endforeach ?>
            </select>
            <label for="filtre-mois">Mois :</label>
            <input type="month" name="mois" id="filtre-mois" value="<?= htmlspecialchars($_GET['mois'] ?? '') ?>">
            <label for="date_debut">Début :</label>
            <input type="date" name="date_debut" id="date_debut">
            <label for="date_fin">Fin :</label>
            <input type="date" name="date_fin" id="date_fin">

            <button class="filtre-ca" type="submit">Filtrer</button>
            <button  class="lien-reset" type="button">Réinitialiser</button>
        </form>
        <p class="error-message mt-1 text-center"></p>
        <table>
            <caption class="visually-hidden">Chiffre d'affiares par menu</caption>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Chiffre d'affaires (€)</th>
                </tr>
            </thead>
            <tbody id="tbody-ca">
                <?php foreach($caParMenu as $ligne) : ?>
                    <tr>
                        <td><?= htmlspecialchars($ligne['_id']) ?></td>
                        <td><?= number_format($ligne['ca'], 2, ',', ' ') ?> €</td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </section>
        
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</main>

<?php
$loadScriptJs = ['filtreAdminEmploye.js' , 'graphiques.js'];
require_once __DIR__ . '/../../views/layout/importJs.php';
require_once __DIR__ . '/../../views/layout/footer.php';
?>
