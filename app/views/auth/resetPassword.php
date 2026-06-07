<?php
$pageSpecificCss = 'style.css';
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <h1>Votre nouveau mot de passe </h1>

    <form action="/auth/reset-password" method="POST">
        <?= Auth::csrfField() ?>
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <label for="password">Nouveau mot de passe</label><br>
        <input type="password" name="password" id="password" required><br>
        <label for="password_confirm">Confirmer le mot de passe</label><br>
        <input type="password" name="password_confirm" id="password_confirm"><br>
        <button type="submit">Valider</button>
    </form>
    <?php if ($_GET['error'] ?? null): ?>
        <p><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>