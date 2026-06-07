<?php
$pageSpecificCss = 'style.css';
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <form action="/admin/update-employe/<?= htmlspecialchars($user['utilisateur_id']) ?>" method="POST">
        <?= Auth::csrfField() ?>

        <?php if ($_GET['error'] ?? null): ?>
            <p class="error-message mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
        <?php endif ?>
        <?php if ($_GET['success'] ?? null): ?>
            <p class="success-message mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
        <?php endif ?>

        <label for="email">Email</label><br>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>"><br>

        <label for="name">Nom</label><br>
        <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($user['nom'] ?? '') ?>"><br>

        <label for="prenom">Prénom</label><br>
        <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($user['prenom'] ?? '') ?>"><br>

        <label for="gsm">Téléphone</label><br>
        <input type="text" name="gsm" id="gsm" value="<?= htmlspecialchars($user['gsm'] ?? '') ?>"><br>

        <label for="ville">Ville</label><br>
        <input type="text" name="ville" id="ville" value="<?= htmlspecialchars($user['ville'] ?? '') ?>"><br>

        <label for="adress">Adresse</label><br>
        <input type="text" name="adresse" id="adresse" value="<?= htmlspecialchars($user['adresse'] ?? '') ?>"><br>

        <label for="code_postal">Code postal</label><br>
        <input type="text" name="code_postal" id="code_postal" value="<?= htmlspecialchars($user['code_postal'] ?? '') ?>"><br>

        <button type="submit">Valider</button><a href="/profile">Annuler</a>
    </form>
</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>