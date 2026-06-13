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
    <hr>
    <div class="d-flex justify-content-around">
        <a href="/employe/dashboard" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Dashoard</a><br>
        <a href="/commandes-client" class="text-centerfw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Commandes</a><br>
        <a href="/avis-valider" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Avis</a><br>
        <a href="/menus" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Menus</a><br>
        <a href="/create-menu" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Créer un menu</a><br>
        <a href="/plats" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Plats</a><br>
        <a href="/plats/create" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Créer un plat</a><br>
        <a href="/changer-horaire" class="fw-mediumbold bg-secondary text-primary lien-intro-entreprise ">Changer horaire</a><br>
    </div>

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
                        <td><?= htmlspecialchars($commande['date_prestation']) ?></td>
                        <td><?= htmlspecialchars($commande['nombre_personne']) ?></td>
                        <td><?= htmlspecialchars($commande['statut']) ?></td>
                        <td>
                            <a class="voir-commande-client" href="/commandes/<?= $commande['commande_id'] ?>"><i class="fa-solid fa-eye"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</main>
