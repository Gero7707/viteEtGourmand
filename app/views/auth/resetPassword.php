<?php
$pageSpecificCss = ['style.css' , 'formulaire.css' , 'layout.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <div class="d-flex justify-content-center">
        <div class="d-flex flex-column justify-content-center form-contact mt-5">
            <h2 class="text-center ">Votre nouveau mot de passe </h2>
            <form action="/auth/reset-password" method="POST" class="text-center mt-5 validate-form">
            
                <?= Auth::csrfField() ?>
                <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                <div class="d-flex password justify-content-center">
                    <label class="form-label" for="password">Nouveau mot de passe</label><br>
                    <button type="button" class="btn-password" data-target="password" aria-label="Voir le mot de passe"><i class="fa-regular fa-eye"></i></button><br>
                </div>
                <input  class="form-control"  type="password" name="password" id="password" required><br>

                <div class="d-flex password justify-content-center">
                    <label class="form-label" class="mt-3"  for="password_confirm">Confirmer le mot de passe</label><br>
                    <button type="button" class="btn-password" data-target="password_confirm" aria-label="Voir le mot de passe"><i class="fa-regular fa-eye"></i></button><br>
                </div>
                <input class="form-control" type="password" name="password_confirm" id="password_confirm"><br>

                <button class="mt-3 mb-3 btn-form"  type="submit">Valider</button>
                
            </form>
            
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