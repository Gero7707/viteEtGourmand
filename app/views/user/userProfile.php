<?php
$pageSpecificCss = ['style.css' , 'layout.css'];
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message-php text-center mt-1"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message-php text-center mt-1"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>

    <section class="section-profile-user mb-5">
        <h2 class="text-center"><?= htmlspecialchars($user['prenom'])  ?> , voici vos données personnelles : </h2><br>
        <div class="donnees-user">
            
            <p><span>Email</span> :  <?= htmlspecialchars($user['email'])  ?></p><br>
            <p><span>Nom</span> : <?= htmlspecialchars($user['nom'])  ?></p><br>
            <p><span>Prenom</span> : <?= htmlspecialchars($user['prenom'])  ?></p><br>
            <p><span>Téléphone</span> :  <?= htmlspecialchars($user['gsm']?? '' )  ?></p><br>
            <p><span>Adresse</span> : <br> <?= htmlspecialchars($user['adresse'] ?? '' )  ?><br><?= htmlspecialchars($user['code_postal'] ?? '' )  ?>  , <?= htmlspecialchars($user['ville'] ?? '' )  ?></p>
            <hr>
            <div class="modif-profil">
                <a href="/profile/edit">Modifier profil</a>
            </div>
        </div>
    </section>
    <section class="section-commandes mb-5">
        <h2 class="text-center">Vos commandes</h2>

        <table class="tableau-commande">
            <thead>
                <tr>
                    <th class=" d-none d-md-table-cell">Menu</th>
                    <th class=" d-none d-md-table-cell">No commande</th>
                    <th>Date commande</th>
                    <th>Statut</th>
                    <th>Voir</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($commandes as $commande) : ?>
                    <tr>
                        <td class=" d-none d-md-table-cell"><?= htmlspecialchars($commande['titre'])  ?></p></td>
                        <td class=" d-none d-md-table-cell"><?= htmlspecialchars($commande['numero_commande'])  ?></td>
                        <td><?= date('d/m/Y', strtotime($commande['date_commande']))  ?></td>
                        <td><?= htmlspecialchars(str_replace(['en_attente', 'en_preparation', 'en_livraison', 'attente_retour_materiel', 'terminee', 'acceptee', 'annule', 'livree'],
                                                            ['En attente', 'En préparation', 'En livraison', 'Attente retour matériel', 'Terminée', 'Acceptée', 'Annulée', 'Livrée'],
                                                            $commande['statut'])) ?>
                        </td>
                        <td>
                            <a aria-label="Voir la commande" href="/commandes/<?= $commande['commande_id'] ?>"><i  aria-hidden="true" class="fa-solid fa-eye"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        
    </section>
    <section class="supprimer-profil text-center">
        <a aria-label="Supprimer votre compte" href="/auth/delete-account">Supprimer votre compte</a>
    </section>
        
</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>
