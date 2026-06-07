<?php
$pageSpecificCss = 'style.css';
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
    <div class="text-center mt-2 intro">
        <p class="fw-mediumbold text-center">Bonjour  <?= $_SESSION['prenom'] ?>  !</p><br>
    </div>
    <hr>
    <a href="/">Voir accueil</a><br>
    <a href="/commandes-client">Commandes</a><br>
    <a href="/avis-valider">Avis</a><br>
    <a href="/menus">Menus</a><br>
    <a href="/create-menu">Créer un menu</a><br>
    <a href="/plats">Plats</a><br>
    <a href="/plats/create">Créer un plat</a><br>
    <a href="/changer-horaire">Changer horaire</a><br>
</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>