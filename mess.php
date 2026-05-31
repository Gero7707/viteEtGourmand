
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h4>Numéro de commande</h4>
    <p><?= htmlspecialchars($data['numero_commande']) ?>  </p><br>
    <h4>Menu :</h4>
    <p><?= htmlspecialchars($menu['titre']) ?> pour <?= htmlspecialchars($data['nombre_personne']) ?></p><br>
    <h4>Adresse et date de prestation :</h4>
    <p><?= htmlspecialchars($data['adrese_livraison']) ?> le <?= htmlspecialchars($data['date_livraison']) ?> à <?= htmlspecialchars($data['heure_livraison']) ?></p><br>
    <h4>Prix total :</h4>
    <p><?= htmlspecialchars($data['prix_menu']) ?></p><br>
    
</body>
</html>