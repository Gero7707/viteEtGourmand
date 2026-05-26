<?php
require_once __DIR__ . '/../../views/layout/header.php';
?>
<a href="/auth/logout">Déconnexion</a>
<main>
    <h1>Dashboard de l'Administrateur</h1>
    <table>
        <thead>
            <tr>
                <th>Pseudo</th>
                <th>Email</th>
                <th>Role</th>
                <th>Date de création</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user) : ?>
                <tr>
                    <td><?= htmlspecialchars($user['pseudo']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>