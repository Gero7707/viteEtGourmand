<?php
$pageSpecificCss = ['style.css', 'formulaire.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main class="d-flex justify-content-center">
    <div class="d-flex flex-column justify-content-center form-contact">
        <h3 class="text-center mt-3">Connexion</h3>
        <form action="/auth/login" method="POST" class="text-center">
            <?= Auth::csrfField() ?>
            <label class="mt-3" for="login">Email/Pseudo</label><br>
            <input  type="text" name="login" id="login" required><br>
            <label class="mt-3" for="password">Mot de passe</label><br>
            <input type="password" name="password" id="password" ><br>
            <button class="mt-3" type="submit">Valider</button>
            <?php if ($_GET['error'] ?? null): ?>
                <p class="error-message mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
            <?php endif ?>
            <?php if ($_GET['success'] ?? null): ?>
                <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
            <?php endif ?>
        </form><br>
        <a href="/auth/forgot-password" class="mdp-oublie text-center mb-5">Mot de passe oublié </a>
    </div>
    
    
</main>

<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>