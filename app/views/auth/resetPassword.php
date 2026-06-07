<?php
$pageSpecificCss = ['style.css' , 'formulaire.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main class="d-flex justify-content-center">
    <div class="d-flex flex-column justify-content-center form-contact">

        <form action="/auth/reset-password" method="POST" class="text-center">
        <h1 class="text-center ">Votre nouveau mot de passe </h1>
            <?= Auth::csrfField() ?>
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

            <label class="mt-3" for="password">Nouveau mot de passe</label><br>
            <input  type="password" name="password" id="password" required><br>

            <label class="mt-3"  for="password_confirm">Confirmer le mot de passe</label><br>
            <input type="password" name="password_confirm" id="password_confirm"><br>

            <button class="mt-3 mb-3"  type="submit">Valider</button>
            <?php if ($_GET['error'] ?? null): ?>
                <p class="error-message mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
            <?php endif ?>
            <?php if ($_GET['success'] ?? null): ?>
                <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
            <?php endif ?>
        </form>
        
    </div>
    
    <
</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>