<?php
$pageDescription = "Si vous avez des questions sur nos menus et nos prestations, contactez-nous";
$pageTitle = "Contact — Vite & Gourmand";
$pageSpecificCss = ['style.css', 'formulaire.css' , 'layout.css']; 

require_once __DIR__ . '/../../views/layout/header.php';
?>

<main class="main-message">
    <p class="error-message mt-1 text-center"></p><br>
    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message-php text-center mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message-php text-center mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
    <div  class="d-flex justify-content-center">
        <div class="d-flex flex-column justify-content-center form-contact ">
            
            <h2 class="text-center">Formuliare de contact</h2>
            <form action="/contact" method="POST" class="text-center validate-form">
                <?= Auth::csrfField() ?>

                <label class="form-label" for="titre">Sujet :</label><br>
                <input class="form-control" type="text" id="titre" name="titre" required><br>

                <label class="form-label"  for="email">Email :</label><br>
                <input class="form-control" type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required><br>

                <label class="form-label" for="message">Message :</label><br>
                <textarea name="message" id="message" required></textarea><br><br>
                <a class="annuler" href="/">Annuler</a><br>
                <button class=" mb-3 btn-form" type="submit">Envoyer</button>
            </form>
        </div>
    </div>
</main>
<?php
$loadScriptJs = 'form.js';
require_once __DIR__ . '/../../views/layout/importJs.php';
require_once __DIR__ . '/../../views/layout/footer.php';
?>