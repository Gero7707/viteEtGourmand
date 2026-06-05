<footer>
    <?php foreach($horaire  as $jour) : ?>
        <p><?= htmlspecialchars($jour['jour']) ?> - <?= htmlspecialchars(str_replace('h00', 'h',ltrim( $jour['heure_ouverture'], '0'))) ?> - <?= htmlspecialchars(str_replace('h00', 'h',ltrim($jour['heure_fermeture'], '0'))) ?></p>
    <?php endforeach ?>
    Contenu du footer
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>