<?php
$pageSpecificCss = ['style.css', 'formulaire.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <div  class="d-flex justify-content-center">
        <div class="d-flex flex-column justify-content-center form-contact">
            <h3 class="text-center mt-3">Connexion</h3>
            <form action="/auth/login" method="POST" class="text-center">
                <?= Auth::csrfField() ?>
                <label class="form-label" for="login">Email/Pseudo</label><br>
                <input class="form-control"  type="text" name="login" id="login" required><br>
                
                <label class="form-label" class="mt-3" for="password">Mot de passe</label><br>
                <input class="form-control" type="password" name="password" id="password" ><br>
                <a class="annuler" href="/">Annuler</a><br>
                <button class="mt-3 btn-form" type="submit">Valider</button>
            </form><br>
            <a href="/auth/forgot-password" class="mdp-oublie text-center mb-5">Mot de passe oublié </a>
        </div>
    </div>
    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message-php text-center mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message-php text-center mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
    <p class="error-message mt-1 text-center"></p><br>
</main>

<?php
$loadScriptJs = 'form.js';
require_once __DIR__ . '/../../views/layout/importJs.php';
?>