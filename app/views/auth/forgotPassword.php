<?php
$pageSpecificCss = ['style.css' , 'formulaire.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>
<main class="d-flex justify-content-center">
    <div class="d-flex flex-column justify-content-center form-contact">
        <form action="/auth/forgot-password" method="POST" class="text-center">
            <h3 class="text-center mt-3">Réinitialisez votre <br> mot de passe </h3>

            <?= Auth::csrfField() ?>

            <?php if ($_GET['error'] ?? null): ?>
                <p class="error-message mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
            <?php endif ?>
            <?php if ($_GET['success'] ?? null): ?>
                <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
            <?php endif ?>
            
            <label class="mt-3" for="email">Entrez votre email :</label><br>
            <input class="mt-3" type="email" name="email" id="email" required><br>
            <button class="mt-3 mb-5 btn-form" type="submit">Réinitialiser MDP</button>
        </form>
    </div>
    

    
    <?php if ($_GET['error'] ?? null): ?>
        <p><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <p class="error-message mt-1 text-center"></p><br>
</main>

<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>
