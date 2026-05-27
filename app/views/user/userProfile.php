<?php
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <p><?= htmlspecialchars($user['prenom'])  ?> , voici vos infos </p><br>
    <p>Votre email : <?= htmlspecialchars($user['email'])  ?></p><br>
    <p>Votre Nom : <?= htmlspecialchars($user['nom'])  ?></p><br>
    <p>Votre Prenom : <?= htmlspecialchars($user['prenom'])  ?></p><br>
    <p>Votre numéro de téléphone :  <?= htmlspecialchars($user['gsm']?? '' )  ?></p><br>
    <p>Votre ville :  <?= htmlspecialchars($user['ville'] ?? '' )  ?></p><br>
    <p>Votre adresse :  <?= htmlspecialchars($user['adresse'] ?? '' )  ?></p><br>
    <p>Votre code postale :  <?= htmlspecialchars($user['code_postal'] ?? '' )  ?></p><br>
</main>

<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>