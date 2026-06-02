<?php
require_once __DIR__ . '/../models/MenuModel.php';
require_once __DIR__ . '/../models/HoraireModel.php';
require_once __DIR__ . '/../models/RegimeModel.php';
require_once __DIR__ . '/../models/ThemeModel.php';

class MenuController{
    private MenuModel $menus;

    private HoraireModel $horaire;

    private RegimeModel $regimes;

    private ThemeModel $themes;

    public function __construct(){
        $this->menus = new MenuModel();
        $this->horaire = new HoraireModel();
        $this->themes = new ThemeModel();
        $this->regimes = new RegimeModel();
    }

    public function index(){
        $menus = $this->menus->index();
        $horaire = $this->horaire->getHoraire();
        require_once __DIR__ . '/../views/menus/menus.php';
    }

    public function show(int $id){
        $horaire = $this->horaire->getHoraire();
        $menus = $this->menus->findById($id);
        $plat = $this->menus->getMenuPlats($id);
        // Pour chaque plat, on récupère ses allergènes et on les attache au plat
        // Le & permet de modifier directement le tableau $plat (passage par référence)
        foreach($plat as &$p) {
            $p['allergenes'] = $this->menus->getPlatAllergenes($p['plat_id']);
        }
        unset($p); // Casse la référence pour éviter le bug variable de référence reste liée au dernier élément du tableau après la boucle
        require_once __DIR__ . '/../views/menus/carteMenu.php';
    }

    public function showAllPlats(){
        $horaire = $this->horaire->getHoraire();
        $plat = $this->menus->getAllPlats();
        foreach($plat as &$p) {
            $p['allergenes'] = $this->menus->getPlatAllergenes($p['plat_id']);
        }
        unset($p);
        require_once __DIR__ . '/../views/employe/plats.php';
    }

    public function showFormMenu(){
        Auth::checkEmploye();
        $horaire = $this->horaire->getHoraire();
        $menu = $this->menus->getOneMenu();
        $regimes =$this->regimes->getAll();
        $themes = $this->themes->getAll();
        require_once __DIR__ . '/../views/employe/createMenu.php';
    }

    public function createMenu(){
        Auth::checkEmploye();
        Auth::verifyCsrfToken();

        $selectTheme = $_POST['theme_id'];
        if(empty($selectTheme)){
            $error = "Vous devez indiquer le thème  svp.";
            header('Location: /create-menu?error=' . urlencode($error));
            exit();
        }

        $selectRegime = $_POST['regime_id'];
        if(empty($selectRegime)){
            $error = "Vous devez indiquer le régime  svp.";
            header('Location: /create-menu?error=' . urlencode($error));
            exit();
        }

        $titreMenu = $_POST['titre'];
        if(empty(trim($titreMenu))){
            $error = "Vous devez indiquer le titre du menu  svp.";
            header('Location: /create-menu?error=' . urlencode($error));
            exit();
        }

        $nbPersonneMini = $_POST['nombre_personne_minimum'];
        if(empty(trim($nbPersonneMini))){
            $error = "Vous devez indiquer le nombre de personne minimum  svp.";
            header('Location: /create-menu?error=' . urlencode($error));
            exit();
        }

        $prixParPersonne = $_POST['prix_par_personne'];
        if(empty(trim($prixParPersonne))){
            $error = "Vous devez indiquer le prix par personne  svp.";
            header('Location: /create-menu?error=' . urlencode($error));
            exit();
        }

        $description = $_POST['description'];
        if(empty(trim($description))){
            $error = "Vous devez indiquer la description du menu  svp.";
            header('Location: /create-menu?error=' . urlencode($error));
            exit();
        }

        $quantiteDispo = $_POST['quantite_restante'];
        if(empty(trim($quantiteDispo))){
            $error = "Vous devez indiquer la quantité disponible  svp.";
            header('Location: /create-menu?error=' . urlencode($error));
            exit();
        }

        $delais = $_POST['conditions_delai'];
        if(empty(trim($delais))){
            $error = "Vous devez indiquer les conditions de délais  svp.";
            header('Location: /create-menu?error=' . urlencode($error));
            exit();
        }

        $stockage = $_POST['conditions_stockage'];
        if(empty(trim($stockage))){
            $error = "Vous devez indiquer les conditions de stockage  svp.";
            header('Location: /create-menu?error=' . urlencode($error));
            exit();
        }

        $infos = $_POST['conditions_infos'];
        if(empty(trim($infos))){
            $error = "Vous devez indiquer les informations supplémentaires  svp.";
            header('Location: /create-menu?error=' . urlencode($error));
            exit();
        }

        $data = [
            'theme_id' => $selectTheme,
            'regime_id' => $selectRegime,
            'titre' => $titreMenu,
            'nombre_personne_minimum' => $nbPersonneMini,
            'prix_par_personne' => $prixParPersonne,
            'description' => $description,
            'quantite_restante' => $quantiteDispo,
            'conditions_delai' => $delais,
            'conditions_stockage' => $stockage,
            'conditions_infos'=> $infos
        ];

        

        $imgMenu = $_FILES['img_menu'];

        $extension = pathinfo($imgMenu['name'], PATHINFO_EXTENSION);

        $nomFichier = uniqid() . '.' . $extension;

        $source = $imgMenu['tmp_name'];

        $destination = __DIR__ .  "/../../public/assets/img/menus/" . $nomFichier;

        if($_FILES['img_menu']['error'] !== 0){
            $error = "Ce format n'est pas authorisé . ";
            header('Location: /create-menu?error=' . urlencode($error));
            exit();
        }

        if($imgMenu['size'] > 2 * 1024 * 1024){
            $error = "Le fichier est supérieur à 2mo . ";
            header('Location: /create-menu?error=' . urlencode($error));
            exit();
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($imgMenu['tmp_name']);

        $typesAutorises = ['image/jpeg', 'image/png', 'image/webp'];
        $extensionsAutorisees = ['jpg', 'jpeg', 'png', 'webp'];

        if(!in_array($mimeType, $typesAutorises)){
            $error = "Ce format n'est pas authorisé . ";
            header('Location: /create-menu?error=' . urlencode($error));
            exit();
        }

        if(!in_array($extension, $extensionsAutorisees)){
            $error = "Ce format n'est pas authorisé . ";
            header('Location: /create-menu?error=' . urlencode($error));
            exit();
        }

        

        $menuId = $this->menus->createMenu($data);

        move_uploaded_file($source, $destination);

        $data = [
            'chemin' => "assets/img/menus/" . $nomFichier,
            'menu_id' =>$menuId
        ];

        $this->menus->addImageMenu($data);

        $successMessage = "Le menu a été créé avec succès .";
        if ($_SESSION['role_id'] === 2){
            header('Location: /employe/dashboard?success=' . urlencode($successMessage));
            exit();
        }elseif($_SESSION['role_id'] === 3){
            header('Location: /admin/dashboard?success=' . urlencode($successMessage));
            exit();
        }
    }
}