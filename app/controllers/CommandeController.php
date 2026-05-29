<?php
require_once __DIR__ . '/../models/CommandeModel.php';
require_once __DIR__ . '/../models/HoraireModel.php';
require_once __DIR__ . '/../models/MenuModel.php';
require_once __DIR__ . '/../app/services/OrsService.php';

class CommandeController{
    private HoraireModel $horaire;
    private CommandeModel $commandes;

    private MenuModel $menu;

    private OrsService $ors;

    public function __construct(){
        $this->commandes = new CommandeModel();
        $this->horaire = new HoraireModel();
        $this->menu = new MenuModel();
        $this->ors = new OrsService();
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
            'adresse' => $_SESSION['adresse'] ?? '' ,
            'ville' => $_SESSION['ville'] ?? '' ,
            'code_postal' => $_SESSION['code_postal'] ?? '' 
        ];
        require_once __DIR__ . '/../views/commande/commandeForm.php';
    }

    public function calculFrais(){
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        $menu = $this->menu->findById($data['menu_id']);
        $adresse = $data['adresse'] . ', ' . $data['code_postal'] . ' '. $data['ville'];
        $codePostal = $data['code_postal'];
        $prixParPersonne = $menu['prix_par_personne'];
        $nbPersonnes = $data['nombre_personne'];
        $nbPersonneMini = $menu['nombre_personne_minimum'];
        $fraisLivraison = 0;
        $estABordeaux = in_array($codePostal, ['33000', '33100', '33200', '33300', '33800']);
        if ($nbPersonnes < $nbPersonneMini + 5 && $nbPersonnes >= $nbPersonneMini){
            $prixMenu = ($nbPersonnes * $prixParPersonne)  ;
        }elseif($nbPersonnes >= $nbPersonneMini + 5){
            $prixMenu = ($nbPersonnes * $prixParPersonne) * 0.90;
        }else{
            echo json_encode(['success' => false, 'message' => 'Vous n\'avez pas le nombre de personnes minimum pour ce menu !']);
            exit;
        }

        if($estABordeaux){
            $distance = 0;
            $prixTotal = $prixMenu + $fraisLivraison ;
            echo json_encode(['success' => true, 'prix_menu' => $prixMenu, 'frais_livraison' => $fraisLivraison , 'prix_total' => $prixTotal,'distance_km' => $distance]);
            exit;
        }else{
            try{
                $coords = $this->ors->geocode($adresse);
                $distance = $this->ors->getDistanceKm($coords['lat'], $coords['lng']);
                $fraisLivraison = ($distance * 0.59) + 5 ;
                $prixTotal = $prixMenu + $fraisLivraison;
                echo json_encode(['success' => true, 'prix_menu' => $prixMenu, 'frais_livraison' => $fraisLivraison , 'prix_total' => $prixTotal,'distance_km' => $distance]);
                exit;
            }catch(Exception $e){
                echo json_encode(['success' => false, 'message' => 'Votre adresse n\'a pas été trouvé . Veuillez recommencer  !']);
                exit;
            }
        }
    }
}