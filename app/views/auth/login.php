<?php
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <form action="/auth/login" method="POST">
        <?= Auth::csrfField() ?>
        <label for="login">Email/Pseudo</label><br>
        <input type="text" name="login" id="login" required><br>
        <label for="password">Mot de passe</label><br>
        <input type="password" name="password" id="password" ><br>
        <button type="submit">Valider</button>
    </form><br>
    <a href="/auth/forgotPassword">Mot de passe oublié </a>
    <?php if ($_GET['error'] ?? null): ?>
        <p><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
</main>

<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>