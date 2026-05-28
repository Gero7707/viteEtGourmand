<?php
require_once __DIR__ . '/../services/MailService.php';
require_once __DIR__ . '/../models/HoraireModel.php';

class ContactController{
    private MailService $mailService;

    private HoraireModel $horaire;

    public function __construct(){
        $this->mailService = new MailService();
        $this->horaire = new HoraireModel();
    }

    public function showForm(){
        $horaire = $this->horaire->getHoraire();
        $email = $_SESSION['email'] ?? '';
        require_once __DIR__ . '/../views/contact/sendMessage.php';
    }

    public function sendMessage(){
        Auth::verifyCsrfToken();
        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        if (!$email ){
            $error = "L'adresse email n'est pas valide !";
            header('Location: /contact?error=' . urlencode($error));
            exit();
        }

        $titre =$_POST['titre'] ;
        if(empty(trim($titre))){
            $error = "Veuillez indiquer le sujet de votre message svp !";
            header('location: /contact?error=' . urlencode($error));
            exit();
        }

        $message = $_POST['message'];
        if(empty(trim($message))){
            $error = "Vous n'avez pas rédigé votre message !";
            header('location: /contact?error=' . urlencode($error));
            exit();
        }

        try{
            $emailRestaurant = getenv('CONTACT_EMAIL');
        
            $this->mailService->sendEmail($emailRestaurant,$titre,$message);
            $succesMessage = "Votre message a été envoyé avec succès . Il sera traité dans les plus brefs délais.";
            header('location: /contact?success=' . urlencode($succesMessage));
            exit();
        }catch(Exception $e){
            
            $error = "Une erreur est survenue lors de l'envoi du message. Veuillez réessayer.";
            header('location: /contact?error=' . urlencode($error));
            exit();
        }
    }
}