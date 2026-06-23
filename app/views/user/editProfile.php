<?php
$pageSpecificCss = ['style.css' , 'formulaire.css' , 'layout.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main >
    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message-php text-center mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message-php text-center mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
        
    <div class="d-flex justify-content-center">
        
        <div class="d-flex flex-column justify-content-center form-contact">

            <form action="/profile/edit" method="POST" class="text-center">
                <?= Auth::csrfField() ?>
                <h2 class="mt-3 mb-3 ">Modifier profil</h2>
                

                <label class="form-label" for="email">Email :</label><br>
                <input class="form-control" type="email" name="email" id="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>"><br>

                <label class="form-label" for="name">Nom :</label><br>
                <input  class="form-control" type="text" name="nom" id="nom" value="<?= htmlspecialchars($user['nom'] ?? '') ?>"><br>

                <label class="form-label" for="prenom">Prénom :</label><br>
                <input class="form-control" type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($user['prenom'] ?? '') ?>"><br>

                <label class="form-label" for="gsm">Téléphone :</label><br>
                <input class="form-control" type="text" name="gsm" id="gsm" value="<?= htmlspecialchars($user['gsm'] ?? '') ?>"><br>

                <label class="form-label" for="ville">Ville :</label><br>
                <input class="form-control" type="text" name="ville" id="ville" value="<?= htmlspecialchars($user['ville'] ?? '') ?>"><br>

                <label class="form-label" for="adress">Adresse :</label><br>
                <input class="form-control" type="text" name="adresse" id="adresse" value="<?= htmlspecialchars($user['adresse'] ?? '') ?>"><br>

                <label class="form-label" for="code_postal">Code postal :</label><br>
                <input class="form-control" type="text" name="code_postal" id="code_postal" value="<?= htmlspecialchars($user['code_postal'] ?? '') ?>"><br>
                <p class="error-message mt-1 text-center"></p><br>
                <div class="d-flex justify-content-around">
                    <button class="mt-3 mb-3 btn-form" type="submit">Valider</button>
                    <a class="mb-3 mt-3 btn-annuler" href="/profile">Annuler</a>
                </div>
            </form>
        </div>
    </div>
    
</main>
<?php
$loadScriptJs = 'form.js';
require_once __DIR__ . '/../../views/layout/footer.php';
require_once __DIR__ . '/../../views/layout/importJs.php';
?>