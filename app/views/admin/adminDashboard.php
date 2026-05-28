<?php
require_once __DIR__ . '/../../views/layout/header.php';
?>
<a href="/auth/logout">Déconnexion</a>
<main>
    <p>Bonjour  <?= $_SESSION['prenom'] ?>  !</p><br>
    <hr>
    <a href="/commandes-client">Commandes</a><br>
    <a href="/avis-valider">Avis</a><br>
    <a href="/menus">Menus</a><br>
    <a href="/plats">Plats</a><br>
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
                        action désactiver 
                    </td>
                    <td>
                        action modifier
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