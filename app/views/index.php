<?php
require_once __DIR__ . '/../views/layout/header.php';
?>

<main>
    <?php if(!isset($_SESSION['id'])): ?>
        <a href="/auth/login">Connexion</a><br>
    <?php endif ?>
    <a href="/auth/register">Créer un compte </a><br>
    <hr><br>
    <?php if(isset($_SESSION['id'])): ?>
        <p>Connecté en tant que <?= $_SESSION['pseudo'] ?></p>
        <a href="/auth/logout">Déconnexion</a>
    <?php else: ?>
        <a href="/auth/login">Connexion</a>
    <?php endif ?>
    <?php if ($_GET['error'] ?? null): ?>
        <p><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <br><hr><br>
    
    <h1>Titre de l'appweb</h1>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam, exercitationem. Earum commodi illum repellat qui dolorem! Ab architecto amet, necessitatibus ullam qui adipisci ea facere fuga laboriosam repellat officia explicabo.
    Laudantium illo porro facere ipsum. Error sed sint placeat, blanditiis amet porro officia praesentium. Possimus esse qui cumque soluta fuga obcaecati sequi doloremque? Molestias nam ullam a deserunt adipisci recusandae!
    Nisi quisquam adipisci, aspernatur voluptatibus delectus praesentium laudantium illum exercitationem eius tempora corporis odit, nam libero ipsam hic consequatur nemo quae? Hic consectetur nulla quia error est dolorum quam ullam.
    Placeat quos pariatur saepe eos reprehenderit doloribus repellat perspiciatis odio. Odio iure assumenda numquam, nihil vel quaerat eos! Sapiente repellendus inventore ea? Ea quaerat illum, earum vitae commodi consequatur delectus.</p>
</main>


<?php
require_once __DIR__ . '/../views/layout/footer.php';
?>