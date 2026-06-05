<footer class="mt-5 d-flex">
    <div class="mt-2">
        <?php foreach($horaire  as $jour) : ?>
            <p class="horaire"><?= htmlspecialchars($jour['jour']) ?> - <?= htmlspecialchars(str_replace('h00', 'h',ltrim( $jour['heure_ouverture'], '0'))) ?> - <?= htmlspecialchars(str_replace('h00', 'h',ltrim($jour['heure_fermeture'], '0'))) ?></p>
        <?php endforeach ?>
    </div>
    <div class="d-flex coordonnees">
        <h6>Coordonnées :</h6>
        <p>4 rue de Rosiers</p>
        <p>33000 Bordeaux</p>
        <p><i class="fa-solid fa-at"></i>vite&gourmand@mail.com</p>
        <p><i class="fa-solid fa-phone"></i>0612345678</p>
    </div>
    <div class="d-flex reseaux">
        <a href="#"><i class="fa-brands fa-instagram"></i></a>
        <a href="#"><i class="fa-brands fa-facebook"></i></a>
    </div>
    <div class="d-flex mentions mt-4">
        <a href="#">Mentions légales</a>
        <a href="#">CGV</a>
        <div class="d-flex"><p>&copy;Créé par VDG </p><img src="/assets/img/Logo_blanc.png" alt="Logo" class="logo"></div>
        <p>2026 Vite & Gourmand. Tous droits réservés.</p>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>