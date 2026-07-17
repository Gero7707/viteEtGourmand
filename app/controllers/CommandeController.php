<?php
require_once __DIR__ . '/../models/CommandeModel.php';
require_once __DIR__ . '/../models/HoraireModel.php';
require_once __DIR__ . '/../models/MenuModel.php';
require_once __DIR__ . '/../models/AvisModel.php';
require_once __DIR__ . '/../services/GeoService.php';
require_once __DIR__ . '/../services/MailService.php';
require_once __DIR__ . '/../models/PlatModel.php';
require_once __DIR__ . '/../models/MongoModel.php';

class CommandeController{
    private HoraireModel $horaire;
    private CommandeModel $commandes;

    private MenuModel $menu;

    private GeoService $geo;

    private MailService $mailService;

    private AvisModel $avis;

    private PlatModel $plat;

    private MongoModel $mongo;


    public function __construct(){
        $this->commandes = new CommandeModel();
        $this->horaire = new HoraireModel();
        $this->menu = new MenuModel();
        $this->geo = new GeoService();
        $this->mailService = new MailService();
        $this->avis = new AvisModel();
        $this->plat = new PlatModel();
        $this->mongo = new MongoModel();
    }

    public function showCommandes(){
        $id = $_SESSION['utilisateur_id'];
        $commandes = $this->commandes->getCommandes($id);
        $horaire = $this->horaire->getHoraire();
        require_once __DIR__ . '/../views/commande/commandeListe.php';
    }

    public function showAllCommandes(){
        $horaire = $this->horaire->getHoraire();
        $commandes = $this->commandes->getAllCommandes();
        require_once __DIR__ . '/../views/employe/commandesClient.php';
    }

    public function show(int $id){
        $horaire = $this->horaire->getHoraire();
        $commandes = $this->commandes->findById($id);
        $avis = $this->avis->findByCommandeId($id);
        $historique = $this->commandes->getHistorique($id);
        require_once __DIR__ . '/../views/commande/userCommande.php';
    }

    public function showForm(int $menu_id){
        Auth::checkAuth();
        if(empty($_SESSION['gsm']) || empty($_SESSION['ville']) || empty($_SESSION['adresse']) || empty($_SESSION['code_postal'])){
            $error =  "Veuillez compléter votre profil avant de commander.";
            header('Location: /profile/edit?error=' . urlencode($error));
            exit();
        }
        $horaire = $this->horaire->getHoraire();
        $plat = $this->plat->getPlatById($menu_id);
        $menu = $this->menu->findById($menu_id);
        $plat = $this->menu->getMenuPlats($menu_id);
        foreach($plat as &$p) {
            $p['allergenes'] = $this->plat->getPlatAllergenes($p['plat_id']);
        }
        unset($p); 
        $data = [
            'email' => $_SESSION['email'],
            'nom' => $_SESSION['nom'],
            'prenom' => $_SESSION['prenom'],
            'gsm' => $_SESSION['gsm'] ?? '',
            'adresse' => $_SESSION['adresse'] ?? '' ,
            'ville' => $_SESSION['ville'] ?? '' ,
            'code_postal' => $_SESSION['code_postal'] ?? '' 
        ];
        require_once __DIR__ . '/../views/commande/commandeForm.php';
    }

    private function calculerPrix(int $nbPersonnes, string $adresse, string $codePostal, string $ville, int $menuId): array {
        $menu = $this->menu->findById($menuId);
        $prixParPersonne = $menu['prix_par_personne'];
        $nbPersonneMini = $menu['nombre_personne_minimum'];
        $fraisLivraison = 0;
        $distance = 0;

        if ($nbPersonnes < $nbPersonneMini) {
            throw new Exception("Vous n'avez pas le nombre de personnes minimum pour ce menu !");
        }
        if($menu['quantite_restante'] !== NULL){
            if($nbPersonnes > $menu['quantite_restante']){
                throw new Exception("La quantité restante est inférieur à la quantité voulu !");
            }
        }
        
        if ($nbPersonnes >= $nbPersonneMini + 5) {
            $prixMenu = ($nbPersonnes * $prixParPersonne) * 0.90;
        } else {
            $prixMenu = $nbPersonnes * $prixParPersonne;
        }

        $estABordeaux = in_array($codePostal, ['33000', '33100', '33200', '33300', '33800'], true);

        if (!$estABordeaux) {
            $adresseComplete = $adresse . ', ' . $codePostal . ' ' . $ville;
            $coords = $this->geo->geocode($adresseComplete);
            $distance = $this->geo->getDistanceKm($coords['lat'], $coords['lng']);
            $fraisLivraison = ($distance * 0.59) + 5;
        }

        return [
            'prix_menu' => $prixMenu,
            'frais_livraison' => $fraisLivraison,
            'prix_total' => $prixMenu + $fraisLivraison,
            'distance_km' => $distance
        ];
    }

    public function calculFrais(): void {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);

        try {
            $resultat = $this->calculerPrix(
                (int) $data['nombre_personne'],
                $data['adresse'],
                $data['code_postal'],
                $data['ville'],
                (int) $data['menu_id']
            );
            echo json_encode(['success' => true] + $resultat);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function create(){
        Auth::checkAuth();
        Auth::verifyCsrfToken();
        $menu_id = (int) ($_POST['menu_id'] ?? 0);
        
        if ($menu_id <= 0) {
            header('Location: /menus');
            exit;
        }

        $menu = $this->menu->findById($menu_id);
        if (!$menu) {
            header('Location: /menus');
            exit;
        }

        $adresse = $_POST['adresse_livraison'];
        if(empty(trim($adresse))){
            $error = "Vous devez indiquer une adresse de livraison  svp .";
            header('Location: /commandes/create/' . $menu_id . '?error=' . urlencode($error));
            exit();
        }

        $codePostal = $_POST['code_postal'];
        if(empty(trim($codePostal))){
            $error = "Vous devez indiquer le code postal  svp.";
            header('Location: /commandes/create/' . $menu_id . '?error=' . urlencode($error));
            exit();
        }

        $ville = $_POST['ville'];
        if(empty(trim($ville))){
            $error = "Vous devez indiquer la ville  svp.";
            header('Location: /commandes/create/' . $menu_id . '?error=' . urlencode($error));
            exit();
        }

        $gsm = $_POST['utilisateur_gsm'];
        if(empty(trim($gsm))){
            $error = "Vous devez indiquer le numéro de téléphone  svp.";
            header('Location: /commandes/create/' . $menu_id . '?error=' . urlencode($error));
            exit();
        }

        $nombrePersonnes = $_POST['nombre_personne'];
        if(empty(trim($nombrePersonnes))){
            $error = "Vous devez indiquer le nombre de personnes  svp.";
            header('Location: /commandes/create/' . $menu_id . '?error=' . urlencode($error));
            exit();
        }

        $datePrestation = $_POST['date_prestation'];
        if(empty(trim($datePrestation))){
            $error = "Vous devez indiquer la date de prestation  svp.";
            header('Location: /commandes/create/' . $menu_id . '?error=' . urlencode($error));
            exit();
        }

        $heureLivraison = $_POST['heure_livraison'];
        if(empty(trim($heureLivraison))){
            $error = "Vous devez indiquer l'heure de livraison  svp.";
            header('Location: /commandes/create/' . $menu_id . '?error=' . urlencode($error));
            exit();
        }

        try {
            $resultat = $this->calculerPrix((int) $nombrePersonnes, $adresse, $codePostal, $ville, $menu_id);
        } catch (Exception $e) {
            $error = "Erreur lors du calcul du prix. Veuillez réessayer.";
            header('Location: /commandes/create/' . $menu_id . '?error=' . urlencode($error));
            exit;
        }

        $numeroCommande = 'CMD-' . strtoupper(uniqid());

        $dateCommande = date('Y-m-d H:i:s');
        $dateModif = date('Y-m-d H:i:s');

        $data = [
            'adresse_livraison' => $adresse,
            'ville' => $ville,
            'code_postal' => $codePostal,
            'distance_km' => $_POST['distance_km'],
            'numero_commande' => $numeroCommande,
            'date_commande' => $dateCommande,
            'date_prestation' => $datePrestation ,
            'heure_livraison' => $heureLivraison ,
            'prix_menu' => $resultat['prix_menu' ],
            'nombre_personne' => $nombrePersonnes,
            'prix_livraison' => $resultat['frais_livraison'],
            'statut' => 'en_attente',
            'utilisateur_id' => $_SESSION['utilisateur_id'],
            'pret_materiel' => 1 ,
            'menu_id' => $menu_id
        ];

        $id = $this->commandes->createCommande($data);

        $historiqueData = [
            'commande_id' => $id,
            'statut' => 'en_attente',
            'date_modification' => $dateModif
        ];
        $this->commandes->createHistorique($historiqueData);
        
        $dateFormatee = (new DateTime($data['date_prestation']))->format('d/m/Y');
        $detailCommande = "
        <h4>Numéro de commande</h4>
        <p>{$data['numero_commande']}  </p><br>
        <h4>Menu :</h4>
        <p>{$menu['titre']} pour {$data['nombre_personne']}</p><br>
        <h4>Adresse et date de prestation :</h4>
        <p>{$data['adresse_livraison']} le {$dateFormatee} à {$data['heure_livraison']}</p><br>
        <h4>Prix total :</h4>
        <p>{$data['prix_menu']} €</p><br>
        ";
        $titre = "Commande confirmée .";

        $conclusion = "<p>Merci d'avoir passé commande chez Vite &amp; Gourmand . </p>
        <p>Vous recevrez un message dès que votre commande sera acceptée . Vous pouvez  modifier ou annuler votre commande tant qu'elle n'est pas acceptée .</p>
        <p> Vite &amp; Gourmand vous souhaite une bonne journée.</p>";

        $imageHaut = '<img src="https://restaurationviteetgourmand.alwaysdata.net/assets/img/bandeau-email.jpg" 
                alt="Vite &amp; Gourmand" 
                width="600" 
                style="display: block; width: 100%; max-width: 600px; height: auto; border: 0;">';

        $imageBas = '<img src="https://restaurationviteetgourmand.alwaysdata.net/assets/img/cuistot.jpg" 
                alt="Vite &amp; Gourmand" 
                width="600" 
                style="display: block; width: 100%; max-width: 600px; height: auto; border: 0;">';

        $message =$imageHaut . $detailCommande . $conclusion . $imageBas;
        $emailCommande = $_SESSION['email'];
        
        $this->mailService->sendEmail($emailCommande,$titre,$message);
        
        $successMessage = "Merci pour votre commande no " . $numeroCommande . ", elle est désormé en attente d'acceptation . Vous pouvez encore la modifier ou l'annuler tant qu'elle n'est pas encore acceptée.";
        header('location: /profile?success=' . $successMessage);
        exit();
    }

    public function annulerCommande(int $id){
        Auth::verifyCsrfToken();
        Auth::checkAuth();
        $utilisateurId = $_SESSION['utilisateur_id'];
        $commande = $this->commandes->findById($id);
        if($utilisateurId === $commande['utilisateur_id'] && $commande['statut'] === "en_attente"){
            $this->commandes->annulerCommande($id);
            $dateModif = date('Y-m-d H:i:s');
            $historiqueData = [
                'commande_id' => $id,
                'statut' => 'annulee',
                'date_modification' => $dateModif
            ];
            $this->commandes->createHistorique($historiqueData);

            $successMessage = "Votre commande est annulée .";
            header('location: /profile?success=' . urlencode($successMessage));
            exit();
        }else{
            $error = "Vous ne pouvez pas  annuler cette commande  . Elle est déjà acceptée .";
            header('location: /profile?error=' . urlencode($error));
            exit();
        }
    }

    public function showUpdate(int $id){
        Auth::checkAuth();
        $commande = $this->commandes->findById($id);
        $menu_id = $commande['menu_id'];
        $menu = $this->menu->findById($menu_id);
        $horaire = $this->horaire->getHoraire();
        $plat = $this->plat->getPlatById($id);
        $plat = $this->menu->getMenuPlats($menu_id);
        foreach($plat as &$p) {
            $p['allergenes'] = $this->plat->getPlatAllergenes($p['plat_id']);
        }
        unset($p);
        $utilisateurId = $_SESSION['utilisateur_id'];
        if($utilisateurId === $commande['utilisateur_id'] && $commande['statut'] === "en_attente"){
            require_once __DIR__ . '/../views/commande/updateCommande.php';
        }else{
            $error = "Vous ne pouvez pas  modifier cette commande  . Elle est déjà acceptée .";
            header('location: /profile?error=' . urlencode($error));
            exit();
        }
    }

    public function updateCommande(int $id){
        Auth::checkAuth();
        Auth::verifyCsrfToken();
        $menu_id = $_POST['menu_id'];
        $menu = $this->menu->findById($menu_id);
        $commande = $this->commandes->findById($id);
        $utilisateurId = $_SESSION['utilisateur_id'];
        if($utilisateurId === $commande['utilisateur_id'] && $commande['statut'] === "en_attente"){
            if (!$menu) {
                header('Location: /menus');
                exit;
            }

            $adresse = $_POST['adresse_livraison'];
            if(empty(trim($adresse))){
                $error = "Vous devez indiquer une adresse de livraison  svp .";
                header('Location: /commandes/edit/' . $id . '?error=' . urlencode($error));
                exit();
            }

            $codePostal = $_POST['code_postal'];
            if(empty(trim($codePostal))){
                $error = "Vous devez indiquer le code postal  svp.";
                header('Location: /commandes/edit/' . $id . '?error=' . urlencode($error));
                exit();
            }

            $ville = $_POST['ville'];
            if(empty(trim($ville))){
                $error = "Vous devez indiquer la ville  svp.";
                header('Location: /commandes/edit/' . $id . '?error=' . urlencode($error));
                exit();
            }

            $gsm = $_POST['utilisateur_gsm'];
            if(empty(trim($gsm))){
                $error = "Vous devez indiquer le numéro de téléphone  svp.";
                header('Location: /commandes/edit/' . $id . '?error=' . urlencode($error));
                exit();
            }

            $nombrePersonnes = $_POST['nombre_personne'];
            if(empty(trim($nombrePersonnes))){
                $error = "Vous devez indiquer le nombre de personnes  svp.";
                header('Location: /commandes/edit/' . $id . '?error=' . urlencode($error));
                exit();
            }

            $datePrestation = $_POST['date_prestation'];
            if(empty(trim($datePrestation))){
                $error = "Vous devez indiquer la date de prestation  svp.";
                header('Location: /commandes/edit/' . $id . '?error=' . urlencode($error));
                exit();
            }

            $heureLivraison = $_POST['heure_livraison'];
            if(empty(trim($heureLivraison))){
                $error = "Vous devez indiquer l'heure de livraison  svp.";
                header('Location: /commandes/edit/' . $id . '?error=' . urlencode($error));
                exit();
            }

            try {
                $resultat = $this->calculerPrix((int) $nombrePersonnes, $adresse, $codePostal, $ville, $menu_id);
            } catch (Exception $e) {
                $error = "Erreur lors du calcul du prix. Veuillez réessayer.";
                header('Location: /commandes/edit/' . $id . '?error=' . urlencode($error));
                exit;
            }

            $dateCommande = date('Y-m-d H:i:s');
            $dateModif = date('Y-m-d H:i:s');

            $data = [
                'adresse_livraison' => $adresse,
                'ville' => $ville,
                'code_postal' => $codePostal,
                'distance_km' => $_POST['distance_km'],
                'date_commande' => $dateCommande,
                'date_prestation' => $datePrestation ,
                'heure_livraison' => $heureLivraison ,
                'prix_menu' => $resultat['prix_menu' ],
                'nombre_personne' => $nombrePersonnes,
                'prix_livraison' => $resultat['frais_livraison'],
                'statut' => 'en_attente',
                'utilisateur_id' => $_SESSION['utilisateur_id'],
                'pret_materiel' => 1 ,
                'menu_id' => $menu_id,
                'commande_id' => $id
            ];

            $this->commandes->updateCommande($data);

            $historiqueData = [
                'commande_id' => $id,
                'statut' => 'en_attente',
                'date_modification' => $dateModif
            ];
            $this->commandes->createHistorique($historiqueData);
            
            $dateFormatee = (new DateTime($data['date_prestation']))->format('d/m/Y');
            $detailCommande = "
            <h4>Numéro de commande</h4>
            <p>{$commande['numero_commande']}  </p><br>
            <h4>Menu :</h4>
            <p>{$menu['titre']} pour {$data['nombre_personne']}</p><br>
            <h4>Adresse et date de prestation :</h4>
            <p>{$data['adresse_livraison']} le {$dateFormatee} à {$data['heure_livraison']}</p><br>
            <h4>Prix total :</h4>
            <p>{$data['prix_menu']}</p><br>
            ";
            $titre = "Commande modifiée .";
            
            $imageHaut = '<img src="https://restaurationviteetgourmand.alwaysdata.net/assets/img/bandeau-email.jpg" 
                    alt="Vite &amp; Gourmand" 
                    width="600" 
                    style="display: block; width: 100%; max-width: 600px; height: auto; border: 0;">';

            $imageBas = '<img src="https://restaurationviteetgourmand.alwaysdata.net/assets/img/cuistot.jpg" 
                    alt="Vite &amp; Gourmand" 
                    width="600" 
                    style="display: block; width: 100%; max-width: 600px; height: auto; border: 0;">';

            $conclusion = "<p>Vous avez modifié votre commande . Merci d'avoir passé commande chez Vite &amp; Gourmand .</p>
            <p> Vous receverez un message dès que votre commande sera acceptée . Vous pouvez annuler modifier ou annuler votre commande tant qu'elle n'est pas acceptée . </p>
            <p>Vite &amp; Gourmand vous souhaite une bonne journée.</p>";
            $message =$imageHaut . $detailCommande . $conclusion . $imageBas;
            $emailCommande = $_SESSION['email'];
            
            $this->mailService->sendEmail($emailCommande,$titre,$message);
            

            header('location: /profile');
            exit();
        }else{
            $error = "Une erreur est survenu";
            header('Location: /commandes/edit/' . $menu_id . '?error=' . urlencode($error));
            exit(); 
        }
    }

    public function changerStatutCommande(int $id ){

        Auth::checkEmploye();
        Auth::verifyCsrfToken();
        $statutActuel = $this->commandes->findById($id);
        $transition = [
            'en_attente' => 'acceptee', 
            'acceptee' => 'en_preparation', 
            'en_preparation' => 'en_livraison', 
            'en_livraison' => 'livree', 
            'livree' => 'attente_retour_materiel', 
            'attente_retour_materiel' => 'terminee'
        ];
        if(!isset($transition[$statutActuel['statut']])){
            header('Location: /commandes-client?error=' . urlencode('Statut invalide'));
            exit();
        }
        $statutSuivant = $transition[$statutActuel['statut']];
        $this->commandes->updateStatutCommande($id ,$statutSuivant);

        $dateModif = date('Y-m-d H:i:s');
        $historiqueData = [
            'commande_id' => $id,
            'statut' => $statutSuivant,
            'date_modification' => $dateModif
        ];
        $this->commandes->createHistorique($historiqueData);
        $nbPersonne = $statutActuel['nombre_personne'];
        $menuId = $statutActuel['menu_id'];
        if($statutSuivant === 'en_preparation'){
            $this->menu->updateQuantiteRestante($menuId ,$nbPersonne );
        }

        if($statutSuivant === 'acceptee'){
            $titre = "Votre commande est acceptée .";

            $imageHaut = '<img src="https://restaurationviteetgourmand.alwaysdata.net/assets/img/bandeau-email.jpg" 
                    alt="Vite &amp; Gourmand" 
                    width="600" 
                    style="display: block; width: 100%; max-width: 600px; height: auto; border: 0;">';

            $imageBas = '<img src="https://restaurationviteetgourmand.alwaysdata.net/assets/img/cuistot.jpg" 
                    alt="Vite &amp; Gourmand" 
                    width="600" 
                    style="display: block; width: 100%; max-width: 600px; height: auto; border: 0;">';
            $conclusion = "<p>Bonjour {$statutActuel['nom_complet']}, votre commande {$statutActuel['numero_commande']} vient d'être acceptée . </p>
            <p>Vous pouvez suivre l'avancée de celle-ci en vous connectant à votre profil . Passé ce délai, une pénalité forfaitaire de 600€ sera facturée.</p>
            <p>Vite &amp; Gourmand vous souhaite une bonne journée.</p>";
            
            $message = $imageHaut . $conclusion . $imageBas ;
            $email = $statutActuel['utilisateur_email'];

            $this->mailService->sendEmail($email , $titre , $message);
        }

        if($statutSuivant === 'attente_retour_materiel'){
            $titre = "En attente de retour du matériel prété .";

            $imageHaut = '<img src="https://restaurationviteetgourmand.alwaysdata.net/assets/img/bandeau-email.jpg" 
                    alt="Vite &amp; Gourmand" 
                    width="600" 
                    style="display: block; width: 100%; max-width: 600px; height: auto; border: 0;">';

            $imageBas = '<img src="https://restaurationviteetgourmand.alwaysdata.net/assets/img/cuistot.jpg" 
                    alt="Vite &amp; Gourmand" 
                    width="600" 
                    style="display: block; width: 100%; max-width: 600px; height: auto; border: 0;">';
            $conclusion = "<p>Bonjour {$statutActuel['nom_complet']}, votre commande {$statutActuel['numero_commande']} a bien été livrée. </p>
            <p>Le matériel prêté doit être restitué sous 10 jours ouvrés. Passé ce délai, une pénalité forfaitaire de 600€ sera facturée.</p>
            <p>Vite &amp; Gourmand vous souhaite une bonne journée.</p>";
            
            $message = $imageHaut . $conclusion . $imageBas ;
            $email = $statutActuel['utilisateur_email'];

            $this->mailService->sendEmail($email , $titre , $message);
        }

        
        if($statutSuivant === 'terminee'){
            $titre = "Enquête satisfaction .";
            $lien = getenv('APP_URL') . '/avis/noter/' . $statutActuel['commande_id'];
            $bouton = '
                <div style="text-align: center; padding: 24px 0;">
                    <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td align="center" style="background-color: #d4af37; border-radius: 6px;">
                        <a href="' . $lien . '" target="_blank"
                            style="display: inline-block; padding: 14px 28px; font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; color: #1a2238; text-decoration: none;">
                            Donner mon avis
                        </a>
                        </td>
                    </tr>
                    </table>
                </div>';
            
            $imageHaut = '<img src="https://restaurationviteetgourmand.alwaysdata.net/assets/img/bandeau-email.jpg" 
                    alt="Vite &amp; Gourmand" 
                    width="600" 
                    style="display: block; width: 100%; max-width: 600px; height: auto; border: 0;">';

            $imageBas = '<img src="https://restaurationviteetgourmand.alwaysdata.net/assets/img/cuistot.jpg" 
                    alt="Vite &amp; Gourmand" 
                    width="600" 
                    style="display: block; width: 100%; max-width: 600px; height: auto; border: 0;">';

            $conclusion = "<p>Bonjour {$statutActuel['nom_complet']}, votre commande {$statutActuel['numero_commande']} est terminée. </p>
            <p>Nous espérons que vous avez apprécié nos services.</p>
            <p>Vite &amp; Gourmand vous souhaite une bonne journée. </p>";
            $message =$imageHaut .  $conclusion . $bouton . $imageBas;

            $email = $statutActuel['utilisateur_email'];

            $this->mailService->sendEmail($email , $titre , $message);
        }
        if ($statutSuivant === 'terminee') {
            $data = [
                'commande_id'  => $id,
                'menu_id'      => $statutActuel['menu_id'],
                'menu_titre'   => $statutActuel['titre'],
                'prix_total'   =>(float) $statutActuel['prix_menu'],
                'date_terminee' => $dateModif
            ];
            $this->mongo->insertCommande($data);
        }

        $successMessage = "Le statut de la commande numéro ". $statutActuel['numero_commande'] . " est : " . str_replace(['en_attente', 'en_preparation', 'en_livraison', 'attente_retour_materiel', 'terminee', 'acceptee', 'annulee', 'livree'],['En attente', 'En préparation', 'En livraison', 'Attente retour matériel', 'Terminée', 'Acceptée', 'Annulée', 'Livrée'], $statutSuivant);

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'nouveauStatut' => $statutSuivant ,'statutFormate' => $successMessage, 'numeroCommande' => $statutActuel['numero_commande']]);
            exit;
        } 
        header('Location: /commandes-client?success=' . urlencode($successMessage));
        exit;
    }

    public function showFormAnnuler(int $id){
        Auth::checkEmploye();
        $horaire = $this->horaire->getHoraire();
        $commandes = $this->commandes->findById($id);
        if($commandes['statut'] !== 'terminee' && $commandes['statut'] !== 'annulee'){
            require_once __DIR__ . '/../views/employe/annulerCommandeEmploye.php';
        }else{
            $error = "Accès refusé .";
            header('Location: /commandes-client?error=' . urlencode($error));
            exit();
        }
    }
    
    
    public function annulerCommandeEmploye(int $id){
        Auth::checkEmploye();
        Auth::verifyCsrfToken();
        $commentaires = $_POST['commentaires'];
        if(empty(trim($commentaires))){
            $error = "Vous devez indiquer le motif et le mode de contact pour annuler la commande .";
            header('Location: /commandes-client?error=' . urlencode($error));
            exit();
        }
        $this->commandes->annulerCommandeEmploye($id);
        $dateModif = date('Y-m-d H:i:s');
        $historiqueData = [
            'commande_id' => $id,
            'statut' => 'annulee',
            'date_modification' => $dateModif,
            'commentaires' => $commentaires
        ];
        $this->commandes->createHistorique($historiqueData);

        $titre = 'Votre commande a été annulée !';
        $lien = getenv('APP_URL') . '/';
        $bouton = '
            <div style="text-align: center; padding: 24px 0;">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td align="center" style="background-color: #d4af37; border-radius: 6px;">
                        <a href="' . $lien . '" target="_blank"
                            style="display: inline-block; padding: 14px 28px; font-family: Arial, Helvetica, sans-serif; font-size: 16px; font-weight: bold; color: #1a2238;text-decoration: none;">
                            Vite &amp; Gourmand
                        </a>
                        </td>
                    </tr>
                </table>
            </div>';
            
        $imageHaut = '<img src="https://restaurationviteetgourmand.alwaysdata.net/assets/img/bandeau-email.jpg" 
                alt="Vite &amp; Gourmand" 
                width="600" 
                style="display: block; width: 100%; max-width: 600px; height: auto; border: 0;">';

        $imageBas = '<img src="https://restaurationviteetgourmand.alwaysdata.net/assets/img/cuistot.jpg" 
                alt="Vite &amp; Gourmand" 
                width="600" 
                style="display: block; width: 100%; max-width: 600px; height: auto; border: 0;">';

        $user = $this->commandes->findById($id);

        $conclusion = "<p>Bonjour {$user['nom_complet']}, votre commande {$user['numero_commande']} a été annulée. </p>
        <p>Pour toute question, n'hésitez pas à nous contacter.</p>
        <p>Vite &amp; Gourmand vous souhaite une bonne journée. </p>";
        $message =$imageHaut .  $conclusion . $bouton . $imageBas;

        $email = $user['utilisateur_email'];

        $this->mailService->sendEmail($email , $titre , $message);

        $successMessage = "Vous avez annulé la commande avec succés ." ;
        header('Location: /commandes-client?success=' . urlencode($successMessage));
        exit();
    }
}