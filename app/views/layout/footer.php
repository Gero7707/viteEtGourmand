<footer class=" d-flex">
    <div class="mt-2 liste-horaire">
        <?php foreach($horaire  as $jour) : ?>
            <p class="horaire"><?= htmlspecialchars($jour['jour']) ?> - <?= htmlspecialchars(str_replace('h00', 'h',ltrim( $jour['heure_ouverture'], '0'))) ?> - <?= htmlspecialchars(str_replace('h00', 'h',ltrim($jour['heure_fermeture'], '0'))) ?></p>
        <?php endforeach ?>
    </div>
    <div class="d-flex coordonnees">
        <p>Coordonnées :</p>
        <p>4 rue de Rosiers</p>
        <p>33000 Bordeaux</p>
        <p><a href="mailto:vite&gourmand@mail.com"><i class="fa-solid fa-at"></i>vite&gourmand@mail.com</a> </p>
        <p><i class="fa-solid fa-phone"></i>0612345678</p>
    </div>
    <div class="d-flex reseaux">
        <a href="https://www.instagram.com" aria-label="Notre page Instagram"><i class="fa-brands fa-instagram"></i></a>
        <a href="https://www.facebook.com" aria-label="Notre page Facebook"><i class="fa-brands fa-facebook"></i></a>
    </div>
    <div class="d-flex mentions mt-4">
        <a href="/mentions-legales">Mentions légales</a>
        <a href="/cgv">CGV</a>
        <a href="/confidentialite">Politique de confidentialité</a>
        <div class="d-flex"><p>&copy;Créé par VDG </p><img src="/assets/img/Logo_blanc.png" alt="Logo VDG - Vincent Didier Geraghty développeur web" class="logo"></div>
        <p>2026 Vite & Gourmand. Tous droits réservés.</p>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>
</html>