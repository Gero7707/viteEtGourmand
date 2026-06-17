<?php
$pageSpecificCss = ['style.css','formulaire.css' , 'layout.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>
<main>
    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message-php text-center mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message-php text-center mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
    <p class="error-message mt-1 text-center"></p><br>
    <div  class="d-flex justify-content-center">
        <div class="d-flex flex-column justify-content-center form-contact">
            <h3 class="text-center mt-3">Créer votre compte</h3>
            <form action="/auth/register" method="POST" class="text-center">
                
                <?= Auth::csrfField() ?>

                <label class="form-label" for="email">Email</label><br>
                <input class="form-control" type="email" name="email" id="email" required><br>

                <label class="form-label" class="mt-3" for="nom">Nom</label><br>
                <input class="form-control"  type="text" name="nom" id="nom" required><br>

                <label class="form-label" class="mt-3" for="prenom">Prénom</label><br>
                <input class="form-control"  type="text" name="prenom" id="prenom" required><br>

                <label class="form-label" class="mt-3" for="password">Mot de passe</label><br>
                <input class="form-control"  type="password" name="password" id="password" required><br>
                
                <label class="form-label" class="mt-3" for="password_confirm">Confirmer le mot de passe</label><br>
                <input class="form-control"  type="password" name="password_confirm" id="password_confirm" required><br>

                <label class="form-label" class="mt-3 texte-check" for="rgpd"><input type="checkbox" name="rgpd" id="rgpd" required>J'accepte que mes données personnelles <br> soient collectées et traitées conformément à notre <br>
                    <a href="/mentions-legales">politique de confidentialité</a>
                </label><br>
                <a class="annuler" href="/">Annuler</a><br>
                <button class="mt-3 mb-3 btn-form" type="submit">Créer votre compte</button>
            </form>
        </div>
    </div>
    
</main>
<?php
$loadScriptJs = 'form.js';
require_once __DIR__ . '/../../views/layout/importJs.php';
require_once __DIR__ . '/../../views/layout/footer.php';
?>