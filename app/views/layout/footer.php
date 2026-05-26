<footer>
    <?php foreach($horaire  as $jour) : ?>
        <p><?= htmlspecialchars($jour['jour']) ?> - <?= htmlspecialchars(str_replace('h00', 'h',ltrim( $jour['heure_ouverture'], '0'))) ?> - <?= htmlspecialchars(str_replace('h00', 'h',ltrim($jour['heure_fermeture'], '0'))) ?></p>
    <?php endforeach ?>
    Contenu du footer
</footer>
</body>
</html>