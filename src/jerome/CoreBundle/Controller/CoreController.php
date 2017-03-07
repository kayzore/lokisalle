<?php
namespace src\jerome\CoreBundle\Controller;


use jerome\CoreBundle\Model\Membre;
use kayzore\bundle\KBundle\Controller;

class CoreController extends Controller
{
    public function homeAction()
    {
        echo $this->twig->render('front/accueil.html.twig', array(
            'membres' => Membre::fetchAll()
        ));
    }

    public function inscriptionAction()
    {
        // Inscription
        echo $this->twig->render('front/inscription.html.twig');
    }

    public function executeInscriptionAction()
    {
        // Execute Inscription
        $membre = new Membre();
        $errors = [];
        if (!empty($_POST)) {
            $membre
                ->setPseudo($_POST['pseudoInput'])
                ->setNom($_POST['nomInput'])
                ->setPrenom($_POST['prenomInput'])
                ->setEmail($_POST['emailInput'])
                ->setCivilite($_POST['civiliteSelect'])
            ;

            if (!Membre::validatePseudo($_POST['pseudoInput'], $msg)) {
                $errors['pseudoInput'] = $msg;
            }

            if (!Membre::validateNom($_POST['nomInput'], $msg)) {
                $errors['nomInput'] = $msg;
            }

            if (!Membre::validatePrenom($_POST['prenomInput'], $msg)) {
                $errors['prenomInput'] = $msg;
            }

            if (!Membre::validateEmail($_POST['emailInput'], $msg)) {
                $errors['emailInput'] = $msg;
            }

            if (!Membre::validatePassword($_POST['passwordInput'], $msg)) {
                $errors['passwordInput'] = $msg;
            }
        }
    }

    public function connexionAction()
    {
        // Connexion
        Membre::connexion('johndoe', 'johndoe');
    }

    public function executeConnexionAction()
    {
        // Execute Connexion
    }

    public function deconnexionAction()
    {
        Membre::deconnexion();
        $this->redirect('public.ls_connexion');
    }
}