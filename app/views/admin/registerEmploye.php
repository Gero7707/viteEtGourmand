<?php
$pageSpecificCss = ['style.css' , 'formulaire.css' , 'layout.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    
    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message-php text-center mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message-php text-center mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
    <div  class="d-flex justify-content-center ">
        <div class="d-flex flex-column justify-content-center form-contact mt-5">
            <h3 class="text-center">Créer un compte employé</h3>
            <form action="/admin/employe-register" method="POST" class="text-center">
                <?= Auth::csrfField() ?>
                <label class="form-label"  for="email">Email</label><br>
                <input class="form-control " type="email" name="email" id="email" required><br>

                <label class="form-label" for="nom">Nom</label><br>
                <input class="form-control" type="text" name="nom" id="nom" required><br>

                <label class="form-label" for="prenom">Prénom</label><br>
                <input class="form-control" type="text" name="prenom" id="prenom" required><br>

                <label class="form-label" for="password">Mot de passe</label><br>
                <input class="form-control" type="password" name="password" id="password" required><br>
                
                <label class="form-label" for="password_confirm">Confirmer le mot de passe</label><br>
                <input class="form-control" type="password" name="password_confirm" id="password_confirm" required><br>

                <label class="form-label" for="gsm">Téléphone</label><br>
                <input class="form-control" type="text" name="gsm" id="gsm" required><br>

                <label class="form-label" for="ville">Ville</label><br>
                <input class="form-control" type="text" name="ville" id="ville" required><br>

                <label class="form-label" for="adresse">Adresse</label><br>
                <input class="form-control" type="text" name="adresse" id="adresse" required><br>

                <label class="form-label" for="code_postal">Code Postal</label><br>
                <input class="form-control mb-5" type="text" name="code_postal" id="code_postal" required>
                <p class="error-message mt-1 text-center"></p><br>
                <a class="annuler" href="/admin/dashboard">Annuler</a><br>
                <button class="btn-form mb-5" type="submit">Créer compte</button>
            </form>
        </div>
    </div>
    <p class="error-message mt-1 text-center"></p><br>
</main>
<?php
$loadScriptJs = 'form.js';
require_once __DIR__ . '/../../views/layout/importJs.php';
require_once __DIR__ . '/../../views/layout/footer.php';
?>