<?php
require_once __DIR__ . '/../../views/layout/header.php';
?>
<main>
    <form action="/auth/register" method="POST">
        <?= Auth::csrfField() ?>
        <label for="email">Email</label><br>
        <input type="email" name="email" id="email" required><br>

        <label for="nom">Nom</label><br>
        <input type="text" name="nom" id="nom" required><br>

        <label for="prenom">Prénom</label><br>
        <input type="text" name="prenom" id="prenom" required><br>

        <label for="password">Mot de passe</label><br>
        <input type="password" name="password" id="password" required><br>
        
        <label for="password_confirm">Confirmer le mot de passe</label><br>
        <input type="password" name="password_confirm" id="password_confirm" required><br>

        <button type="submit">Créer votre compte</button>
    </form>
    <?php if ($_GET['error'] ?? null): ?>
        <p><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>