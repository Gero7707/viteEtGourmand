<?php
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <p>Bonjour  <?= $_SESSION['prenom'] ?>  !</p><br>
    <hr>
    <a href="/commandes-client">Commandes</a><br>
    <a href="/avis-valider">Avis</a><br>
    <a href="/menus">Menus</a><br>
    <a href="/plats">Plats</a><br>
</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>