<?php
$pageSpecificCss = ['style.css' , 'layout.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <div class="suppress-container">
        <h2 class="text-center">Suppression de compte</h2>
        <p class="text-center">Vous êtes sur le point de supprimer votre profil .</p>
        <p class="text-center"> Etes vous vraiment sur de vouloir supprimer votre compte?</p>
        <button id="confirmer" class="form-control">Supprimer votre compte</button>
        <a class="form-control text-center annuler-suppress" href="/profile">Annuler</a>
    </div>
    <div class="suppress-modal suppress">
        <h2 class="text-center">Suppression de compte</h2>
        <p class="text-center">Cette action est irréversible , vous ne pourrez plus accéder à votre historique d'achat.</p>
        <p class="text-center"> Etes vous vraiment sur de vouloir supprimer votre compte?</p>
        <form action="/auth/delete-account" method="POST">
            <?= Auth::csrfField() ?>
            <button class=" form-control" type="submit">Oui je suis sûr</button>
        </form>
        <a class="form-control text-center annuler-suppress" href="/profile">Annuler</a>
    </div>
</main>
<?php
$loadScriptJs = 'cta.js';
require_once __DIR__ . '/../../views/layout/importJs.php';
require_once __DIR__ . '/../../views/layout/footer.php';
?>
