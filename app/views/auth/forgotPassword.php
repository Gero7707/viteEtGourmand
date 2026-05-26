<?php
require_once __DIR__ . '/../../views/layout/header.php';
?>
<main>
    <h1>Réinitialisez votre mot de passe </h1>

    <form action="/auth/forgot-password" method="POST">
        <?= Auth::csrfField() ?>
        <label for="email">Entrez votre email :</label><br>
        <input type="email" name="email" id="email" required><br>
        <button type="submit">Réinitialiser MDP</button>
    </form>
    <?php if ($_GET['error'] ?? null): ?>
        <p><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    
</main>

<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>
