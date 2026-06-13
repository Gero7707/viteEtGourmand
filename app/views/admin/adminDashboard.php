<?php
$pageSpecificCss = 'style.css';
require_once __DIR__ . '/../../views/layout/header.php';
?>
<main>
    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message text-center mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message text-center mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
    <div class="text-center mt-2 intro">
        <p class="fw-mediumbold text-center">Bonjour  <?= $_SESSION['prenom'] ?>  !</p><br>
    </div>

    <div class="d-flex justify-content-around">
        <a href="/admin/dashboard" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Dashoard</a><br>
        <a href="/commandes-client" class="text-centerfw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Commandes</a><br>
        <a href="/avis-valider" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Avis</a><br>
        <a href="/menus" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Menus</a><br>
        <a href="/create-menu" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Créer un menu</a><br>
        <a href="/plats" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Plats</a><br>
        <a href="/plats/create" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Créer un plat</a><br>
        <a href="/changer-horaire" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Changer horaire</a><br>
    </div>
    <section class="admin-dashboard">
        <h4 class="text-center mb-3">Employés</h4>
            <table class="tableau-dashboard-admin">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Ville</th>
                        <th>Actif</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($employes as $employe) : ?>
                        <tr>
                            <td><?= htmlspecialchars($employe['nom']) ?></td>
                            <td><?= htmlspecialchars($employe['prenom']) ?></td>
                            <td><?= htmlspecialchars($employe['email']) ?></td>
                            <td><?= htmlspecialchars($employe['gsm'] ?? '') ?></td>
                            <td><?= htmlspecialchars($employe['ville'] ?? '') ?></td>
                            <td><?= $employe['actif'] ? 'Oui' : 'Non' ?></td>
                            <td>
                                <?php if($employe['actif'] === 1) : ?>
                                    <form action="/admin/desactiver/<?= htmlspecialchars($employe['utilisateur_id']) ?>" method="POST">
                                        <?= Auth::csrfField() ?>
                                        <button type="submit">Desactiver</button>
                                    </form>
                                <?php elseif($employe['actif'] === 0) : ?>
                                    <form action="/admin/activer/<?= htmlspecialchars($employe['utilisateur_id']) ?>" method="POST">
                                        <?= Auth::csrfField() ?>
                                        <button type="submit">Activer</button>
                                    </form>
                                <?php endif ?>
                            </td>
                            <td>
                                <a class="modif-profil-employe" href="/admin/update-employe/<?= htmlspecialchars($employe['utilisateur_id']) ?>">Modifier profil</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
    </section>

    <div class="dashboard-commandes mt-4">
        <h4 class="text-center mb-4">Commandes Clients</h4>
        <table class="tableau-commande-entreprise">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Nom Client</th>
                    <th>Date prestation</th>
                    <th>Nombre</th>
                    <th>Statut</th>
                    <th>Voir</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($commandes as $commande) : ?>
                    <tr>
                        <td><?= htmlspecialchars($commande['titre']) ?></td>
                        <td><?= htmlspecialchars($commande['nom_complet']) ?></td>
                        <td><?= date('d/m/Y', strtotime($commande['date_prestation']) )?></td>
                        <td><?= htmlspecialchars($commande['nombre_personne']) ?></td>
                        <td><?= htmlspecialchars(str_replace('_', ' ',ucfirst($commande['statut']) ))?></td>
                        <td>
                            <a class="voir-commande-client" href="/commandes/<?= $commande['commande_id'] ?>"><i class="fa-solid fa-eye"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    
    <section>
        <h2>Stats</h2>
    </section>
</main>
