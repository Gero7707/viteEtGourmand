<?php
require_once __DIR__ . '/../../views/layout/header.php';
$pageSpecificCss = ['style.css', 'formulaire.css']; 
?>

<main>
    <a href="/">Accueil</a><br>
    <?php if(isset($_SESSION['utilisateur_id'])): ?>
        <?php if($_SESSION['role_id'] === 1) : ?>
            <a href="/profile">Voir profil</a><br>
        <?php elseif ($_SESSION['role_id'] === 2) :  ?>
        <a href="/commandes-client">Commandes</a><br>
        <a href="/avis-valider">Avis</a><br>
        <a href="/menus">Menus</a><br>
        <a href="/plats">Plats</a><br>
        <a href="/employe/dashboard">Dashboard</a><br>
        <?php elseif ($_SESSION['role_id'] === 3) :  ?>
        <a href="/commandes-client">Commandes</a><br>
        <a href="/avis-valider">Avis</a><br>
        <a href="/menus">Menus</a><br>
        <a href="/plats">Plats</a><br>
        <a href="/admin/dashboard">Dashboard</a><br>
        <?php endif ?>
        <a href="/auth/logout">Déconnexion</a><br>
    <?php endif ?>

    <?php if ($_GET['error'] ?? null): ?>
        <p><?= htmlspecialchars($_GET['error']) ?></p>
    <?php elseif($_GET['success'] ?? null) :?>
        <p><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>
    
    <form action="/contact" method="POST">
        <?= Auth::csrfField() ?>
        <label for="titre">Sujet</label><br>
        <input type="text" id="titre" name="titre" required><br>

        <label for="email">Email</label><br>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required><br>

        <label for="message">Message</label><br>
        <textarea name="message" id="message" rows="5" cols="33" required></textarea>
        <button type="submit">Envoyer</button>
    </form>
    

</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>