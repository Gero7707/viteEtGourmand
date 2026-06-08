<?php
$pageSpecificCss = ['style.css', 'formulaire.css']; 

require_once __DIR__ . '/../../views/layout/header.php';
?>

<main class="d-flex justify-content-around display">
    <div class="img-contact">
        <img  src="/assets/img/menus/table.jpg" alt="">
    </div>

    <div class="d-flex flex-column justify-content-center form-contact mt-5">
        <h3 class="text-center">Formuliare de contact</h3>
        <form action="/contact" method="POST" class="text-center">
            <?= Auth::csrfField() ?>

            <?php if ($_GET['error'] ?? null): ?>
            <p class="error-message mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
            <?php endif ?>
            <?php if ($_GET['success'] ?? null): ?>
                <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
            <?php endif ?>

            <label class="mt-3" for="titre">Sujet</label><br>
            <input type="text" id="titre" name="titre" required><br>

            <label class="mt-5"  for="email">Email</label><br>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required><br>

            <label class="mt-5" for="message">Message</label><br>
            <textarea name="message" id="message" required></textarea><br>
            <button class="mt-5 mb-3" type="submit">Envoyer</button>
        </form>
    </div>
    <div class="img-contact">
        <img  src="/assets/img/menus/fiesta.jpg" alt="">
    </div>

</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>