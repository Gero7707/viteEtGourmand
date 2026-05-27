<?php
require_once __DIR__ . '/../views/layout/header.php';
?>

<main>
    <?php if(!isset($_SESSION['utilisateur_id'])): ?>
        <a href="/auth/login">Connexion</a><br>
        <a href="/auth/register">Créer un compte </a><br>
    <?php endif ?>
    
    <hr><br>
    <?php if(isset($_SESSION['utilisateur_id'])): ?>
        <p>Bonjour  <?= $_SESSION['prenom'] ?>  !</p><br>
        <?php if($_SESSION['role_id'] === 1) : ?><p>Vous êtes un utilisateur</p>  <br>
            <a href="/profile">Voir profil</a><br>
        <?php elseif ($_SESSION['role_id'] === 2) :  ?>
        <p>Vous êtes un  employé </p><br>
        <?php elseif ($_SESSION['role_id'] === 3) :  ?>
        <p>Vous êtes un  administrateur </p><br>
        <?php endif ?>
        <a href="/auth/logout">Déconnexion</a>
    <?php endif ?>

    <?php if ($_GET['error'] ?? null): ?>
        <p><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <br><hr><br>

    <a href="/menus" class="btn">Découvrir nos menus</a>
    
    <br><hr><br>
    <?php foreach($avis as $carteAvis) : ?>
        <p><?= htmlspecialchars($carteAvis['nom_complet']) ?></p>
        <p><?= htmlspecialchars($carteAvis['note']) ?></p>
        <p><?= htmlspecialchars($carteAvis['description']) ?></p>
        <p><?= htmlspecialchars(str_replace(':00', 'h',date('d-m-Y  à  H:i', strtotime($carteAvis['date_avis'])))) ?></p>
        <hr>
    <?php endforeach ?>
    <a href="/avis">Voir tous les avis</a>


    <br><hr><br>
    
    
</main>


<?php
require_once __DIR__ . '/../views/layout/footer.php';
?>