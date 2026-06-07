<?php
$pageSpecificCss = 'style.css';
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <a href="/admin/dashboard">Dashboard</a><br>
    <hr>
    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>

    <h4>Créer un compte employé</h4>
    <form action="/admin/employe-register" method="POST">
        <?= Auth::csrfField() ?>
        <label for="email">Email</label><br>
        <input type="email" name="email" id="email" required><br>

        <label for="nom">Nom</label><br>
        <input type="text" name="nom" id="nom" required><br>

        <label for="prenom">Prénom</label><br>
        <input type="text" name="prenom" id="prenom" required><br>

        <label for="password">Mot de passe</label><br>
        <input type="password" name="password" id="password" required><br>
        
        <label for="password_confirm">Confirmer le mot de passe</label><br>
        <input type="password" name="password_confirm" id="password_confirm" required><br>

        <label for="gsm">Téléphone</label><br>
        <input type="text" name="gsm" id="gsm" required><br>

        <label for="ville">Ville</label><br>
        <input type="text" name="ville" id="ville" required><br>

        <label for="adresse">Adresse</label><br>
        <input type="text" name="adresse" id="adresse" required><br>

        <label for="code_postal">Code Postal</label><br>
        <input type="text" name="code_postal" id="code_postal" required>

        <button type="submit">Créer compte</button>
    </form>
    
</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>