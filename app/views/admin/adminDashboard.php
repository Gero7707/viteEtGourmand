<?php
require_once __DIR__ . '/../../views/layout/header.php';
?>
<main>
    <div class="text-center mt-2 intro">
        <p class="fw-mediumbold text-center">Bonjour  <?= $_SESSION['prenom'] ?>  !</p><br>
    </div>
    <hr>
    <?php if ($_GET['error'] ?? null): ?>
        <p><?= htmlspecialchars($_GET['error']) ?></p><br>
        <hr>
    <?php elseif($_GET['success'] ?? null) :?>
        <p><?= htmlspecialchars($_GET['success']) ?></p><br>
        <hr>
    <?php endif ?>
    <a href="/">Voir accueil</a><br>
    <a href="/commandes-client">Commandes</a><br>
    <a href="/avis-valider">Avis</a><br>
    <a href="/menus">Menus</a><br>
    <a href="/create-menu">Créer un menu</a><br>
    <a href="/plats">Plats</a><br>
    <a href="/changer-horaire">Changer horaire</a><br>
    <a href="/admin/employe-register">Créer compte employé</a>
    <hr>
    <h1>Dashboard de l'Administrateur</h1>
    <h4>Employés</h4>
    <table>
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
                        <a href="/admin/update-employe/<?= htmlspecialchars($employe['utilisateur_id']) ?>">Modifier profil</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <section>
        <h2>Stats</h2>
    </section>
</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>