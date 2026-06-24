<?php
$pageSpecificCss = ['style.css' , 'layout.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main class="suppress-container">
    <h2 class="text-center">Suppression de compte</h2>
    <p>Vous êtes sur le point de supprimer votre profil .</p>
    <p> Etes vous vraiment sur de vouloir supprimer votre compte?</p>
    <form action="/auth/delete-account" method="POST">
        <?= Auth::csrfField() ?>
        <button form-control class=" form-control" type="submit">Supprimer votre compte</button>
    </form>
</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>
