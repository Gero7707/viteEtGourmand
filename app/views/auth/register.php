<?php
$pageSpecificCss = ['style.css','formulaire.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>
<main>
    <div  class="d-flex justify-content-center">
        <div class="d-flex flex-column justify-content-center form-contact">
            <form action="/auth/register" method="POST" class="text-center">
                <h3 class="text-center mt-3">Créer votre compte</h3>
                <?= Auth::csrfField() ?>

                <label class="mt-3" for="email">Email</label><br>
                <input type="email" name="email" id="email" required><br>

                <label class="mt-3" for="nom">Nom</label><br>
                <input type="text" name="nom" id="nom" required><br>

                <label class="mt-3" for="prenom">Prénom</label><br>
                <input type="text" name="prenom" id="prenom" required><br>

                <label class="mt-3" for="password">Mot de passe</label><br>
                <input type="password" name="password" id="password" required><br>
                
                <label class="mt-3" for="password_confirm">Confirmer le mot de passe</label><br>
                <input type="password" name="password_confirm" id="password_confirm" required><br>

                <label class="mt-3 texte-check" for="rgpd"><input type="checkbox" name="rgpd" id="rgpd" required>J'accepte que mes données personnelles <br> soient collectées et traitées conformément à notre <br>
                    <a href="/mentions-legales">politique de confidentialité</a>
                </label><br>

                <button class="mt-3 mb-3 btn-form" type="submit">Créer votre compte</button>
            </form>
        </div>
    </div>
        
    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message-php mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message-php mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
    <p class="error-message mt-1 text-center"></p><br>
</main>
<?php
$loadScriptJs = 'form.js';
require_once __DIR__ . '/../../views/layout/footer.php';
?>