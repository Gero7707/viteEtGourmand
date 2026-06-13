<?php
require_once __DIR__ . '/../models/PlatModel.php';
require_once __DIR__ . '/../models/HoraireModel.php';
require_once __DIR__ . '/../models/AllergeneModel.php';

class PlatController{
    private PlatModel $plats;

    private HoraireModel $horaire;

    private AllergeneModel $allergenes;

    public function __construct(){
        $this->plats = new PlatModel();
        $this->horaire = new HoraireModel();
        $this->allergenes = new AllergeneModel();
    }

    public function showAllPlats(){
        $horaire = $this->horaire->getHoraire();
        $plat = $this->plats->getAllPlats();

        foreach($plat as &$p) {
            $p['allergenes'] = $this->plats->getPlatAllergenes($p['plat_id']);
            $p['menus_disponibles'] = $this->plats->getMenusDisponibles($p['plat_id']);
            $p['menus_du_plat'] = $this->plats->getMenusDuPlat($p['plat_id']);
        }
        unset($p);
        require_once __DIR__ . '/../views/employe/plats.php';
    }

    public function associerPlat(int $id){
        Auth::checkEmploye();
        Auth::verifyCsrfToken();
        $menu_id = $_POST['menu_id'];
        if(empty($menu_id)){
            $error = "Vous devez indiquer le menu à associer .";
            header('Location: /plats?error=' . urlencode($error));
            exit();
        }
        $this->plats->associerPlat($id ,(int)$menu_id);
        $succesMessage = "Vous avez associé le menu et le plat avec succès .";
        header('Location: /plats?success=' . urlencode($succesMessage));
        exit();
    }

    public function dissocierPlat(int $id){
        Auth::checkEmploye();
        Auth::verifyCsrfToken();
        $menu_id = $_POST['menu_id'];
        $this->plats->dissocierPlat($id);
        $succesMessage = "Vous avez dissocié le menu et le plat avec succès .";
        header('Location: /menus/'. $menu_id . '?success=' . urlencode($succesMessage));
        exit();
    }

    public function showCreatePlat(){
        Auth::checkEmploye();
        $horaire = $this->horaire->getHoraire();
        $allergenes = $this->allergenes->getAll();
        require_once __DIR__ . '/../views/employe/createPlat.php';
    }

    public function createPlat(){
        Auth::checkEmploye();
        Auth::verifyCsrfToken();

        $titrePlat = $_POST['titre_plat'];
        if(empty(trim($titrePlat))){
            $error = "Vous devez indiquer le titre du plat .";
            header('Location: /plats/create?error=' . urlencode($error));
            exit();
        }

        $typePlat = $_POST['type_plat'];
        if(empty(trim($typePlat))){
            $error = "Vous devez indiquer le type de plat.";
            header('Location: /plats/create?error=' . urlencode($error));
            exit();
        }

        $imgMenu = $_FILES['chemin_photo'];
        $extension = pathinfo($imgMenu['name'], PATHINFO_EXTENSION);
        $allergenes = $_POST['allergenes'] ?? [];
        $nomFichier = uniqid() . '.' . $extension;
        $data = [
            'titre_plat' => $titrePlat,
            'type_plat' => $typePlat,
            'chemin_photo' => "assets/img/plats/" . $nomFichier
        ];

        $source = $imgMenu['tmp_name'];

        $destination = __DIR__ .  "/../../public/assets/img/plats/" . $nomFichier;

        if($_FILES['chemin_photo']['error'] !== 0){
            $error = "Ce format n'est pas authorisé . ";
            header('Location: /plats/create?error=' . urlencode($error));
            exit();
        }

        if($imgMenu['size'] > 2 * 1024 * 1024){
            $error = "Le fichier est supérieur à 2mo . ";
            header('Location: /plats/create?error=' . urlencode($error));
            exit();
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($imgMenu['tmp_name']);

        $typesAutorises = ['image/jpeg', 'image/png', 'image/webp'];
        $extensionsAutorisees = ['jpg', 'jpeg', 'png', 'webp'];

        if(!in_array($mimeType, $typesAutorises)){
            $error = "Ce format n'est pas authorisé . ";
            header('Location: /plats/create?error=' . urlencode($error));
            exit();
        }

        if(!in_array($extension, $extensionsAutorisees)){
            $error = "Ce format n'est pas authorisé . ";
            header('Location: /plats/create?error=' . urlencode($error));
            exit();
        }
        
        $platId = $this->plats->createPlat($data);
        foreach($allergenes as $allergene_id){
            $this->plats->platLinkAllergene($platId, $allergene_id);
        }

        move_uploaded_file($source, $destination);

        $successMessage = "Le plat a été créé avec succès .";
        if ($_SESSION['role_id'] === 2){
            header('Location: /plats?success=' . urlencode($successMessage));
            exit();
        }elseif($_SESSION['role_id'] === 3){
            header('Location: /plats?success=' . urlencode($successMessage));
            exit();
        }
    }

    public function showEditPlat(int $id){
        Auth::checkEmploye();
        $horaire = $this->horaire->getHoraire();
        $plats = $this->plats->getPlatById($id);
        $allergenes =$this->allergenes->getAll();
        $allergenesPlat = $this->plats->getPlatAllergenes($id);
        $allergenesIds = array_column($allergenesPlat, 'allergene_id');
        require_once __DIR__ . '/../views/employe/updatePlat.php';
    }

    public function updatePlat(int $id){
        Auth::checkEmploye();
        Auth::verifyCsrfToken();
        $plat = $this->plats->getPlatById($id);
        $titrePlat = $_POST['titre_plat'];
        if(empty(trim($titrePlat))){
            $error = "Vous devez indiquer le titre du plat .";
            header('Location: /plats/edit/' . $id .'?error=' . urlencode($error));
            exit();
        }

        $typePlat = $_POST['type_plat'];
        if(empty(trim($typePlat))){
            $error = "Vous devez indiquer le type de plat .";
            header('Location: /plats/edit/' . $id .'?error=' . urlencode($error));
            exit();
        }

        $data = [
            'titre_plat' => $titrePlat,
            'type_plat' => $typePlat,
            'plat_id' => $id
        ];

        $allergenes = $_POST['allergenes'] ?? [];

        if($_FILES['chemin_photo']['error'] !== UPLOAD_ERR_NO_FILE){
            $imgMenu = $_FILES['chemin_photo'];
            $extension = pathinfo($imgMenu['name'], PATHINFO_EXTENSION);
            
            $nomFichier = uniqid() . '.' . $extension;
            $data = [
                'titre_plat' => $titrePlat,
                'type_plat' => $typePlat,
                'plat_id' => $id,
                'chemin_photo' => "assets/img/plats/" . $nomFichier
            ];

            $source = $imgMenu['tmp_name'];

            $destination = __DIR__ .  "/../../public/assets/img/plats/" . $nomFichier;

            if($_FILES['chemin_photo']['error'] !== 0){
                $error = "Ce format n'est pas authorisé . ";
                header('Location: /plats/edit/' . $id .'?error=' . urlencode($error));
                exit();
            }

            if($imgMenu['size'] > 2 * 1024 * 1024){
                $error = "Le fichier est supérieur à 2mo . ";
                header('Location: /plats/edit/' . $id .'?error=' . urlencode($error));
                exit();
            }

            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($imgMenu['tmp_name']);

            $typesAutorises = ['image/jpeg', 'image/png', 'image/webp'];
            $extensionsAutorisees = ['jpg', 'jpeg', 'png', 'webp'];

            if(!in_array($mimeType, $typesAutorises)){
                $error = "Ce format n'est pas authorisé . ";
                header('Location: /plats/edit' . $id .'?error=' . urlencode($error));
                exit();
            }

            if(!in_array($extension, $extensionsAutorisees)){
                $error = "Ce format n'est pas authorisé . ";
                header('Location: /plats/edit/' . $id .'?error=' . urlencode($error));
                exit();
            }
            if($plat['chemin_photo'] && file_exists(__DIR__ . "/../../public/" . $plat['chemin_photo'])){
                unlink(__DIR__ . "/../../public/" . $plat['chemin_photo']);
            }
            
            $this->plats->deleteImage($id);
            move_uploaded_file($source, $destination);
        }

        $this->plats->updatePlat($data);
        $this->plats->deleteAllergeneLink($id);
        foreach($allergenes as $allergene_id){
            $this->plats->platLinkAllergene($id, $allergene_id);
        }

        $successMessage = "Le plat a été modifié avec succès .";
        if ($_SESSION['role_id'] === 2){
            header('Location: /plats?success=' . urlencode($successMessage));
            exit();
        }elseif($_SESSION['role_id'] === 3){
            header('Location: /plats?success=' . urlencode($successMessage));
            exit();
        }
    }

    public function deletePlat(int $id){
        Auth::checkEmploye();
        Auth::verifyCsrfToken();
        $plat = $this->plats->getPlatById($id);
        $commandes = $this->plats->PlatLinkCommande($id);
        if($commandes['COUNT(*)'] > 0 ){
            $error = "Vous ne pouvez pas supprimer un plat d'un menu  avec des commandes en cours ";
            header('Location: /plats?error=' . urlencode($error));
            exit();
        }
        if($plat['chemin_photo']  && file_exists(__DIR__ . "/../../public/" . $plat['chemin_photo'])){
            unlink(__DIR__ . "/../../public/" . $plat['chemin_photo']);
        }

        $this->plats->deleteAllergeneLink($id);
        $this->plats->deleteMenuPlatLink($id);
        $this->plats->deletePlat($id);

        $successMessage = "Le plat a été supprimé avec succès .";
        if ($_SESSION['role_id'] === 2){
            header('Location: /plats?success=' . urlencode($successMessage));
            exit();
        }elseif($_SESSION['role_id'] === 3){
            header('Location: /plats?success=' . urlencode($successMessage));
            exit();
        }

    }
}
