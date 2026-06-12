<?php
$pageSpecificCss = 'style.css';
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message mt-1 text-center"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message mt-1 text-center"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>

    <section class="section-profile-user mb-5">
        <h5 class="text-center"><?= htmlspecialchars($user['prenom'])  ?> , voici vos données personnelles : </h5><br>
        <div class="donnees-user">
            
            <p><span>Email</span> :  <?= htmlspecialchars($user['email'])  ?></p><br>
            <p><span>Nom</span> : <?= htmlspecialchars($user['nom'])  ?></p><br>
            <p><span>Prenom</span> : <?= htmlspecialchars($user['prenom'])  ?></p><br>
            <p><span>Téléphone</span> :  <?= htmlspecialchars($user['gsm']?? '' )  ?></p><br>
            <p><span>Adresse</span> :  <?= htmlspecialchars($user['adresse'] ?? '' )  ?><br><?= htmlspecialchars($user['code_postal'] ?? '' )  ?>  , <?= htmlspecialchars($user['ville'] ?? '' )  ?></p>
            <hr>
            <div class="modif-profil">
                <a href="/profile/edit">Modifier profil</a>
            </div>
        </div>
    </section>
    <section class="section-commandes">
        <h5 class="text-center">Vos commandes</h5>

        <table class="tableau-commande">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>No commande</th>
                    <th>Date commande</th>
                    <th>Statut</th>
                    <th>Voir</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($commandes as $commande) : ?>
                    <tr>
                        <td><?= htmlspecialchars($commande['titre'])  ?></p></td>
                        <td><?= htmlspecialchars($commande['numero_commande'])  ?></td>
                        <td><?= date('d/m/Y', strtotime($commande['date_commande']))  ?></td>
                        <td><?= htmlspecialchars(str_replace('_', ' ',ucfirst($commande['statut'])) ) ?></td>
                        <td>
                            <a href="/commandes/<?= $commande['commande_id'] ?>"><i class="fa-solid fa-eye"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        
    </section>
        
</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>
