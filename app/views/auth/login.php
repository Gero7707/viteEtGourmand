<?php
$pageTitle = "Connexion — Vite & Gourmand";
$pageSpecificCss = ['style.css', 'formulaire.css' , 'layout.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <div  class="d-flex justify-content-center">
        <div class="d-flex flex-column justify-content-center form-contact">
            <h2 class="text-center mt-3">Connexion</h2>
            <form action="/auth/login" method="POST" class="text-center validate-form">
                <?= Auth::csrfField() ?>
                <label class="form-label" for="login">Email/Pseudo</label><br>
                <input class="form-control"  type="text" name="login" id="login" required><br>
                
                
                <div class="d-flex password justify-content-center">
                    <label class="form-label mt-3"for="password">Mot de passe</label><br>
                    <button type="button" class="btn-password" data-target="password" aria-label="Voir le mot de passe"><i class="fa-regular fa-eye"></i></button><br>
                </div>
                <input class="form-control" type="password" name="password" id="password">
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
require_once __DIR__ . '/../../views/layout/footer.php';
?>