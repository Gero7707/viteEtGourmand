<?php
require_once __DIR__ . '/../models/CommandeModel.php';
require_once __DIR__ . '/../models/HoraireModel.php';
require_once __DIR__ . '/../models/MenuModel.php';
require_once __DIR__ . '/../services/GeoService.php';

class CommandeController{
    private HoraireModel $horaire;
    private CommandeModel $commandes;

    private MenuModel $menu;

    private GeoService $geo;

    public function __construct(){
        $this->commandes = new CommandeModel();
        $this->horaire = new HoraireModel();
        $this->menu = new MenuModel();
        $this->geo = new GeoService();
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
        $historique = $this->commandes->getHistorique($id);
        require_once __DIR__ . '/../views/commande/userCommande.php';
    }

    public function showForm(int $menu_id){
        Auth::checkAuth();
        $horaire = $this->horaire->getHoraire();
        $menu = $this->menu->findById($menu_id);
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
}