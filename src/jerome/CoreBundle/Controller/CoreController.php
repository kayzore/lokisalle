<?php
namespace src\jerome\CoreBundle\Controller;


use jerome\CoreBundle\Model\Membre;
use kayzore\bundle\KBundle\Controller;
use kayzore\bundle\Utils\FlashMessage;

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
                $errors['pseudoInput'] = [$msg, $_POST['pseudoInput']];
            }

            if (!Membre::validateNom($_POST['nomInput'], $msg)) {
                $errors['nomInput'] = [$msg, $_POST['nomInput']];
            }

            if (!Membre::validatePrenom($_POST['prenomInput'], $msg)) {
                $errors['prenomInput'] = [$msg, $_POST['prenomInput']];
            }

            if (!Membre::validateEmail($_POST['emailInput'], $msg)) {
                $errors['emailInput'] = [$msg, $_POST['emailInput']];
            }

            if (!Membre::validatePassword($_POST['passwordInput'], $msg)) {
                $errors['passwordInput'] = [$msg, $_POST['passwordInput']];
            }

            if (empty($errors)) {
                $membre->save();
                FlashMessage::set("Inscription effectuée, vous pouvez maintenant vous connecter");
                $this->redirect('public.ls_connexion');
            } else {
                FlashMessage::set('Le formulaire contient des erreurs', 'error', $errors);
                $this->redirect('public.ls_inscription');
            }
        }
    }

    public function connexionAction()
    {
        // Connexion
        echo $this->twig->render('front/connexion.html.twig');
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