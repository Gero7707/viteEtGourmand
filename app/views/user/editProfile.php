<?php
$pageSpecificCss = ['style.css' , 'formulaire.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main class="d-flex justify-content-center">
    <div class="d-flex flex-column justify-content-center form-contact">
        <form action="/profile/edit" method="POST" class="text-center">
            <?= Auth::csrfField() ?>
            <h3 class="mt-3 mb-3 ">Modifier profil</h3>
            <?php if ($_GET['error'] ?? null): ?>
            <p class="error-message mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
            <?php endif ?>
            <?php if ($_GET['success'] ?? null): ?>
                <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
            <?php endif ?>

            <label class="mt-3" for="email">Email</label><br>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>"><br>

            <label class="mt-3" for="name">Nom</label><br>
            <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($user['nom'] ?? '') ?>"><br>

            <label class="mt-3" for="prenom">Prénom</label><br>
            <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($user['prenom'] ?? '') ?>"><br>

            <label class="mt-3" for="gsm">Téléphone</label><br>
            <input type="text" name="gsm" id="gsm" value="<?= htmlspecialchars($user['gsm'] ?? '') ?>"><br>

            <label class="mt-3" for="ville">Ville</label><br>
            <input type="text" name="ville" id="ville" value="<?= htmlspecialchars($user['ville'] ?? '') ?>"><br>

            <label class="mt-3" for="adress">Adresse</label><br>
            <input type="text" name="adresse" id="adresse" value="<?= htmlspecialchars($user['adresse'] ?? '') ?>"><br>

            <label class="mt-3" for="code_postal">Code postal</label><br>
            <input type="text" name="code_postal" id="code_postal" value="<?= htmlspecialchars($user['code_postal'] ?? '') ?>"><br>

            <div class="d-flex justify-content-around">
                <button class="mt-3 mb-3" type="submit">Valider</button>
                <a class="mb-3 mt-3 btn-annuler" href="/profile">Annuler</a>
            </div>
        </form>
    </div>
    
</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>