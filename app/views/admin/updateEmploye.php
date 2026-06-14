<?php
$pageSpecificCss = ['style.css' , 'formulaire.css'];
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
            <h3 class="text-center">Modifier profil employé</h3>
            <form action="/admin/update-employe/<?= htmlspecialchars($user['utilisateur_id']) ?>" method="POST" class="text-center">
                <?= Auth::csrfField() ?>

                <label class="form-label" for="email">Email</label><br>
                <input class="form-control" type="email" name="email" id="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>"><br>

                <label  class="form-label" for="name">Nom</label><br>
                <input  class="form-control" type="text" name="nom" id="nom" value="<?= htmlspecialchars($user['nom'] ?? '') ?>"><br>

                <label  class="form-label" for="prenom">Prénom</label><br>
                <input  class="form-control" type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($user['prenom'] ?? '') ?>"><br>

                <label  class="form-label" for="gsm">Téléphone</label><br>
                <input  class="form-control" type="text" name="gsm" id="gsm" value="<?= htmlspecialchars($user['gsm'] ?? '') ?>"><br>

                <label  class="form-label" for="ville">Ville</label><br>
                <input  class="form-control" type="text" name="ville" id="ville" value="<?= htmlspecialchars($user['ville'] ?? '') ?>"><br>

                <label  class="form-label" for="adress">Adresse</label><br>
                <input  class="form-control" type="text" name="adresse" id="adresse" value="<?= htmlspecialchars($user['adresse'] ?? '') ?>"><br>

                <label  class="form-label" for="code_postal">Code postal</label><br>
                <input  class="form-control" type="text" name="code_postal" id="code_postal" value="<?= htmlspecialchars($user['code_postal'] ?? '') ?>"><br>

                <div >
                    <a class="annuler" href="/admin/dashboard">Annuler</a><br>
                    <button class="btn-form mb-5" type="submit">Valider</button>
                    
                </div>
            </form>
        </div>
    </div>
    <p class="error-message mt-1 text-center"></p><br>
</main>
<?php
$loadScriptJs = 'form.js';
require_once __DIR__ . '/../../views/layout/importJs.php';
?>