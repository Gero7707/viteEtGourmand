<?php
$pageSpecificCss = ['style.css' , 'formulaire.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>
<main >
    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
    <div class="d-flex justify-content-center ">
        <div class="d-flex flex-column justify-content-center form-contact mt-5">
            <h3 class="text-center mt-3">Réinitialisez votre mot de passe </h3>
            <form action="/auth/forgot-password" method="POST" class="text-center mt-5">
                <?= Auth::csrfField() ?>
                <label class="form-label" for="email">Entrez votre email :</label><br>
                <input class="form-control" type="email" name="email" id="email" required><br>
                <button class="mt-3 mb-5 btn-form" type="submit">Réinitialiser MDP</button>
            </form>
        </div>
    </div>
    <p class="error-message mt-1 text-center"></p><br>
</main>

<?php
$loadScriptJs = 'form.js';
require_once __DIR__ . '/../../views/layout/importJs.php';
?>
