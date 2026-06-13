<?php
$pageSpecificCss = 'style.css';
require_once __DIR__ . '/../../views/layout/header.php';
?>

<main>
    <?php if($_SESSION['role_id'] === 1 ) : ?>
        <a class="liens-retour" href="/profile">Retour profil</a><br>
    <?php elseif($_SESSION['role_id'] === 2 || $_SESSION['role_id'] === 3 )  : ?>
        <a class="liens-retour" href="/commandes-client">Retour aux commandes</a>
    <?php endif ?>

    <?php if ($_GET['error'] ?? null): ?>
        <p class="error-message mt-1 text-center"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif ?>
    <?php if ($_GET['success'] ?? null): ?>
        <p class="success-message mt-1 text-center"><?= htmlspecialchars($_GET['success']) ?></p>
    <?php endif ?>

    <section class="section-commande-client">
        <h3 class="text-center">Commande no : <?=   htmlspecialchars($commandes['numero_commande']) ?></h3>

        <h4 class="text-center"><?= htmlspecialchars($commandes['titre']) ?></h4>
        <?php if($_SESSION['role_id'] === 3 || $_SESSION['role_id'] === 2) : ?>
            <hr>
            <p><span>Client</span> :<?= htmlspecialchars($commandes['nom_complet']) ?> </p><br>
            <p><span>Adresse</span> : <?= htmlspecialchars($commandes['adresse_livraison']) ?> </p><br>
            <p><span>Ville</span> : <?= htmlspecialchars($commandes['ville'] ?? '') ?> </p><br>
            <p><span>Code postal</span> :<?= htmlspecialchars($commandes['code_postal'] ?? '') ?></p><br>
            <p><span>Téléphone</span> : <?= htmlspecialchars($commandes['gsm'] ?? '') ?></p><br>
            <p><span>Email</span> : <?= htmlspecialchars($commandes['utilisateur_email']) ?></p><br>
            
        <?php endif ?>
        <hr>
        <p><span>Date de commande</span> : <?= date('d/m/Y', strtotime($commandes['date_commande']) )?></p><br>
        <p><span>Date de prestation</span> : <?= date('d/m/Y', strtotime($commandes['date_prestation'])) ?></p><br>
        <p><span>Heure de livraison</span> : <?= str_replace(':', ' h ', ltrim(date('H:i', strtotime($commandes['heure_livraison'])), '0')) ?></p><br>
        <p><span>Adresse de la livraison</span> : <?= htmlspecialchars($commandes['adresse_livraison'] ?? '') ?></p><br>
        <p><span>Ville</span> : <?= htmlspecialchars($commandes['ville']) ?> - <?= htmlspecialchars($commandes['code_postal']) ?></p><br>
        <p><span>Nombre de personne</span> : <?=   htmlspecialchars($commandes['nombre_personne']) ?></p><br>
        <p><span>Statut</span> : <?= htmlspecialchars(str_replace('_', ' ',ucfirst($commandes['statut']))) ?></p><br>
        <p><span>Prêt de matériel</span> : <?= $commandes['pret_materiel'] ? 'Oui' : 'Non' ?></p><br>
        <p><span>Restitué</span> : <?= $commandes['restitution_materiel'] ? 'Oui' : 'Non' ?></p>

        <h4 class="text-center">Historique</h4>
        <table class="tableau-historique">
            <thead>
                <tr>
                    <th>Statut</th>
                    <th class="th-historique">Date/heure</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($historique as $statut) : ?>
                    <tr>
                        <td><?= htmlspecialchars(str_replace('_', ' ',ucfirst($statut['statut'])) ) ?></td>
                        <td><?= str_replace(':', ' h ',date('d/m/Y \à H:i', strtotime($statut['date_modification']))) ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        
        
        
            <?php if($_SESSION['role_id'] === 1) : ?>
                <div class="actions-commande">
                    <?php if($commandes['statut'] === 'en_attente') : ?>
                        <form action="/commandes/annuler/<?= $commandes['commande_id'] ?>" method="POST">
                            <?= Auth::csrfField() ?>
                            <button type="submit">Annuler</button>
                        </form>
                        <a href="/commandes/edit/<?= $commandes['commande_id'] ?>">Modifier</a>
                    <?php endif ?>
                    <?php if( $commandes['statut'] === 'terminee' && $avis === false) : ?>
                        <a href="/avis/noter/<?= $commandes['commande_id'] ?>">Noter commande</a>
                        <?php elseif($commandes['statut'] === 'terminee' && $avis['statut'] === 'en_attente') : ?>
                        <p class="text-success mt-4">Votre avis est en attente de validation .</p>
                    <?php elseif($commandes['statut'] === 'terminee' && $avis['statut'] === 'valide') : ?>
                        <a href="/avis/edit/<?= $avis['avis_id'] ?>">Modifier Avis</a>
                    <?php endif ?>
                </div>
            <?php elseif($_SESSION['role_id'] === 2 || $_SESSION['role_id'] === 3) : ?>
                <?php if($commandes['statut'] !== 'terminee' && $commandes['statut'] !== 'annulee') : ?>
                    <form action="/commandes/update/<?= $commandes['commande_id'] ?>" method="POST">
                        <?= Auth::csrfField() ?>
                        <button type="submit">Modifier statut</button>
                    </form>
                <?php endif ?>
            <? endif ?>
    </section>
</main>
<?php
require_once __DIR__ . '/../../views/layout/footer.php';
?>